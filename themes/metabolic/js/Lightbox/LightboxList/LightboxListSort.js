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
      console.log("setSort");
    }else{
      setSortDirection(value)
      console.log("setSortDirection");
    }
		// console.log("name, value", name, value);
	};

	//sort lightboxes by the count property
	const sortByCount = () => {
		let temp = [...lightboxes]
		if (sortDirection == 'desc') { // start with largest
			temp.sort((a, b) => { return b.props.data.count - a.props.data.count; });
			setLightboxes(temp);
		} else { // start with smallest
			temp.sort((a, b) => { return a.props.data.count - b.props.data.count; });
			setLightboxes(temp);
		};
	}

	// sort lightboxes by the date created
	const sortByDate = () => {
		let temp = [...lightboxes]
		if (sortDirection == 'desc') { //oldest first
			temp.sort((a, b) => a.props.data.created.localeCompare(b.props.data.created));
			setLightboxes(temp);
		} else { //newest first
			temp.sort((a, b) => -a.props.data.created.localeCompare(b.props.data.created));
			setLightboxes(temp);
		}
	}

	//sort lightboxes by author alphabetically
	const sortByAuthorAlphabetically = () => {
		let temp = [...lightboxes]
		if (sortDirection == 'desc') {
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
	const sortByTitleAlphabetically = () => {
		let temp = [...lightboxes]
		if (sortDirection == 'desc') {
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

  // sorts the list of lightboxes
	const submitSort = () => {
		// changePageHandler(parseFloat(1));

		if (sort == 'title') {
			sortByTitleAlphabetically()
		};
		if (sort == 'count') {
			sortByCount()
		};
		if (sort == 'date') {
			sortByDate()
		};
		if (sort == 'author_lname') {
			sortByAuthorAlphabetically()
		};
    console.log("submitSort");
	};


  return (
    <div className="dropdown show" >
      <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><ion-icon name="funnel"></ion-icon></a>
      <div className="dropdown-menu" aria-labelledby="dropdownMenuLink">

        <div className='container' style={{ width: '200px' }}>
          <div className='row'>
            <form className='form-inline' style={{ margin: '10px' }}>

              <div style={{ marginRight: '5px' }}>
                <select name="sort" required value={sort} onChange={handleChange}>
                  <option value='title'>Title</option>
                  <option value='date'>Date</option>
                  <option value='count'>Objects</option>
                  <option value='author_lname'>Author</option>
                </select>
              </div>

              <div style={{ marginRight: '5px' }}>
                <select name="sortDirection" required value={sortDirection} onChange={handleChange}>
                  <option value='asc'>↑</option>
                  <option value='desc'>↓</option>
                </select>
              </div>

              <div>
                <button type="button" className="btn" onClick={() => submitSort()}>
                  <span className="material-icons">arrow_forward</span>
                </button>
              </div>

            </form>
          </div>
        </div>

      </div>
    </div>
  );

}

export default LightboxListSort;