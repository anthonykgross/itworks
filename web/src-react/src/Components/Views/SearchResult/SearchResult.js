import React from 'react';
import ReactDOM from 'react-dom';
import Card from './Card';

class SearchResult extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        const cards = this.props.items.map((v, index) =>
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