import { PitchDetector } from 'pitchy';
import { Renderer, Stave, StaveNote, Voice, Formatter, Accidental } from 'vexflow';

const NAMES = ['c','c#','d','d#','e','f','f#','g','g#','a','a#','b'];
const notes = [];            // notas registradas
const PER_MEASURE = 4, MEASURES_PER_ROW = 4, W = 220;

function freqToNote(f) {
    const midiSounding = Math.round(69 + 12 * Math.log2(f / 440));

    // Clarinete en Sib: la nota escrita está 2 semitonos por encima
    const midiWritten = midiSounding + 2;

    const name = NAMES[((midiWritten % 12) + 12) % 12];
    const octave = Math.floor(midiWritten / 12) - 1;

    return {
        midi: midiWritten,
        key: `${name}/${octave}`,
        soundingMidi: midiSounding
    };
}

function drawScore() {
    const div = document.getElementById('score');
    div.innerHTML = '';
    const measures = Math.max(1, Math.ceil(notes.length / PER_MEASURE));
    const rows = Math.ceil(measures / MEASURES_PER_ROW);
    const renderer = new Renderer(div, Renderer.Backends.SVG);
    renderer.resize(W * MEASURES_PER_ROW + 20, rows * 140);
    const ctx = renderer.getContext();

    for (let m = 0; m < measures; m++) {
        const x = 10 + (m % MEASURES_PER_ROW) * W;
        const y = Math.floor(m / MEASURES_PER_ROW) * 140;
        const stave = new Stave(x, y, W);
        if (m % MEASURES_PER_ROW === 0) stave.addClef('treble');
        stave.setContext(ctx).draw();

        const chunk = notes.slice(m * PER_MEASURE, (m + 1) * PER_MEASURE);
        if (!chunk.length) continue;
        const vexNotes = chunk.map(key => {
            const n = new StaveNote({ keys: [key], duration: 'q' });
            if (key.includes('#')) n.addModifier(new Accidental('#'), 0);
            return n;
        });
        const voice = new Voice({ numBeats: chunk.length, beatValue: 4 }).setStrict(false);
        voice.addTickables(vexNotes);
        new Formatter().joinVoices([voice]).format([voice], W - 60);
        voice.draw(ctx, stave);
    }
}

async function start() {
    const stream = await navigator.mediaDevices.getUserMedia({
        audio: { echoCancellation: false, noiseSuppression: false, autoGainControl: false },
    });
    const audioCtx = new AudioContext();
    const analyser = audioCtx.createAnalyser();
    analyser.fftSize = 8192;
    audioCtx.createMediaStreamSource(stream).connect(analyser);

    const detector = PitchDetector.forFloat32Array(analyser.fftSize);
    const buf = new Float32Array(analyser.fftSize);

    let candidate = null, count = 0, lastRegistered = null;

    (function tick() {
        analyser.getFloatTimeDomainData(buf);
        const [pitch, clarity] = detector.findPitch(buf, audioCtx.sampleRate);

        if (clarity > 0.85 && pitch > 70 && pitch < 1600) {
            const { midi, key } = freqToNote(pitch);
            document.getElementById('actual').textContent = key;
            if (midi === candidate) count++; else { candidate = midi; count = 1; }
            // la nota debe mantenerse ~6 frames para evitar ruido
            if (count === 6 && midi !== lastRegistered) {
                notes.push(key);
                lastRegistered = midi;
                drawScore();
            }
        } else {
            candidate = null; count = 0;
            if (clarity < 0.5) lastRegistered = null; // silencio: permite repetir la misma nota
        }
        requestAnimationFrame(tick);
    })();
}

document.getElementById('start').addEventListener('click', start);
drawScore();
