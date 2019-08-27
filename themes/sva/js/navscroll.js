'use strict';
import React from 'react';
import ReactDOM from 'react-dom';


let selector = pawtucketUIApps.navscroll.selector;
let sectionSelector = pawtucketUIApps.navscroll.data.sectionSelector;
let offsetPx = pawtucketUIApps.navscroll.data.offset;

class Navscroll extends React.Component {
    constructor(props) {
        super(props);
        this.navbar = React.createRef();
        
        this.handleScroll = this.handleScroll.bind(this);
    }  
    
    getOffset(element){
      var bounding = element.getBoundingClientRect();
      return {
          top: bounding.top + document.body.scrollTop,
          left: bounding.left + document.body.scrollLeft
        };
    }

    handleScroll(){
       let navbar = this.navbar.current;
       let startElement = sectionSelector ? document.querySelector(sectionSelector): null;
       let offset = startElement ? this.getOffset(startElement) : null;
       let windowsScrollTop  = window.pageYOffset;
       if (((offsetPx > 0) && windowsScrollTop >= offsetPx) || (offset && (windowsScrollTop >= offset.top))){
         navbar.classList.add("navbar-fixed-top");           
       }else{
         navbar.classList.remove("navbar-fixed-top");   
       }
    }
    
    componentDidMount() {
        window.addEventListener('scroll', this.handleScroll);        
    }

    componentWillUnmount() {
        window.removeEventListener('scroll', this.handleScroll);
    }
 
   render() {
    return (<nav className="navbar navbar-expand-md navbar-light bg-light fixed-top" role="navigation" ref={this.navbar}>
		<a className="navlogo" href="#">School of Visual Arts Archives</a>
		<button className="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainnavbar" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
			<span className="navbar-toggler-icon"></span>
		</button>
		<div className="collapse navbar-collapse" id="mainnavbar">
        	<ul className="navbar-nav ml-auto">
        		<li><span className="skip"><a href="#main">Skip to main content</a></span></li>
         		<li><a id="search-button" href="#">Search Exhibitions</a></li>
				<li><a href="/glaser-archives?autoscroll=0">Glaser Archives</a></li>
                <li><a href="/sva-archives">SVA Archives</a></li>
                <li><a href="/page/about?autoscroll=0">About</a></li>
                <li><a href="/visit-us">Visit</a></li>
                <li><a href="/blog/?autoscroll=0">Blog</a></li>
       		</ul>
      	</div>
	</nav>);
   }
}

ReactDOM.render(<Navscroll/>, document.querySelector(selector));
