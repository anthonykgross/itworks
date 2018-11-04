import React from 'react';
import ReactDOM from 'react-dom';
import Card from './Card';

class SearchResult extends React.Component {
    videos = [
        {youtube_id : "pD5ugHBLzPA", title:"Spécifications du client et analyse des besoins #1 - It Works !"},
        {youtube_id : "VNG24gdYZL8", title:"Modélisation des données #2 - It Works !"},
        {youtube_id : "DiAzeqHMZrg", title:"Bundles et entités #3 - It Works !"},
        {youtube_id : "U2-71RdoE_U", title:"Dependency injection #4 - It Works !"},
        {youtube_id : "w9mCr5wdEQ4", title:"Responsive design avec Bootstrap #5 - It Works !"}
    ];

    render() {
        const cards = this.videos.map((v) =>
            <Card title={v.title} youtube_id={v.youtube_id} />
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