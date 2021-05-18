import React, {Component} from "react";
import axios from "axios";
import CarouselApp from "./FrontPage/carousel/CarouselApp";
import GridApp from "./FrontPage/grid/GridApp";
import InteractiveSetApp from "./FrontPage/interactive-sets/InteractiveSetsApp";

const selector = pawtucketUIApps.FrontPage.selector;
const mode = pawtucketUIApps.FrontPage.mode;
const endpoint = pawtucketUIApps.FrontPage.endpoint;

class FrontPage extends Component {
  constructor(props) {
    super(props);
    this.state = {
      mode: this.props.mode,
      sets: [],
    };
  }

  componentDidMount() {
    const endpoint = this.props.endpoint;
    axios.get(endpoint).then((response) => {
      this.setState({
        sets: response.data,
      });
      console.log('Loaded sets', this.state);
    }).catch((error) => {
      if (error.response) {
        /*
         * The request was made and the server responded with a status code
         * that falls out of the range of 2xx
         */
        console.log('Response error');
        console.log(error.response.data);
        console.log(error.response.status);
        console.log(error.response.headers);
      } else if (error.request) {
        /*
         * The request was made but no response was received, `error.request`
         * is an instance of XMLHttpRequest in the browser and an instance
         * of http.ClientRequest in Node.js
         */
        console.log("Request was made but no response was received");
        console.log(error.request);
      } else {
        // Something happened in setting up the request and triggered an Error
        console.log('Error', error.message);
      }

      console.log(error.config);
    });
  }

  render() {
    if (!this.state.sets || !this.state.sets[0]) {
      return <div> No data </div>;
    }

    if (this.state.mode === "grid") {
      return <GridApp mode = "grid"
      data = {
        this.state.sets[0].items
      }
      />;
    } else if (this.state.mode === "carousel") {
      return <CarouselApp mode = "carousel"
      data = {
        this.state.sets[0].items
      }
      />;
    } else {
      return (
        <InteractiveSetApp mode = "interactive-sets" data = {this.state.sets} />
      );
    }
  }
}

/**
 * Initialize browse and render into DOM. This function is exported to allow the Pawtucket
 * app loaders to insert this application into the current view.
 */
export default function _init() {
  ReactDOM.render(
    <FrontPage mode = {mode} endpoint = {endpoint}/>, document.querySelector(selector));
}
