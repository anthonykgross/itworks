import React from 'react';
import ReactDOM from 'react-dom';

class Card extends React.Component {
    render() {
        return (
            <div className="col-3">
                <div className="card">
                    <a href="#">
                        <img className="card-img-top" src={'https://img.youtube.com/vi/' + this.props.youtube_id + '/hqdefault.jpg'} />
                    </a>
                    <div className="card-body">
                        <div className="card-title">
                            {this.props.title}
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default Card;