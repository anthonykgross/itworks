import React from 'react';
import ReactDOM from 'react-dom';

class Jumbotron extends React.Component {
    render() {
        return (
            <div class="jumbotron">
                <div class="container">
                    <h1 class="display-3">Hey, mate!</h1>
                    <p>
                        Tu suis la série It works sur Youtube et tu souhaites tester ce que nous développons ensemble par toi-même . Bienvenue ! Si tu ne sais pas de quoi je parle ou tu desires savoir comment a ete fait cette application, je t'invite à me suivre sur Youtube.
                    </p>
                    <p>
                        <a class="btn btn-primary btn-lg" href="http://youtube.anthonykgross.fr" role="button">Regarder la serie</a>
                        <a class="btn btn-danger btn-lg" href="" role="button">Synchroniser avec Youtube</a>
                    </p>
                </div>
            </div>
        );
    }
}

export default Jumbotron;