import React from 'react';
import ReactDOM from 'react-dom';
import Footer from './Footer';
import Navbar from './Navbar';
import Homepage from '../Views/Homepage/Homepage';
import SearchResult from '../Views/SearchResult/SearchResult';
import LoginForm from '../Views/Login/LoginForm';

class Template extends React.Component {
    render() {
        return (
            <div>
                <Navbar/>
                <LoginForm />
                <Footer/>
            </div>
        );
    }
}

export default Template;