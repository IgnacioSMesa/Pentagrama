// ───────────── 1. CATÁLOGO DE INSTRUMENTOS ─────────────
// transpose = semitonos que se suman al sonido real para obtener la nota ESCRITA
// clef      = clave del pentagrama (treble, bass, alto)
// minHz/maxHz = rango de frecuencias SONORAS que aceptamos (filtra ruido)
export const INSTRUMENTS = {
    clarinete:      { label: 'Clarinete en Si♭',      transpose: 2,  clef: 'treble', minHz: 130, maxHz: 1600 },
    clarineteBajo:  { label: 'Clarinete bajo en Si♭', transpose: 14, clef: 'treble', minHz: 60,  maxHz: 800  },
    saxSoprano:     { label: 'Saxofón soprano',       transpose: 2,  clef: 'treble', minHz: 200, maxHz: 1600 },
    saxAlto:        { label: 'Saxofón alto',          transpose: 9,  clef: 'treble', minHz: 130, maxHz: 1100 },
    saxTenor:       { label: 'Saxofón tenor',         transpose: 14, clef: 'treble', minHz: 100, maxHz: 800  },
    saxBaritono:    { label: 'Saxofón barítono',      transpose: 21, clef: 'treble', minHz: 60,  maxHz: 600  },
    trompeta:       { label: 'Trompeta en Si♭',       transpose: 2,  clef: 'treble', minHz: 150, maxHz: 1200 },
    trompa:         { label: 'Trompa en Fa',          transpose: 7,  clef: 'treble', minHz: 60,  maxHz: 700  },
    flauta:         { label: 'Flauta',                transpose: 0,  clef: 'treble', minHz: 240, maxHz: 2200 },
    oboe:           { label: 'Oboe',                  transpose: 0,  clef: 'treble', minHz: 220, maxHz: 1800 },
    fagot:          { label: 'Fagot',                 transpose: 0,  clef: 'bass',   minHz: 55,  maxHz: 600  },
    violin:         { label: 'Violín',                transpose: 0,  clef: 'treble', minHz: 190, maxHz: 2200 },
    viola:          { label: 'Viola',                 transpose: 0,  clef: 'alto',   minHz: 125, maxHz: 1300 },
    violonchelo:    { label: 'Violonchelo',           transpose: 0,  clef: 'bass',   minHz: 60,  maxHz: 1000 },
    trombon:        { label: 'Trombón',               transpose: 0,  clef: 'bass',   minHz: 75,  maxHz: 700  },
    tuba:           { label: 'Tuba',                  transpose: 0,  clef: 'bass',   minHz: 40,  maxHz: 400  },
    piano:          { label: 'Piano / voz (Do)',      transpose: 0,  clef: 'treble', minHz: 70,  maxHz: 1600 },
};
