'use strict';

const segment = require('./segmenter').segment;

function hlsSegment (input, segmentLength, startOffset) {

  if (typeof startOffset === 'undefined') {
    startOffset = '900000';
  }

  const segments = segment(input, segmentLength);

  const result = [];
  segments.forEach((seg, i) => {

    const content = `WEBVTT
X-TIMESTAMP-MAP=MPEGTS:${startOffset},LOCAL:00:00:00.000

${printableCues(seg.cues)}
`;
    const filename = generateSegmentFilename(i);
    result.push({ filename, content });
  });
  return result;
}

function hlsSegmentPlaylist (input, segmentLength) {

  const segmented = segment(input, segmentLength);

  const printable = printableSegments(segmented);
  const longestSegment = Math.round(findLongestSegment(segmented));

  const template = `#EXTM3U
#EXT-X-TARGETDURATION:${longestSegment}
#EXT-X-VERSION:3
#EXT-X-MEDIA-SEQUENCE:0
#EXT-X-PLAYLIST-TYPE:VOD
${printable}
#EXT-X-ENDLIST
`;
  return template;
}

function pad (num, n) {
  const padding = '0'.repeat(Math.max(0, n - num.toString().length));

  return `${padding}${num}`;
}

function generateSegmentFilename (index) {
  return `${index}.vtt`;
}

function printableSegments (segments) {
  const result = [];
  segments.forEach((seg, i) => {
    result.push(`#EXTINF:${seg.duration.toFixed(5)},
${generateSegmentFilename(i)}`);
  });

  return result.join('\n');
}

function findLongestSegment (segments) {
  let max = 0;
  segments.forEach((seg) => {
    if (seg.duration > max) {
      max = seg.duration;
    }
  });

  return max;
}

function printableCues (cues) {
  const result = [];
  cues.forEach((cue) => {
    result.push(printableCue(cue));
  });

  return result.join('\n\n');
}

function printableCue (cue) {
  const printable = [];

  if (cue.identifier) {
    printable.push(cue.identifier);
  }

  const start = printableTimestamp(cue.start);
  const end = printableTimestamp(cue.end);

  const styles = cue.styles ? `${cue.styles}` : '';

  // always add a space after end timestamp, otherwise JWPlayer will not
  // handle cues correctly
  printable.push(`${start} --> ${end} ${styles}`);

  printable.push(cue.text);

  return printable.join('\n');
}

function printableTimestamp (timestamp) {
  const ms = (timestamp % 1).toFixed(3);
  timestamp = Math.round(timestamp - ms);
  const hours = Math.floor(timestamp / 3600);
  const mins = Math.floor((timestamp - (hours * 3600)) / 60);
  const secs = timestamp - (hours * 3600) - (mins * 60);

  // TODO hours aren't required by spec, but we include them, should be config
  const hourString = `${pad(hours, 2)}:`;
  return `${hourString}${pad(mins, 2)}:${pad(secs, 2)}.${pad(ms * 1000, 3)}`;
}

module.exports = { hlsSegment, hlsSegmentPlaylist };
