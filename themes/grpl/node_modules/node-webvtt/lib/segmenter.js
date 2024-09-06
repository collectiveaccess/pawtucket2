'use strict';

const parse = require('./parser').parse;

function segment (input, segmentLength) {
  segmentLength = segmentLength || 10;

  const parsed = parse(input);
  const segments = [];

  let cues = [];
  let queuedCue = null;
  let currentSegmentDuration = 0;
  let totalSegmentsDuration = 0;

  /**
   * One pass segmenting of cues
   */
  parsed.cues.forEach((cue, i) => {
    const firstCue = i === 0;
    const lastCue = i === parsed.cues.length - 1;
    const start = cue.start;
    const end = cue.end;
    const nextStart = lastCue ? Infinity : parsed.cues[i + 1].start;
    const cueLength = firstCue ? end : end - start;
    const silence = firstCue ? 0 : (start - parsed.cues[i - 1].end);

    currentSegmentDuration = currentSegmentDuration + cueLength + silence;

    debug('------------');
    debug(`Cue #${i}, segment #${segments.length + 1}`);
    debug(`Start ${start}`);
    debug(`End ${end}`);
    debug(`Length ${cueLength}`);
    debug(`Total segment duration = ${totalSegmentsDuration}`);
    debug(`Current segment duration = ${currentSegmentDuration}`);
    debug(`Start of next = ${nextStart}`);

    // if there's a boundary cue queued, push and clear queue
    if (queuedCue) {
      cues.push(queuedCue);
      currentSegmentDuration += queuedCue.end - totalSegmentsDuration;
      queuedCue = null;
    }

    cues.push(cue);

    // if a cue passes a segment boundary, it appears in both
    let shouldQueue = nextStart - end < segmentLength &&
                        silence < segmentLength &&
                        currentSegmentDuration > segmentLength;

    if (shouldSegment(totalSegmentsDuration, segmentLength, nextStart,
      silence)) {

      const duration = segmentDuration(lastCue, end, segmentLength,
        currentSegmentDuration,
        totalSegmentsDuration);

      segments.push({ duration, cues });

      totalSegmentsDuration += duration;
      currentSegmentDuration = 0;
      cues = [];
    } else {
      shouldQueue = false;
    }

    if (shouldQueue) {
      queuedCue = cue;
    }
  });

  return segments;
}

function shouldSegment (total, length, nextStart, silence) {

  // this is stupid, but gets one case fixed...
  const x = alignToSegmentLength(silence, length);
  const nextCueIsInNextSegment = silence <= length ||
                                 x + total < nextStart;

  return nextCueIsInNextSegment && nextStart - total >= length;
}

function segmentDuration (lastCue, end, length, currentSegment, totalSegments) {
  let duration = length;

  if (currentSegment > length) {
    duration = alignToSegmentLength(currentSegment - length, length);
  }

  // make sure the last cue covers the whole time of the cues
  if (lastCue) {
    duration = parseFloat((end - totalSegments).toFixed(2));
  } else {
    duration = Math.round(duration);
  }

  return duration;
}

function alignToSegmentLength (n, segmentLength) {
  n += segmentLength - n % segmentLength;
  return n;
}

const debugging = false;

/* istanbul ignore next */
function debug (m) {
  if (debugging) {
    console.log(m);
  }
}

module.exports = { segment };
