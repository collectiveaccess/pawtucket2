var chai = require('chai')
var merger = require('../../src')
var _ = require('lodash')
var $RefParser = require('json-schema-ref-parser')
var metaSchema = require('../fixtures/schemas/meta-schema-v6.json')

var expect = chai.expect
var schema
describe.skip('simplify the meta schema', function() {
  beforeEach(function() {
    return $RefParser.dereference(_.cloneDeep(metaSchema)).then(function(dereferenced) {
      schema = dereferenced
    })
  })

  it('simplifies', function() {
    var result = merger(_.cloneDeep(schema))
    expect(result).to.eql(schema)
  })
})
