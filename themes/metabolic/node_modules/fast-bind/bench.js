'use strict';
var Benchmark = require('benchmark')
  , assert = global.assert = require('assert')
  , suite = new Benchmark.Suite()

var f = global.f = function f(a, b, c) {
  return a + b + c
}

Function.prototype.bindSlice = require('./bind-slice')
Function.prototype.bindConcat = require('./bind-concat')
Function.prototype.bindLoop = require('./bind-loop')

suite // native must come first
  .add('Function#bind (native)', function() {
    assert.equal(f.bind(null, 1, 2)(3), 6)
  })
  .add('Function#bind (slice)', function() {
    assert.equal(f.bindSlice(null, 1, 2)(3), 6)
  })
  .add('Function#bind (concat)', function() {
    assert.equal(f.bindConcat(null, 1, 2)(3), 6)
  })
  .add('Function#bind (loop)', function() {
    assert.equal(f.bindLoop(null, 1, 2)(3), 6)
  })
  .on('cycle', function(e) {
    console.log(String(e.target))
  })
  .on('complete', function() {
    var fastest = this.filter('fastest')
    console.log('Fastest is ' + fastest.pluck('name'))
    var native = this[0]
    console.log((fastest.pluck('hz') / native.hz).toFixed(2) + 'x as fast as ' + native.name)

    assert.equal(fastest.pluck('name'), 'Function#bind (loop)')
  })
  .run({ async: true })
