import React from "react";
import '../css/main.scss';

import Carousel from "./FrontPage/carousel/Carousel";

const selector = pawtucketUIApps.FrontPage.selector;
const data = pawtucketUIApps.FrontPage.data;

const FrontPage = () => {

  // console.log('PUIAPPS FrontPage', pawtucketUIApps.FrontPage);

  return (
    <div className="react-carousel">
      <Carousel data={data.images}/>
    </div>
  )
 
}

/**
 * Initialize browse and render into DOM. This function is exported to allow the Pawtucket
 * app loaders to insert this application into the current view.
 */
export default function _init() {
  ReactDOM.render(
    <FrontPage />, document.querySelector(selector));
}