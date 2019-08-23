'use strict';
import React from 'react';
import ReactDOM from 'react-dom';

const selector = pawtucketUIApps.contact.selector;
const appData = pawtucketUIApps.contact.data;
const sectionName = appData.sectionName;

	class ContactFormMessage extends React.Component {
		render() {
			return (
			    <div>
                    this is the message
                </div>
			);
		}
	}
	class ContactForm extends React.Component {
		constructor(props) {
			super(props);
			this.state = {
				settings: {
					sectionName: sectionName,
					...props
				}
			}
		}
		render() {
			return (
			    <div>
					<ContactFormMessage />
					<form className='ca-form'>
						<ul className='form'>
							<li><input type='text' placeholder='Name*' required /></li>
							<li><input type='email' placeholder='Email*' required /></li>
							<li>
								<ul className='double-fields'>
									<li><input type='text' placeholder='Institution' /></li>
									<li><input type='text' placeholder='Object Identifier' /></li>
								</ul>
							</li>
							<li><textarea placeholder='Description*' required ></textarea></li>
							<li>
								<div className='reCaptcha'></div>
								<input type='submit' className='button' value='Submit' />
							</li>
						</ul>
					</form>
				</div>
			);
		}
	}
    

ReactDOM.render(<ContactForm />, document.querySelector(selector));


