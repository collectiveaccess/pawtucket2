import React, { useContext, useState } from 'react'
import { LightboxContext } from '../LightboxContext'

const LightboxListSort = () => {

  const { lightboxes, setLightboxes } = useContext(LightboxContext)

  const [sort, setSort] = useState('date')
  const [sortDirection, setSortDirection] = useState('asc')

  // Change sort options handler
	const handleChange = (event) => {
		const { name, value } = event.target;
    if(name == "sort"){
      setSort(value)
			submitSort(value, sortDirection)
      // console.log("setSort");
    }else{
      setSortDirection(value)
			submitSort(sort, value)
      // console.log("setSortDirection");
    }
		// console.log("name, value", name, value);
	};

	// sorts the list of lightboxes
	const submitSort = (sort, direction) => {
		// changePageHandler(parseFloat(1));

		if (sort == 'title') {
			sortByTitleAlphabetically(direction)
		};
		if (sort == 'count') {
			sortByCount(direction)
		};
		if (sort == 'date') {
			sortByDate(direction)
		};
		if (sort == 'author_lname') {
			sortByAuthorAlphabetically(direction)
		};
		// console.log("submitSort");
	};

	//sort lightboxes by the count property
	const sortByCount = (direction) => {
		let temp = [...lightboxes]
		if (direction == 'desc') { // start with largest
			temp.sort((a, b) => { return b.props.data.count - a.props.data.count; });
			setLightboxes(temp);
		} else { // start with smallest
			temp.sort((a, b) => { return a.props.data.count - b.props.data.count; });
			setLightboxes(temp);
		};
	}

	// sort lightboxes by the date created
	const sortByDate = (direction) => {
		let temp = [...lightboxes]
		if (direction == 'desc') { //oldest first
			temp.sort((a, b) => a.props.data.created.localeCompare(b.props.data.created));
			setLightboxes(temp);
		} else { //newest first
			temp.sort((a, b) => -a.props.data.created.localeCompare(b.props.data.created));
			setLightboxes(temp);
		}
	}

	//sort lightboxes by author alphabetically
	const sortByAuthorAlphabetically = (direction) => {
		let temp = [...lightboxes]
		if (direction == 'desc') {
			temp.sort((a, b) => {
				let fa = a.props.data.author_lname.toLowerCase(), fb = b.props.data.author_lname.toLowerCase();
				if (fa > fb) { return -1; }
				if (fa < fb) { return 1; }
				return 0;
			});
			setLightboxes(temp);
		} else {
			temp.sort((a, b) => {
				let fa = a.props.data.author_lname.toLowerCase(), fb = b.props.data.author_lname.toLowerCase();
				if (fa < fb) { return -1; }
				if (fa > fb) { return 1; }
				return 0;
			});
			setLightboxes(temp);
		}
	}

	// sort lightboxes by label alphabetically
	const sortByTitleAlphabetically = (direction) => {
		let temp = [...lightboxes]
		if (direction == 'desc') {
			temp.sort((a, b) => {
				let fa = a.props.data.title.toLowerCase(), fb = b.props.data.title.toLowerCase();
				if (fa > fb) { return -1; }
				if (fa < fb) { return 1; }
				return 0;
			});
			setLightboxes(temp);
		} else {
			temp.sort((a, b) => {
				let fa = a.props.data.title.toLowerCase(), fb = b.props.data.title.toLowerCase();
				if (fa < fb) { return -1; }
				if (fa > fb) { return 1; }
				return 0;
			});
			setLightboxes(temp);
		}
	}

  return (
    <div className="dropdown show" >
      <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<ion-icon name="funnel"></ion-icon>
			</a>
			
			<div className="dropdown-menu" aria-labelledby="dropdownMenuLink" style={{ border: '1px solid black' }}>
				<form className='form-inline' style={{ margin: '10px' }}>
					<div style={{ marginRight: '5px' }}>
						<select name="sort" required value={sort} onChange={handleChange}>
							<option value='title'>Title</option>
							<option value='date'>Date</option>
							<option value='count'>Objects</option>
							<option value='author_lname'>Author</option>
						</select>
					</div>
					<div>
						<select name="sortDirection" required value={sortDirection} onChange={handleChange}>
							<option value='asc'>↑</option>
							<option value='desc'>↓</option>
						</select>
					</div>
				</form>
      </div>
    </div>
  );

}

export default LightboxListSort;

{/* <div>
	<button type="button" className="btn" onClick={() => submitSort()}>
		<span className="material-icons">arrow_forward</span>
	</button>
</div> */}