#!/usr/bin/env node
'use strict';

const fs = require('fs');
const path = require('path');
const hls = require('../lib/hls');
const program = require('commander');

program
  .version('0.0.1')
  .usage('[options] <webvtt file>')
  .option('-t, --target-duration [duration]',
    'Target duration for each segment in secods, defaults to 10',
    parseInt,
    10)
  .option('-o, --output-directory [dir]',
    'Output directory for segments and playlist')
  .option('-v, --verbose', 'Chatty output')
  .option('-s, --silent', 'No output')
  .parse(process.argv);

const input = program.args;

const t = program.targetDuration || 10;
const outputDir = program.outputDirectory || './';

log('Hi there! Let’s try and parse and segment a webvtt file, shall we');
log(`Output directory is: ${outputDir}`);
log(`Target duration is: ${t}`);

if (input.length > 1) {
  fail('Too many inputs, only supports one file');
}

if (input.length === 0) {
  fail('Missing input file');
}

const file = input[0];
let content = '';

try {
  content = read(file);
  log(`Read "${input}"`);
} catch (e) {
  fail(`Could not read "${input}"`, e);
}

let playlist = '';

try {
  log(`Creating playlist for "${input}" with ${t} sec segments`);
  playlist = hls.hlsSegmentPlaylist(content, t);
} catch (e) {
  fail(`Unable to create playlist for "${input}"`, e);
}

const playlistFilename = 'playlist.m3u8';
const target = path.join(outputDir, playlistFilename);

try {
  log(`Writing ${playlist.length} bytes (utf-8) to "${playlistFilename}"`);
  fs.writeFileSync(target, playlist, 'utf-8');
  log(`Wrote "${playlistFilename}"`);
} catch (e) {
  fail(`Unable to write playlist "${target}"`, e);
}

let segments = [];

try {
  log(`Segmenting "${input}" (${content.length} bytes) with ${t} sec segments`);
  segments = hls.hlsSegment(content, t);
} catch (e) {
  fail(`Unable to segment playlist for "${input}"`, e);
}

const n = segments.length;
let dotdotdot = false;
log(`Writing ${n} segments`);
segments.forEach((segment, i) => {
  const filename = segment.filename;
  const targetFile = path.join(outputDir, filename);

  try {
    fs.writeFileSync(targetFile, segment.content, 'utf-8');
  } catch (e) {
    fail(`Failed writing ${filename}, aborting. Wrote ${i + 1} segments.`, e);
  }

  const range = 5;

  if ((0 <= i && i < range) || (n - range <= i && i <= n)) {
    log(`Wrote segment ${targetFile}`);
  } else {
    if (!dotdotdot) {
      log('...');
      dotdotdot = true;
    }
  }
});
log('Finished writing segments');

/** Helpers **/

function read (targetFile) {
  log(`Trying to read "${targetFile}"`);
  const stats = fs.statSync(targetFile);

  if (!stats.isFile()) {
    fail(`"${targetFile}" is not a file`);
  }

  log(`"${targetFile}" is a file, reading and assuming UTF-8`);
  let data = fs.readFileSync(targetFile, 'utf-8');

  data = data.replace( /^\uFEFF/, '' );

  return data;
}

function log (m) {
  if (program.verbose && !program.silent) {
    console.log(m);
  }
}

function fail (m, e) {
  if (!program.silent) {
    console.log(m);

    if (e) {
      console.log(`Exception: ${e.stack}`);
    }
  }

  process.exit(1);
}
