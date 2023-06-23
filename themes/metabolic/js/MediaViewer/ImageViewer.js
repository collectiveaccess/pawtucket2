/*jshint esversion: 6 */
import React from "react"
import ReactDOM from "react-dom";
import { Viewer } from "react-iiif-viewer";

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
		return(
			<div>
				<Viewer iiifUrl={this.props.url} width={width} height={height} />
			</div>
		);
	}
}

export { ImageViewer };
