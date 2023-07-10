var brackets2dots = require('..');
var assert = require('assert');

describe('brackets2dots()', function(){

  var cases = [
    { input: 'group[0].section.a.seat[3]', expected: 'group.0.section.a.seat.3' },
    { input: '[0].section.a.seat[3]', expected: '0.section.a.seat.3' },
    { input: 'company.people[*].name', expected: 'company.people.*.name' }
  ];

  cases.forEach(function (test) {

    it(test.input + ' => ' + test.expected, function() {
      assert.equal(brackets2dots(test.input), test.expected);
    });

  });

});
