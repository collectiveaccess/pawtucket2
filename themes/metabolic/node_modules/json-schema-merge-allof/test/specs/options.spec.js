var chai = require('chai')
var merger = require('../../src')

var expect = chai.expect

describe('options', function() {
  it('allows otherwise incompatible properties if option ignoreAdditionalProperties is true', function() {
    var result = merger({
      allOf: [{
        properties: {
          foo: true
        },
        additionalProperties: true
      }, {
        properties: {
          bar: true
        },
        additionalProperties: false
      }]
    }, {
      ignoreAdditionalProperties: true
    })

    expect(result).to.eql({
      properties: {
        foo: true,
        bar: true
      },
      additionalProperties: false
    })

    var result2 = merger({
      allOf: [{
        additionalProperties: true
      }, {
        additionalProperties: true
      }]
    })

    expect(result2).to.eql({})
  })

  it('ignoreAdditionalProperties is true, also allows merging of patternProperties', function() {
    var result = merger({
      allOf: [{
        properties: {
          foo: true
        },
        patternProperties: {
          '^abc': true
        },
        additionalProperties: true
      }, {
        properties: {
          bar: true
        },
        patternProperties: {
          '123$': true
        },
        additionalProperties: false
      }]
    }, {
      ignoreAdditionalProperties: true
    })

    expect(result).to.eql({
      properties: {
        foo: true,
        bar: true
      },
      patternProperties: {
        '^abc': true,
        '123$': true
      },
      additionalProperties: false
    })

    var result2 = merger({
      allOf: [{
        additionalProperties: true
      }, {
        additionalProperties: true
      }]
    })

    expect(result2).to.eql({})
  })

  it('throws if no resolver found for unknown keyword', function() {
    expect(function() {
      merger({
        foo: 3,
        allOf: [{
          foo: 7
        }]
      })
    }).to.throw(/no resolver found/i)
  })

  it('uses supplied resolver for unknown keyword', function() {
    var result = merger({
      foo: 3,
      allOf: [{
        foo: 7
      }]
    }, {
      resolvers: {
        foo: function(values) {
          return values.pop()
        }
      }
    })

    expect(result).to.eql({
      foo: 7
    })
  })

  it('uses default merger if no resolver found', function() {
    var result = merger({
      foo: 3,
      allOf: [{
        foo: 7
      }]
    }, {
      resolvers: {
        defaultResolver: function(values) {
          return values.pop()
        }
      }
    })

    expect(result).to.eql({
      foo: 7
    })
  })
})
