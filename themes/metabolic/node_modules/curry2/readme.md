# curry2
> Curry a binary function.

[![Build Status](http://img.shields.io/travis/wilmoore/curry2.js.svg)](https://travis-ci.org/wilmoore/curry2.js) [![Code Climate](https://codeclimate.com/github/wilmoore/curry2.js/badges/gpa.svg)](https://codeclimate.com/github/wilmoore/curry2.js) [![js-standard-style](https://img.shields.io/badge/code%20style-standard-brightgreen.svg?style=flat)](https://github.com/feross/standard)

```shell
npm install curry2 --save
```

>  You can also use Duo, Bower or [download the files manually](https://github.com/wilmoore/curry2.js/releases).

###### npm stats

[![npm](https://img.shields.io/npm/v/curry2.svg)](https://www.npmjs.org/package/curry2) [![NPM downloads](http://img.shields.io/npm/dm/curry2.svg)](https://www.npmjs.org/package/curry2) [![Dependency Status](https://gemnasium.com/wilmoore/curry2.js.svg)](https://gemnasium.com/wilmoore/curry2.js)

## API Example

###### require

```js
var curry2 = require('curry2')
```

###### function to curry

```js
var add = curry2(function (a, b) {
  return a + b
})
```

###### full application

```js
add(5, 2)
//=> 7
```

###### partial application

```js
var add10 = add(10)
add(5)
//=> 15
```

###### iteratee

```js
[100, 200, 300].map(add10)
//=> [ 110, 210, 310 ]
```

###### uncurry

```js
var orig = add.uncurry()

typeof orig
//=> 'function'

orig.length
//=> 2
```

## Features

 - Binary functions...that's it.
 - Will always be less than 20 LOC (not including comments).
 - No dependencies.

## Anti-Features

 - Will not attempt to curry n-ary functions.
 - Will never `eval` your functions.

## Limitations

 - You will lose `fn.name`.

## API

### `curry2(fn)`

###### arguments

 - `fn: (Function)` Binary function to curry.
 - `[self]: (Object)` Function `this` context.

###### returns

 - `(Function|*)` If partially applied, return unary function, otherwise, return result of full application..

### `.uncurry()`

###### returns

 - `(Function)` returns original function.

## Reference

 - [Currying](https://en.wikipedia.org/wiki/Currying)

## Alternatives

 - [curry](https://www.npmjs.com/package/curry)
 - [dyn-curry](https://www.npmjs.com/package/dyn-curry)
 - [currymember](https://www.npmjs.com/package/currymember)
 - [curryable](https://www.npmjs.com/package/curryable)
 - [fk](https://www.npmjs.com/package/fk)

## Contributing

> SEE: [contributing.md](contributing.md)

## Licenses

[![GitHub license](https://img.shields.io/github/license/wilmoore/curry2.js.svg)](https://github.com/wilmoore/curry2.js/blob/master/license)
