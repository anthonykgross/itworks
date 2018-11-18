import React from 'react';
import ReactDOM from 'react-dom';
import Card from './Card';

class SearchResult extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            error: null,
            isLoaded: false,
            items: []
        };
    }

    componentDidMount() {
        this.refreshData();
    }

    refreshData() {
        fetch("http://localhost/app_dev.php/videos", {headers: {'accept': 'application/json'}})
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
        console.log(this.props.keywords);

        const cards = this.state.items.map((v, index) =>
            <Card key={index} title={v.title} youtube_id={v.youtubeId}/>
        );

        return (
            <div className="container">
                <div className="row">
                    {cards}
                </div>
            </div>
        );
    }
}

export default SearchResult;