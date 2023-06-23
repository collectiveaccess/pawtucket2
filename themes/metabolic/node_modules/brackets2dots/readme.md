# brackets2dots.js

[![Build Status](http://img.shields.io/travis/wilmoore/brackets2dots.js.svg)](https://travis-ci.org/wilmoore/brackets2dots.js) [![NPM version](http://img.shields.io/npm/v/brackets2dots.svg)](https://www.npmjs.org/package/brackets2dots) [![NPM downloads](http://img.shields.io/npm/dm/brackets2dots.svg)](https://www.npmjs.org/package/brackets2dots) [![LICENSE](http://img.shields.io/npm/l/brackets2dots.svg)](license)

> Convert string with bracket notation to dot property notation for [Node.js][] and the browser.

## Example

    var brackets2dots = require('brackets2dots');

    brackets2dots('group[0].section.a.seat[3]')
    //=> 'group.0.section.a.seat.3'

## Installation

[component](http://component.io/wilmoore/brackets2dots)

    $ component install wilmoore/brackets2dots

[bower](http://sindresorhus.com/bower-components/)

    $ bower install brackets2dots.js

[npm](https://npmjs.org/package/brackets2dots)

[![NPM](https://nodei.co/npm/brackets2dots.png?downloads=true)](https://nodei.co/npm/brackets2dots/)

[volo](http://volojs.org)

    $ volo add wilmoore/brackets2dots.js

[manual][]

1. download

        % curl -#O https://raw.github.com/wilmoore/brackets2dots.js/master/brackets2dots.js

2. use

        <script src="brackets2dots.js"></script>

## Inspiration

- [selectn][]

## License

  [MIT](license)

[selectn]:  https://github.com/wilmoore/selectn
[Node.js]:  http://nodejs.org
[manual]:   http://yuiblog.com/blog/2006/06/01/global-domination/

