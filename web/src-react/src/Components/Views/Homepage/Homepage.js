import React from 'react';
import ReactDOM from 'react-dom';
import Jumbotron from './Jumbotron';
import Columns from './Columns';

class Homepage extends React.Component {
    render() {
        return (
            <div>
                <Jumbotron />
                <Columns />
            </div>
        );
    }
}

export default Homepage;