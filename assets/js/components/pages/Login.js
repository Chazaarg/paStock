import React, { Component } from "react";
import { login } from "../../actions/usuarioActions";
import { connect } from "react-redux";
import PropTypes from "prop-types";
import Alert from "../layout/Alert";
import { notifyUser } from "../../actions/notifyActions";

class Login extends Component {
  state = {
    username: "",
    password: ""
  };

  componentWillUnmount() {
    const { message } = this.props.notify;
    const { notifyUser } = this.props;

    message && notifyUser(null, null, null);
  }

  onSubmit = e => {
    e.preventDefault();

    const { username, password } = this.state;

    this.props.login({ username, password });
  };
  onChange = e => this.setState({ [e.target.name]: e.target.value });
  onGoogleClick = e => {
    e.preventDefault();
    window.location.replace("/api/connect/google");
  };
  render() {
    document.title = "Login";

    const { message, messageType, errors } = this.props.notify;
    return (
      <div>
        <div className="row">
          <div className="col-md-6 mx-auto">
            <div className="card">
              <div className="card-body">
                {message ? (
                  <Alert
                    message={message}
                    messageType={messageType}
                    errors={errors}
                  />
                ) : null}
                <h1 className="text-center pb-4 pt-3">Ingresar</h1>
                <form onSubmit={this.onSubmit}>
                  <div className="form-group">
                    <label htmlFor="username">Usuario</label>
                    <input
                      type="text"
                      name="username"
                      className="form-control register"
                      value={this.state.username}
                      onChange={this.onChange}
                    />
                  </div>
                  <div className="form-group">
                    <label htmlFor="password">Contraseña</label>
                    <input
                      type="password"
                      name="password"
                      className="form-control register"
                      value={this.state.password}
                      onChange={this.onChange}
                    />
                  </div>
                  <input
                    type="submit"
                    value="Login"
                    className="btn btn-dark btn-block"
                  />
                </form>
                <div className="row pt-3">
                  <div className="col-6">
                    <button
                      className="btn btn-success"
                      onClick={this.onGoogleClick}
                    >
                      Ingresar con Google
                    </button>
                  </div>
                  <div className="col-6" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    );
  }
}

Login.propTypes = {
  login: PropTypes.func.isRequired,
  notifyUser: PropTypes.func.isRequired
};

export default connect(
  (state, props) => ({
    notify: state.notify
  }),
  {
    login,
    notifyUser
  }
)(Login);
