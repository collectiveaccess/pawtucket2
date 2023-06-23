/*jshint esversion: 6 */
import React from "react"
import ReactDOM from "react-dom";
import ReactPlayer from 'react-player'

const axios = require('axios');
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


/**
 *
 */
class VideoViewer extends React.Component{
	constructor(props) {
		super(props);

		this.state = {
			//playlist: Array.isArray(this.props.playlist) ? this.props.playlist : [this.props.playlist]
		};
	}

	render() {
		const width = this.props.width;
		const height = this.props.height;

		let playlist = Array.isArray(this.props.playlist) ? this.props.playlist : [this.props.playlist];

		if(!playlist || (playlist.length === 0)) {
			return(
				<div>No media available</div>
			);
		}
		return(
			<div>
				<ReactPlayer
					className='react-player'
					url={playlist}
					controls={true}
					width={width}
					height={height}
				/>
			</div>
		);
	}
}

export { VideoViewer };
