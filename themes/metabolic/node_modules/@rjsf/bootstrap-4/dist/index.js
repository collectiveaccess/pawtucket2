
'use strict'

if (process.env.NODE_ENV === 'production') {
  module.exports = require('./bootstrap-4.cjs.production.min.js')
} else {
  module.exports = require('./bootstrap-4.cjs.development.js')
}
