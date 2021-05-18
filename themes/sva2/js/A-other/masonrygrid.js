'use strict';
import React from 'react';
import ReactDOM from 'react-dom';

const selector = pawtucketUIApps.masonrygrid.selector;

console.log("PUIAPPS masonrygrid: ", pawtucketUIApps.masonrygrid);

let brakePoints = [350, 500, 750];
let images = [];
const imgId = [1011, 883, 1074, 823, 64, 65, 839, 314, 256, 316, 92,643];
for(let i = 0; i< imgId.length; i++){
	const ih = 200 + Math.floor(Math.random()*10)*15;
	images.push("https://unsplash.it/250/" + ih + "?image=" + imgId[i]);
}

class MasonryGrid extends React.Component{
	constructor(props) {
		super(props);
		this.state = {
			images: props.images
		}
	}
	render(){
		return (
			<div className="container">
				<div className="masonry-container">
					<p>ReactJS Responsive/Modular Masonry Grid.</p>
					<Masonry brakePoints={this.props.brakePoints}>
						{this.props.images.map((image, id) => {
							return (
								<Tile src={image} />
							) 
						})}
					</Masonry>
				</div>
			</div>
		)
	}
}

const Tile = ({src}) => {
  return (
    <div className="tile">
			<img src={src} />
		</div>
  );
};

class Masonry extends React.Component{
	constructor(props){
		super(props);
		this.state = {columns: 1};
		this.onResize = this.onResize.bind(this);
	}
	componentDidMount(){
		this.onResize();
		window.addEventListener('resize', this.onResize)	
	}
	
	getColumns(w){
		return this.props.brakePoints.reduceRight( (p, c, i) => {
			return c < w ? p : i;
		}, this.props.brakePoints.length) + 1;
	}
	
	onResize(){
		const columns = this.getColumns(this.refs.Masonry.offsetWidth);
		if(columns !== this.state.columns){
			this.setState({columns: columns});	
		}
		
	}
	
	mapChildren(){
		let col = [];
		const numC = this.state.columns;
		for(let i = 0; i < numC; i++){
			col.push([]);
		}
		return this.props.children.reduce((p,c,i) => {
			p[i%numC].push(c);
			return p;
		}, col);
	}
	
	render(){
		return (
			<div className="masonry" ref="Masonry">
				{this.mapChildren().map((col, ci) => {
					return (
						<div className="column" key={ci} >
							{col.map((child, i) => {
								return <div key={i} >{child}</div>
							})}
						</div>
					)
				})}
			</div>
		)
	}
}

ReactDOM.render(<MasonryGrid images = {images} brakePoints={brakePoints} />, document.querySelector(selector));


