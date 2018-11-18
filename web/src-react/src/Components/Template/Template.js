import React from 'react';
import ReactDOM from 'react-dom';
import Footer from './Footer';
import Navbar from './Navbar';
import Homepage from '../Views/Homepage/Homepage';
import SearchResult from '../Views/SearchResult/SearchResult';
import LoginForm from '../Views/Login/LoginForm';

class Template extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            keywords: '',
        };

        this.handleChange = this.handleChange.bind(this);
    }

    handleChange(event) {
        this.setState({keywords: event.target.value});
    }

    render() {
        return (
            <div>
                <Navbar onChange={this.handleChange}/>
                <SearchResult keywords={this.state.keywords} />
                <Footer/>
            </div>
        );
    }
}

export default Template;