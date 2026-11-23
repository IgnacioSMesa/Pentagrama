import { PitchDetector } from 'pitchy';
import { Renderer, Stave, StaveNote, Voice, Formatter, Accidental } from 'vexflow';
import {INSTRUMENTS} from "./instruments/instruments.js";

const NAMES = ['c','c#','d','d#','e','f','f#','g','g#','a','a#','b'];

let instrument;
const notes = [];            // notas registradas
const PER_MEASURE = 4, MEASURES_PER_ROW = 4, W = 220;

function midiToKey(midi) {
    const name = NAMES[((midi % 12) + 12) % 12];
    const octave = Math.floor(midi / 12) - 1;
    return `${name}/${octave}`;

}
// nota escrita para el instrumento actual (se calcula al pintar, así cambiar de instrumento re-transpone)
function writtenKey(soundingMidi) {
    return midiToKey(soundingMidi + instrument.transpose);

}

function freqToMidi(frequency) {
    return Math.round(69 + 12 * Math.log2(frequency / 440));

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
        if (m % MEASURES_PER_ROW === 0) stave.addClef(instrument.clef);
        stave.setContext(ctx).draw();

        const chunk = notes.slice(m * PER_MEASURE, (m + 1) * PER_MEASURE);
        if (!chunk.length) continue;
        const vexNotes = chunk.map(soundingMidi => {
            const key = writtenKey(soundingMidi);

            // Pasar la clave a StaveNote o en clave de fa/do se pintaría mal
            const n = new StaveNote({ keys: [key], duration: 'q', clef: instrument.clef });
            if (key.includes('#')) n.addModifier(new Accidental('#'), 0);
            return n;
        });
        const voice = new Voice({ numBeats: chunk.length, beatValue: 4 }).setStrict(false);
        voice.addTickables(vexNotes);
        new Formatter().joinVoices([voice]).format([voice], W - 60);
        voice.draw(ctx, stave);
    }
}

// Selector de instrumento
function setupInstrumentSelect() {
    const select = document.getElementById('instrument');

    for (const [id, inst] of Object.entries(INSTRUMENTS)){
        select.add(new Option(inst.label, id));

    }

    const apply = () => { instrument = INSTRUMENTS[select.value]; };
    apply(); // Valor inicial del select

    select.addEventListener('change', () => {
        apply()
        drawScore()
    })

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

        // el rango depende del instrumento elegido (se lee en cada frame)
        if (clarity > 0.85 && pitch > instrument.minHz && pitch < instrument.maxHz) {

            const midi = freqToMidi(pitch); // MIDI sonoro

            document.getElementById('actual').textContent = writtenKey(midi);
            if (midi === candidate) count++; else { candidate = midi; count = 1; }

            // la nota debe mantenerse ~6 frames para evitar ruido
            if (count === 6 && midi !== lastRegistered) {
                notes.push(midi);
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

setupInstrumentSelect()
document.getElementById('start').addEventListener('click', start);
drawScore();
