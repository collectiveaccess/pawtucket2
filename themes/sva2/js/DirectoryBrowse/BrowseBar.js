import React, { useContext, useState, useEffect } from 'react'
import { DirectoryBrowseContext } from './DirectoryBrowseContext';
import { getBrowseBar, getBrowseContent } from './DirectoryQueries';
import Slider from "react-slick";

const currentBrowse = pawtucketUIApps.DirectoryBrowse.currentBrowse;
const baseUrl = pawtucketUIApps.DirectoryBrowse.baseUrl;

const BrowseBar = (props) => {

  const { setBrowseBarValue, setBrowseContentData } = useContext(DirectoryBrowseContext);

  const settings = {
    infinite: false,
    speed: 500,
    slidesToShow: 10,
    slidesToScroll: 2,
    // initialSlide: 0,
    responsive: [
      {
        breakpoint: 1300,
        settings: {
          slidesToShow: 8,
          slidesToScroll: 1,
          infinite: false,
          dots: false,
        }
      },
      {
        breakpoint: 1050,
        settings: {
          slidesToShow: 7,
          slidesToScroll: 1,
          infinite: false,
          dots: false,
        }
      },
      {
        breakpoint: 900,
        settings: {
          slidesToShow: 6,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 750,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 500,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 400,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 300,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      },

    ]
  };

  function getAnchor(item) {
    window.location.hash = `#${item}`;
    // var currentUrl = document.URL;
    // var urlParts = currentUrl.split('#');
    // return (urlParts.length > 1) ? urlParts[1] : null;
  }

  const setValue = (e, item) => {
    setBrowseBarValue(item);

    getBrowseContent(baseUrl, currentBrowse, item, function (data) {
      console.log('browseContent data', data);
      const values = [];
      data.values.map((val) => {
        values.push(val.display);
      })
      setBrowseContentData(values);
    })
    e.preventDefault();
  }

  var container = document.getElementById("items-cont");
  var links = document.getElementsByClassName("browse-bar-item");

  if(container && links) {
    for (var i = 0; i < links.length; i++) {
      links[i].addEventListener("click", function () {
        var current = document.getElementsByClassName("active");
        if (current.length > 0) {
          current[0].className = current[0].className.replace(" active", "");
        }
        this.className += " active";
      });
    }
  }

  if(props.data){
    if(currentBrowse == "exhibitionsByYear"){
      return(
        <>
          <div className="row line-border mb-4"></div>
          <div className="row b-bar" id="items-cont">
            <Slider {...settings}>
              {props.data.map((item, index) => {
                return (
                  <a key={index} className={(item.disabled == 0) ? "browse-bar-item" :"browse-bar-item disabled"} href={`#${item.display}`} onClick={(e) => { setValue(e, item.display); getAnchor(item.display); }}>{item.display}</a>
                )
              })}
            </Slider>
            </div>
          <div className="row line-border mt-4"></div>
        </>
      )
    }else{
      return (
        <>
          <div className="row line-border mb-4"></div>
          <div className="row b-bar" id="items-cont">
            <div className="alpha-cont">
              {props.data.map((item, index) => {
                return(
                  <a key={index} className={(item.disabled == 0) ? "browse-bar-item alpha-item" : "browse-bar-item disabled alpha-item"} href={`#${item.display}`} onClick={(e) => {setValue(e, item.display); getAnchor(item.display);}}>{item.display}</a>
                )
              })}
            </div>
            </div>
          <div className="row line-border mt-4"></div>
        </>
      )
    }
  }else{
    return null;
  }
}

export default BrowseBar;