import React from 'react';
import ReactDOM from 'react-dom';

class LoginForm extends React.Component {
    render() {
        return (
            <div className="container">
                <div className="row">
                    <div className="col-4"></div>
                    <form method="post" className="col-md-4">

                        <div className="form-group">
                            <label htmlFor="username">Login</label>
                            <input type="text" className="form-control" id="username" name="_username"
                                   value="" required="required" aria-describedby="Username"
                                   placeholder="Username" />
                        </div>
                        <div className="form-group">
                            <label htmlFor="password">Password</label>
                            <input type="password" className="form-control" id="password" name="_password" required="required"
                                   placeholder="Password"/>
                        </div>
                        <div className="form-group form-check">
                            <input type="checkbox" id="remember_me" className="form-check-input" name="_remember_me"
                                   value="on"/>
                            <label htmlFor="remember_me">Remember me</label>
                        </div>
                        <input type="submit" className="btn btn-primary" name="_submit"
                               value="Submit"/>
                    </form>
                </div>
            </div>
        );
    }
}

export default LoginForm;