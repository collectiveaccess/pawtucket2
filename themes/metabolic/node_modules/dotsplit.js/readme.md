# dotsplit.js
> Transform dot-delimited strings to array of strings for [Node.js][] and the browser.

[![Build Status](http://img.shields.io/travis/wilmoore/dotsplit.js.svg)](https://travis-ci.org/wilmoore/dotsplit.js) [![Code Climate](https://codeclimate.com/github/wilmoore/dotsplit.js/badges/gpa.svg)](https://codeclimate.com/github/wilmoore/dotsplit.js) [![js-standard-style](https://img.shields.io/badge/code%20style-standard-brightgreen.svg?style=flat)](https://github.com/feross/standard)

```shell
npm install dotsplit.js --save
```

> You can also use Duo, Bower or [download the files manually](https://github.com/wilmoore/dotsplit.js/releases).

###### npm stats

[![npm](https://img.shields.io/npm/v/dotsplit.js.svg)](https://www.npmjs.org/package/dotsplit.js) [![NPM downloads](http://img.shields.io/npm/dm/dotsplit.js.svg)](https://www.npmjs.org/package/dotsplit.js) [![David](https://img.shields.io/david/wilmoore/dotsplit.js.svg)](https://david-dm.org/wilmoore/dotsplit.js)

## API Example

#### Split on dot

```js
dotsplit('group.0.section.a.seat.3')
//=> ['group', '0', 'section', 'a', 'seat', '3']
```

#### Split on dot preserving escaped characters

```js
dotsplit('01.document\\.png')
//=> ['01', 'document.png']
```

## API

### `dotsplit(String)`

###### arguments

 - `string (String)` Dot-delimited string.

###### returns

 - `(Array)` Array of strings.

## Contributing

> SEE: [contributing.md](contributing.md)

## Licenses

[![GitHub license](https://img.shields.io/github/license/wilmoore/dotsplit.js.svg)](https://github.com/wilmoore/dotsplit.js/blob/master/license)

[Node.js]: https://nodejs.org/en/about
