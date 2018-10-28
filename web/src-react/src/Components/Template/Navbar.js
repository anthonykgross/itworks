import React from 'react';
import ReactDOM from 'react-dom';

class Navbar extends React.Component {
    render() {
        return (
            <nav className="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
                <a className="navbar-brand" href="">It works</a>
                <button className="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarsExampleDefault"
                        aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                    <span className="navbar-toggler-icon"></span>
                </button>

                <div className="collapse navbar-collapse" id="navbarsExampleDefault">
                    <ul className="navbar-nav mr-auto">
                        <li className="nav-item dropdown">
                            <a className="nav-link dropdown-toggle" href="" id="dropdown01"
                               data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false"></a>
                            <div className="dropdown-menu" aria-labelledby="dropdown01">
                                <a className="dropdown-item" href="">Profil</a>
                                <a className="dropdown-item" href="">Admin</a>
                                <a className="dropdown-item"
                                   href="">Deconnexion</a>
                            </div>
                        </li>
                        <li className="nav-item">
                            <a className="nav-link" href="">Connexion</a>
                        </li>
                    </ul>
                    <form className="form-inline my-2 my-lg-0" action="" method="GET">
                        <input className="form-control mr-sm-2" name="q" type="text" placeholder="Recherche"
                               aria-label="Search" />
                            <button className="btn btn-outline-success my-2 my-sm-0" type="submit">Go</button>
                    </form>
                </div>
            </nav>
        );
    }
}

export default Navbar;
