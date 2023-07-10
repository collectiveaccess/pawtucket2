# Make-Event-Props
A function that, given props, returns an object of event callback props optionally curried with additional arguments.

This package allows you to pass event callback props to a rendered DOM element without the risk of applying any invalid props that could cause unwanted side effects.

## tl;dr
* Install by executing `npm install make-event-props` or `yarn add make-event-props`.
* Import by adding `import makeEventProps from 'make-event-props'`.
* Create your event props object:
    ```js
    get eventProps() {
      return makeEventProps(this.props, () => this.state.pdf);
    }
    ```
* Use your event props:
    ```js
    render() {
      return (
        <div {...this.eventProps} />
      );
    }
    ```

## License

The MIT License.

## Author

<table>
  <tr>
    <td>
      <img src="https://github.com/wojtekmaj.png?s=100" width="100">
    </td>
    <td>
      Wojciech Maj<br />
      <a href="mailto:kontakt@wojtekmaj.pl">kontakt@wojtekmaj.pl</a><br />
      <a href="http://wojtekmaj.pl">http://wojtekmaj.pl</a>
    </td>
  </tr>
</table>
