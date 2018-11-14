import React from 'react';
import ReactDOM from 'react-dom';

class LoginForm extends React.Component {

    constructor(props) {
        super(props);
        this.state = {username: '', password: '', token: '', message: ''};

        this.handleSubmit = this.handleSubmit.bind(this);
        this.handleChange = this.handleChange.bind(this);
    }

    handleSubmit(event) {
        fetch("http://localhost/app_dev.php/login_check", {
            headers: {'Content-Type': 'application/json'},
            method: 'POST',
            body: JSON.stringify({
                email: this.state.username,
                password: this.state.password,
            })
        })
        .then(response => {
            if ([400, 401, 403].includes(response.status)) {
                throw new Error('Login failed');
            }
            return response.json();
        })
        .then(
            (result) => {
                this.setState({
                    token: result.token,
                    message: 'Login succeeded'
                });
            },
            (error) => {
                this.setState({
                    token: '',
                    message: error.message
                });
            }
        );
        event.preventDefault();
    };

    handleChange(event) {
        this.setState({
            [event.target.id]: event.target.value
        });
    };

    render() {
        return (
            <div className="container">
                <div className="row">
                    <div className="col-4"></div>
                    <form method="post" className="col-md-4"  onSubmit={this.handleSubmit}>
                        <div>{this.state.message}</div>
                        <div className="form-group">
                            <label htmlFor="username">Login</label>
                            <input type="text" className="form-control" id="username" name="_username"
                                   required="required" aria-describedby="Username"
                                   placeholder="Username"
                                   value={this.state.username} onChange={this.handleChange}
                            />
                        </div>
                        <div className="form-group">
                            <label htmlFor="password">Password</label>
                            <input type="password" className="form-control" id="password" name="_password" required="required"
                                   placeholder="Password"
                                   value={this.state.password} onChange={this.handleChange}
                            />
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