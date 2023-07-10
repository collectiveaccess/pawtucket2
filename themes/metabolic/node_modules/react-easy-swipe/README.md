# REACT EASY SWIPE
[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2Fleandrowd%2Freact-easy-swipe.svg?type=shield)](https://app.fossa.io/projects/git%2Bgithub.com%2Fleandrowd%2Freact-easy-swipe?ref=badge_shield)


Add swipe interactions to your react component.
* Generated using [react-init](https://www.npmjs.com/package/react-init)

## Demo
[http://leandrowd.github.io/react-easy-swipe/](http://leandrowd.github.io/react-easy-swipe/)
- Open your console;
- Swipe over the content and check your console;
- This is a touch component so make sure your browser is emulating touch.

## Tips:

1) To prevent scroll during swipe, return true from the handler passed to onSwipeMove

2) To allow mouse events to behave like touch, pass a prop allowMouseEvents

3) To prevent accidental swipes on scroll, pass a prop tolerance with the tolerance pixel as number.

## Instalation
`npm install react-easy-swipe --save`


## Usage
```javascript
import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import Swipe from 'react-easy-swipe';

class MyComponent extends Component {
  onSwipeStart(event) {
    console.log('Start swiping...', event);
  }

  onSwipeMove(position, event) {
    console.log(`Moved ${position.x} pixels horizontally`, event);
    console.log(`Moved ${position.y} pixels vertically`, event);
  }

  onSwipeEnd(event) {
    console.log('End swiping...', event);
  }

  render() {
    const boxStyle = {
      width: '100%',
      height: '300px',
      border: '1px solid black',
      background: '#ccc',
      padding: '20px',
      fontSize: '3em'
    };

    return (
      <Swipe
        onSwipeStart={this.onSwipeStart}
        onSwipeMove={this.onSwipeMove}
        onSwipeEnd={this.onSwipeEnd}>
          <div style={boxStyle}>Open the console and swipe me</div>
      </Swipe>
    );
  }
}

ReactDOM.render(<MyComponent/>, document.getElementById('root'));

```

## Properties

```javascript
{
  tagName: PropTypes.string,
  className: PropTypes.string,
  style: PropTypes.object,
  children: PropTypes.node,
  allowMouseEvents: PropTypes.bool,
  onSwipeUp: PropTypes.func,
  onSwipeDown: PropTypes.func,
  onSwipeLeft: PropTypes.func,
  onSwipeRight: PropTypes.func,
  onSwipeStart: PropTypes.func,
  onSwipeMove: PropTypes.func,
  onSwipeEnd: PropTypes.func,
  tolerance: PropTypes.number.isRequired
}
```

## Contributing

Please, feel free to contribute. You may open a bug, request a feature, submit a pull request or whatever you want!


## License
[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2Fleandrowd%2Freact-easy-swipe.svg?type=large)](https://app.fossa.io/projects/git%2Bgithub.com%2Fleandrowd%2Freact-easy-swipe?ref=badge_large)
