/*jshint esversion: 6 */
import React from "react"
import ReactDOM from "react-dom";
import { Viewer } from "react-iiif-viewer";
// import { OpenSeadragonViewer } from "openseadragon-react-viewer";

/**
 *
 */
class ImageViewer extends React.Component{
	constructor(props) {
		super(props);
		
		this.state = {
		
		};
	}

	render() {
		const width = this.props.width;
		const height = this.props.height;
		
		if(!this.props.url) {
			return(
				<div>No media available</div>
			);
		} 
		
		// Make manifest (hack for now)
		// let mediaUrl = this.props.url;
		// let manifest = {
		// 	  "description": [
		// 		""			// TODO: set image description?
		// 	  ],
 		// 	"label": "", // TODO: add image label
  	// 		"sequences": [
		// 		{
		// 		  "canvases": [
		// 			{
		// 			  "height": "480",
		// 			  "images": [
		// 				{
		// 				  "motivation": "sc:painting",
		// 				  "resource": {
		// 					"label": "Front cover",
		// 					"service": {
		// 					  "profile": "http://iiif.io/api/image/2/level2.json",
		// 					  "@context": "http://iiif.io/api/image/2/context.json",
		// 					  "@id": mediaUrl
		// 					},
		// 					"@id": mediaUrl,
		// 					"@type": "dctypes:Image"
		// 				  },
		// 				  "@type": "oa:Annotation"
		// 				}
		// 			  ],
		// 			  "label": "Front cover",
		// 			  "width": "640",
		// 			  "@id": mediaUrl,
		// 			  "@type": "sc:Canvas"
		// 			}
		// 		  ],
		// 		  "@context": "http://iiif.io/api/presentation/2/context.json",
		// 		  "@id": "/sequence/normal",
		// 		  "@type": "sc:Sequence"
		// 		}
		// 	  ],
		// 	  "@context": "http://iiif.io/api/presentation/2/context.json",
		// 	  "@id": "manifest",
		// 	  "@type": "sc:Manifest"
		// 	};
		
		return(
			<div className="img-viewer">
				<Viewer iiifUrl={this.props.url} width={width} height={height} />
			</div>
		);
	}
}

export { ImageViewer };

{/* <OpenSeadragonViewer manifest={manifest} options={{
	showDropdown: true,
	showThumbnails: true,
	showToolbar: true,
	deepLinking: true,
	height: 500,
}} /> */}