import React from 'react';
import ReactDOM from 'react-dom';
import Footer from './Footer';
import Navbar from './Navbar';
import Homepage from '../Views/Homepage/Homepage';
import SearchResult from '../Views/SearchResult/SearchResult';
import LoginForm from '../Views/Login/LoginForm';
import Card from "../Views/SearchResult/Card";
import { BrowserRouter as Router, Route, Link } from "react-router-dom"

class Template extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            keywords: '',
            items: [],
            isLoaded: false,
            error: ''
        };

        this.handleChange = this.handleChange.bind(this);
    }

    handleChange(event) {
        this.setState({keywords: event.target.value});
        this.refreshData();
    }

    componentDidMount(){
        this.refreshData();
    }

    refreshData() {
        fetch("http://localhost/app_dev.php/videos?title="+this.state.keywords, {headers: {'accept': 'application/json'}})
            .then(res => res.json())
            .then(
                (result) => {
                    this.setState({
                        isLoaded: true,
                        items: result
                    });
                },
                (error) => {
                    this.setState({
                        isLoaded: true,
                        error
                    });
                }
            );
    }

    render() {
        return (
            <Router>
                <div>
                    <Navbar onChange={this.handleChange}/>
                    {/*<SearchResult items={this.state.items} />*/}
                    <Route path="/" exact component={Homepage} />
                    <Route path="/login" component={LoginForm} />
                    <Route path="/search" component={SearchResult} />
                    <Footer/>
                </div>
            </Router>
        );
    }
}

export default Template;