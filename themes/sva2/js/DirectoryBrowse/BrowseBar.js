import React, { useContext, useEffect } from 'react'
import { DirectoryBrowseContext } from './DirectoryBrowseContext';
import { getBrowseBar } from './DirectoryQueries';
import Slider from "react-slick";

const currentBrowse = pawtucketUIApps.DirectoryBrowse.currentBrowse;
const baseUrl = pawtucketUIApps.DirectoryBrowse.baseUrl;

function NextArrow(props) {
  const { className, style, onClick } = props;
  // console.log("next arrow", style);
  return (
    <a href="#" tabIndex="0" className={className} style={style} onClick={onClick} role="button" aria-label="arrow to move forward" aria-disabled={className.includes("slick-disabled")? true : false}>
      <span className="material-icons">arrow_forward</span>
    </a>
  );
}

function PrevArrow(props) {
  const { className, style, onClick } = props;
  // console.log("prev arrow", style);
  return (
    <a href="#" tabIndex="0" className={className} style={style} onClick={onClick} role="button" aria-label="arrow to move backwards" aria-disabled={className.includes("slick-disabled") ? true : false}>
      <span className="material-icons">arrow_back</span>
    </a>
  );
}

const BrowseBar = (props) => {

  const { browseBarData, setBrowseBarData, browseBarValue, setBrowseBarValue, displayTitle, setDisplayTitle, limit, setLimit } = useContext(DirectoryBrowseContext);

  // console.log("browsebarvalue: ", browseBarValue);

  useEffect(() => {
    getBrowseBar(baseUrl, currentBrowse, (data) => {
      // console.log('browseBar data', data);
      const values = [];
      data.values.map((val) => {
        values.push(val);
      })
      setBrowseBarData(values);
      setDisplayTitle(data.displayTitle)
    });
  }, [setBrowseBarData])

  const settings = {
    infinite: false,
    speed: 500,
    slidesToShow: 10,
    slidesToScroll: 10,
    accessibility: true,
    nextArrow: <NextArrow />,
    prevArrow: <PrevArrow />,
    responsive: [
      { breakpoint: 1300, settings: { slidesToShow: 8, slidesToScroll: 8 } },
      { breakpoint: 1050, settings: { slidesToShow: 7, slidesToScroll: 7 } },
      { breakpoint: 900, settings: { slidesToShow: 6, slidesToScroll: 6 } },
      { breakpoint: 750, settings: { slidesToShow: 4, slidesToScroll: 4 } },
      { breakpoint: 500, settings: { slidesToShow: 3, slidesToScroll: 3 } },
      { breakpoint: 400, settings: { slidesToShow: 2, slidesToScroll: 2 } },
      { breakpoint: 300, settings: { slidesToShow: 1, slidesToScroll: 1 } },
    ]
  };
  
  const setValue = (e, item) => {
    setBrowseBarValue(item);
    setLimit(20); //resets the limit everytime a new browse bar value is selected
    getAnchor(item)
    e.preventDefault();
  }

  const getAnchor = (item) => {
    // window.location.hash = `#${item}`;
    // var currentUrl = document.URL;
    // var urlParts = currentUrl.split('#');
    // return (urlParts.length > 1) ? urlParts[1] : null;
  }

  // useEffect(() => {
  //   if (document.getElementById(`item-${browseBarValue}`)){
  //     let activeItem = document.getElementById(`item-${browseBarValue}`);
  //     activeItem.classList.add("active");
  //     console.log("activeItem", activeItem);
  //   }
  // }, [browseBarValue, document.getElementById(`item-${browseBarValue}`)])
  

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
  

  if(currentBrowse == "exhibitionsByYear"){
    return(
      <>
        <div className="row line-border mb-4" id="main-content"></div>
          <div className="row b-bar" id="items-cont">
            <Slider {...settings}>
              {browseBarData? browseBarData.map((item, index) => {
                // tabIndex={browseBarValue == item.display ? "1" : "0"}
                return (
                  <div key={index} tabIndex={browseBarValue == item.display ? "1" : "0"} href={`#${item.display}`}>
                    <a 
                      id={`item-${item.display}`}
                      href={`#${item.display}`} 
                      aria-disabled={item.disabled == 0 ? false : true} 
                      aria-selected={item.display == browseBarValue ? true : false} 
                      aria-label={`browse content by the year ${item.display}`} 
                      className={(item.disabled == 0) ? "browse-bar-item" : "browse-bar-item disabled"} 
                      onClick={(e) => {setValue(e, item.display)}}>{item.display}
                    </a>
                  </div>
                )
              }) : null}
            </Slider>
          </div>
        <div className="row line-border mt-4"></div>
      </>
    )
  }else{
    return (
      <>
        <div className="row line-border mb-4" id="main-content"></div>
          <div className="row b-bar" id="items-cont">
            <div className="alpha-cont">
            {browseBarData? browseBarData.map((item, index) => {
                return(
                  <a
                    tabIndex={browseBarValue == item.display ? "1" : "0"}
                    id={`item-${item.display}`}
                    href=''
                    key={index} 
                    aria-disabled={item.disabled == 0 ? false : true} 
                    aria-selected={item.display == browseBarValue? true : false} 
                    aria-label={`browse content by the letter ${item.display}`} 
                    className={(item.disabled == 0) ? `browse-bar-item alpha-item` : `browse-bar-item disabled alpha-item`} 
                    onClick={(e) => {setValue(e, item.display)}}
                  >{item.display}</a>
                ) 
              }) : null}
            </div>
          </div>
        <div className="row line-border mt-4"></div>
      </>
    )
  }
  
}

export default BrowseBar;