var chai = require('chai')
var merger = require('../../src')
var sinon = require('sinon')
var _ = require('lodash')
var expect = chai.expect
var Ajv = require('ajv')

var ajv = new Ajv()
describe('properties', function() {
  describe('when property name has same as a reserved word', function() {
    it('does not treat it as a reserved word', function() {
      var stub = sinon.stub().returns({
        properties: {
          properties: {
            type: 'string',
            minLength: 5
          }
        }
      })

      merger({
        allOf: [{
          properties: {
            properties: {
              type: 'string',
              minLength: 5
            }
          }
        }, {
          properties: {
            properties: {
              type: 'string',
              minLength: 7
            }
          }
        }]
      }, {
        resolvers: {
          properties: stub
        }
      })

      sinon.assert.calledOnce(stub)
    })
  })

  describe('additionalProperties', function() {
    it('allows no extra properties if additionalProperties is false', function() {
      var result = merger({
        allOf: [{
          additionalProperties: true
        }, {
          additionalProperties: false
        }]
      })

      expect(result).to.eql({
        additionalProperties: false
      })
    })

    it('allows only intersecting properties', function() {
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
      })

      expect(result).to.eql({
        properties: {
          bar: true
        },
        additionalProperties: false
      })
    })

    it('allows intersecting patternproperties', function() {
      var result = merger({
        allOf: [{
          properties: {
            foo: true,
            foo123: true
          },
          additionalProperties: true
        }, {
          properties: {
            bar: true
          },
          patternProperties: {
            '.+\\d+$': true
          },
          additionalProperties: false
        }]
      })

      expect(result).to.eql({
        properties: {
          bar: true,
          foo123: true
        },
        patternProperties: {
          '.+\\d+$': true
        },
        additionalProperties: false
      })
    })

    it('disallows all except matching patternProperties if both false', function() {
      var result = merger({
        allOf: [{
          properties: {
            foo: true,
            foo123: true
          },
          additionalProperties: false
        }, {
          properties: {
            bar: true
          },
          patternProperties: {
            '.+\\d+$': true
          },
          additionalProperties: false
        }]
      })

      expect(result).to.eql({
        properties: {
          foo123: true
        },
        additionalProperties: false
      })
    })

    it('disallows all except matching patternProperties if both false', function() {
      var result = merger({
        allOf: [{
          properties: {
            foo: true,
            foo123: true
          },
          patternProperties: {
            '.+\\d+$': {
              type: 'string'
            }
          },
          additionalProperties: false
        }, {
          properties: {
            bar: true,
            bar123: true
          },
          patternProperties: {
            '.+\\d+$': true
          },
          additionalProperties: false
        }]
      })

      expect(result).to.eql({
        properties: {
          foo123: true,
          bar123: true
        },
        patternProperties: {
          '.+\\d+$': {
            type: 'string'
          }
        },
        additionalProperties: false
      })
    })

    it('disallows all except matching patternProperties if both false', function() {
      var schema = {
        allOf: [{
          properties: {
            foo: true,
            foo123: true
          },
          patternProperties: {
            '^bar': true
          },
          additionalProperties: false
        }, {
          properties: {
            bar: true,
            bar123: true
          },
          patternProperties: {
            '.+\\d+$': true
          },
          additionalProperties: false
        }]
      }
      var origSchema = _.cloneDeep(schema)
      var result = merger(schema)
      expect(result).not.to.eql(origSchema)

      expect(result).to.eql({
        properties: {
          bar: true,
          foo123: true,
          bar123: true
        },
        additionalProperties: false
      })

      ;
      [{
        foo123: 'testfdsdfsfd'
      }, {
        bar123: 'testfdsdfsfd'
      }, {
        foo123: 'testfdsdfsfd'
      }, {
        bar: 'fdsaf'
      }, {
        abc123: 'fdsaf'
      }, {
        bar123: 'fdsaf'
      }, {
        barabc: 'fdsaf'
      }, {
        // additionalProp
        foo234: 'testffdsafdsads'
      }].forEach(function(val) {
        validateInputOutput(origSchema, result, val)
      })
    })

    it('disallows all except matching patternProperties if both true', function() {
      var schema = {
        allOf: [{
          properties: {
            foo: true,
            foo123: true
          },
          patternProperties: {
            '^bar': true
          }
        }, {
          properties: {
            bar: true,
            bar123: true
          },
          patternProperties: {
            '.+\\d+$': true
          }
        }]
      }
      var origSchema = _.cloneDeep(schema)
      var result = merger(schema)
      expect(result).not.to.eql(origSchema)

      expect(result).to.eql({
        properties: {
          foo: true,
          bar: true,
          foo123: true,
          bar123: true
        },
        patternProperties: {
          '^bar': true,
          '.+\\d+$': true
        }
      })

      ;
      [{
        foo123: 'testfdsdfsfd'
      }, {
        bar123: 'testfdsdfsfd'
      }, {
        foo123: 'testfdsdfsfd'
      }, {
        foo: 'fdsaf'
      }, {
        bar: 'fdsaf'
      }, {
        abc123: 'fdsaf'
      }, {
        bar123: 'fdsaf'
      }, {
        barabc: 'fdsaf'
      }, {
        foo234: 'testffdsafdsads'
      }].forEach(function(val) {
        validateInputOutput(origSchema, result, val)
      })
    })

    it('disallows all except matching patternProperties if one false', function() {
      var schema = {
        allOf: [{
          properties: {
            foo: true,
            foo123: true
          }
        }, {
          properties: {
            bar: true,
            bar123: true
          },
          patternProperties: {
            '.+\\d+$': true
          },
          additionalProperties: false
        }]
      }
      var origSchema = _.cloneDeep(schema)
      var result = merger(schema)
      expect(result).not.to.eql(origSchema)

      expect(result).to.eql({
        properties: {
          bar: true,
          foo123: true,
          bar123: true
        },
        patternProperties: {
          '.+\\d+$': true
        },
        additionalProperties: false
      })

      ;
      [{
        foo123: 'testfdsdfsfd'
      }, {
        bar123: 'testfdsdfsfd'
      }, {
        foo123: 'testfdsdfsfd'
      }, {
        foo: 'fdsaf'
      }, {
        bar: 'fdsaf'
      }, {
        abc123: 'fdsaf'
      }, {
        bar123: 'fdsaf'
      }, {
        barabc: 'fdsaf'
      }, {
        foo234: 'testffdsafdsads'
      }].forEach(function(val) {
        validateInputOutput(origSchema, result, val)
      })
    })

    it('disallows all if no patternProperties and if both false', function() {
      var result = merger({
        allOf: [{
          properties: {
            foo: true,
            foo123: true
          },
          additionalProperties: false
        }, {
          properties: {
            bar: true
          },
          additionalProperties: false
        }]
      })

      expect(result).to.eql({
        additionalProperties: false
      })
    })

    it('applies additionalProperties to other schemas properties if they have any', function() {
      var result = merger({
        properties: {
          common: true,
          root: true
        },
        additionalProperties: false,
        allOf: [{
          properties: {
            common: {
              type: 'string'
            },
            allof1: true
          },
          additionalProperties: {
            type: [
              'string', 'null'
            ],
            maxLength: 10
          }
        }, {
          properties: {
            common: {
              minLength: 1
            },
            allof2: true
          },
          additionalProperties: {
            type: [
              'string', 'integer', 'null'
            ],
            maxLength: 8
          }
        }, {
          properties: {
            common: {
              minLength: 6
            },
            allof3: true
          }
        }]
      })

      expect(result).to.eql({
        properties: {
          common: {
            type: 'string',
            minLength: 6
          },
          root: {
            type: [
              'string', 'null'
            ],
            maxLength: 8
          }
        },
        additionalProperties: false
      })
    })

    it('considers patternProperties before merging additionalProperties to other schemas properties if they have any', function() {
      var result = merger({
        properties: {
          common: true,
          root: true
        },
        patternProperties: {
          '.+\\d{2,}$': {
            minLength: 7
          }
        },
        additionalProperties: false,
        allOf: [{
          properties: {
            common: {
              type: 'string'
            },
            allof1: true
          },
          additionalProperties: {
            type: [
              'string', 'null', 'integer'
            ],
            maxLength: 10
          }
        }, {
          properties: {
            common: {
              minLength: 1
            },
            allof2: true,
            allowed123: {
              type: 'string'
            }
          },
          patternProperties: {
            '.+\\d{2,}$': {
              minLength: 9
            }
          },
          additionalProperties: {
            type: [
              'string', 'integer', 'null'
            ],
            maxLength: 8
          }
        }, {
          properties: {
            common: {
              minLength: 6
            },
            allof3: true,
            allowed456: {
              type: 'integer'
            }
          }
        }]
      })

      expect(result).to.eql({
        properties: {
          common: {
            type: 'string',
            minLength: 6
          },
          root: {
            type: [
              'string', 'null', 'integer'
            ],
            maxLength: 8
          },
          allowed123: {
            type: 'string',
            maxLength: 10
          },
          allowed456: {
            type: 'integer',
            maxLength: 10
          }
        },
        patternProperties: {
          '.+\\d{2,}$': {
            minLength: 9
          }
        },
        additionalProperties: false
      })
    })

    it('combines additionalProperties when schemas', function() {
      var result = merger({
        additionalProperties: true,
        allOf: [{
          additionalProperties: {
            type: [
              'string', 'null'
            ],
            maxLength: 10
          }
        }, {
          additionalProperties: {
            type: [
              'string', 'integer', 'null'
            ],
            maxLength: 8
          }
        }]
      })

      expect(result).to.eql({
        additionalProperties: {
          type: [
            'string', 'null'
          ],
          maxLength: 8
        }
      })
    })
  })

  describe('patternProperties', function() {
    it('merges simliar schemas', function() {
      var result = merger({
        patternProperties: {
          '^\\$.+': {
            type: [
              'string', 'null', 'integer'
            ],
            allOf: [{
              minimum: 5
            }]
          }
        },
        allOf: [{
          patternProperties: {
            '^\\$.+': {
              type: [
                'string', 'null'
              ],
              allOf: [{
                minimum: 7
              }]
            },
            '.*': {
              type: 'null'
            }
          }
        }]
      })

      expect(result).to.eql({
        patternProperties: {
          '^\\$.+': {
            type: [
              'string', 'null'
            ],
            minimum: 7
          },
          '.*': {
            type: 'null'
          }
        }
      })
    })
  })

  describe('when patternProperties present', function() {
    it('merges patternproperties', function() {
      var result = merger({
        allOf: [{
          patternProperties: {
            '.*': {
              type: 'string',
              minLength: 5
            }
          }
        }, {
          patternProperties: {
            '.*': {
              type: 'string',
              minLength: 7
            }
          }
        }]
      })

      expect(result).to.eql({
        patternProperties: {
          '.*': {
            type: 'string',
            minLength: 7
          }
        }
      })
    })

    it('merges with properties if matching property name', function() {
      var schema = {
        allOf: [{
          properties: {
            'name': {
              type: 'string',
              minLength: 1
            }
          },
          patternProperties: {
            '_long$': {
              type: 'string',
              minLength: 7
            }
          }
        }, {
          properties: {
            'foo_long': {
              type: 'string',
              minLength: 9
            }
          },
          patternProperties: {
            '^name.*': {
              type: 'string',
              minLength: 8
            }
          }
        }]
      }

      var origSchema = _.cloneDeep(schema)
      var result = merger(schema)

      expect(result).not.to.eql(origSchema)

      expect(result).to.eql({
        properties: {
          'foo_long': {
            type: 'string',
            minLength: 9
          },
          'name': {
            type: 'string',
            minLength: 1
          }
        },
        patternProperties: {
          '_long$': {
            type: 'string',
            minLength: 7
          },
          '^name.*': {
            type: 'string',
            minLength: 8
          }
        }
      });
      [{
        name: 'test'
      }, {
        name: 'fdsaffsda',
        name_long: 'testfdsdfsfd'
      }, {
        name: 'fdsafdsafas',
        foo_long: 'testfdsdfsfd'
      }, {
        name: 'dfsafdsa',
        name_long: 'testfdsdfsfd'
      }, {
        name: 'test',
        name2: 'testffdsafdsads'
      }].forEach(function(val) {
        validateInputOutput(schema, result, val)
      })
    })
  })
})

function validateInputOutput(schema, transformedSchema, obj) {
  var validOriginal = ajv.validate(schema, obj)
  var validNew = ajv.validate(transformedSchema, obj)
  expect(validOriginal).to.eql(validNew)
}
