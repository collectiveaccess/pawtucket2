import React from "react"
import ReactDOM from "react-dom";
import { LightboxContext } from '../../Lightbox'

class LightboxListSort extends React.Component {
  constructor(props) {
    super(props);

    LightboxListSort.contextType = LightboxContext

    this.state = {
      sort: 'date',
      sortDirection: 'asc',
      
      currentPage: 1,
      lightboxesPerPage: 12,

      lightboxes: this.props.lightboxes,
    };

    this.handleChange = this.handleChange.bind(this);
    this.sortByCount = this.sortByCount.bind(this);
    this.sortByDate = this.sortByDate.bind(this);
    this.sortByTitleAlphabetically = this.sortByTitleAlphabetically.bind(this);
    this.sortByAuthorAlphabetically = this.sortByAuthorAlphabetically.bind(this);
    this.submitSort = this.submitSort.bind(this);
    this.setLightboxListInState = this.setLightboxListInState.bind(this);
  }

  // Change sort options handler
  handleChange = (event) => {
    const { name, value } = event.target;
    this.setState({ [name]: value });
  };

  //sort lightboxes by the count property
  sortByCount(arr) {
    if (this.state.sortDirection == 'desc') { // start with largest
      arr.sort((a, b) => { return b.props.data.count - a.props.data.count; });
      this.setState({ lightboxes: arr });
    } else { // start with smallest
      arr.sort((a, b) => { return a.props.data.count - b.props.data.count; });
      this.setState({ lightboxes: arr });
    };
    // console.log(this.state.lightboxes);
  }

  //sort lightboxes by the date created
  sortByDate(arr) {
    if (this.state.sortDirection == 'desc') { //oldest first
      arr.sort((a, b) => a.props.data.created.localeCompare(b.props.data.created));
      // arr.sort((a, b) => { return b.props.data.created - a.props.data.created; });
      this.setState({ lightboxes: arr });
    } else { //newest first
      arr.sort((a, b) => -a.props.data.created.localeCompare(b.props.data.created));
      // arr.sort((a, b) => { return a.props.data.created - b.props.data.created; });
      this.setState({ lightboxes: arr });
    }
  }

  //sort lightboxes by author alphabetically
  sortByAuthorAlphabetically(arr) {
    if (this.state.sortDirection == 'desc') {
      arr.sort((a, b) => {
        let fa = a.props.data.author_lname.toLowerCase(), fb = b.props.data.author_lname.toLowerCase();
        if (fa > fb) { return -1; }
        if (fa < fb) { return 1; }
        return 0;
      });
      this.setState({ lightboxes: arr });
    } else {
      arr.sort((a, b) => {
        let fa = a.props.data.author_lname.toLowerCase(), fb = b.props.data.author_lname.toLowerCase();
        if (fa < fb) { return -1; }
        if (fa > fb) { return 1; }
        return 0;
      });
      this.setState({ lightboxes: arr });
    }
  }

  // sort lightboxes by label alphabetically
  sortByTitleAlphabetically(arr) {
    if (this.state.sortDirection == 'desc') {
      arr.sort((a, b) => {
        let fa = a.props.data.title.toLowerCase(), fb = b.props.data.title.toLowerCase();
        if (fa > fb) { return -1; }
        if (fa < fb) { return 1; }
        return 0;
      });
      this.setState({ lightboxes: arr })
    } else {
      arr.sort((a, b) => {
        let fa = a.props.data.title.toLowerCase(), fb = b.props.data.title.toLowerCase();
        if (fa < fb) { return -1; }
        if (fa > fb) { return 1; }
        return 0;
      });
      this.setState({ lightboxes: arr })
    }
  }

  //sorts the list of lightboxes
  submitSort = (arr) => {
    this.changePageHandler(parseFloat(1));

    if (this.state.sort == 'title') {
      this.sortByTitleAlphabetically(arr)
    };
    if (this.state.sort == 'count') {
      this.sortByCount(arr)
    };
    if (this.state.sort == 'date') {
      this.sortByDate(arr)
    };
    if (this.state.sort == 'author_lname') {
      this.sortByAuthorAlphabetically(arr)
    };
  };

  setLightboxListInState(lightboxes) {
    this.setState({ lightboxes: lightboxes })
  }

  render() {

    //This allows the lightboxes to be sorted
    if (this.state.lightboxes.length > 0) {
      lightboxes = this.state.lightboxes;
    }

    return (
      <div className="dropdown show" onClick={() => { this.setLightboxListInState(lightboxes) }}>
        <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><ion-icon name="funnel"></ion-icon></a>
        <div className="dropdown-menu" aria-labelledby="dropdownMenuLink">

          <div className='container' style={{ width: '200px' }}>
            <div className='row'>
              <form className='form-inline' style={{ margin: '10px' }}>

                <div style={{ marginRight: '5px' }}>
                  <select name="sort" required value={this.state.sort} onChange={this.handleChange}>
                    <option value='title'>Title</option>
                    <option value='date'>Date</option>
                    <option value='count'>Objects</option>
                    <option value='author_lname'>Author</option>
                  </select>
                </div>

                <div style={{ marginRight: '5px' }}>
                  <select name="sortDirection" required value={this.state.sortDirection} onChange={this.handleChange}>
                    <option value='asc'>↑</option>
                    <option value='desc'>↓</option>
                  </select>
                </div>

                <div>
                  <button type="button" className="btn" onClick={() => { this.submitSort(this.state.lightboxes) }}>
                    <span className="material-icons">arrow_forward</span>
                  </button>
                </div>

              </form>
            </div>
          </div>{/*container end */}

        </div>
      </div>
    );
  }
}

export default LightboxListSort;