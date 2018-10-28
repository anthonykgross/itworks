import React from 'react';
import ReactDOM from 'react-dom';
import Footer from './Footer';
import Navbar from './Navbar';
import Jumbotron from '../Views/Homepage/Jumbotron';
import Columns from '../Views/Homepage/Columns';

class Template extends React.Component {
    render() {
        return (
            <div>
                <Navbar/>
                <Jumbotron />
                <Columns />
                <Footer/>
            </div>
        );
    }
}

export default Template;