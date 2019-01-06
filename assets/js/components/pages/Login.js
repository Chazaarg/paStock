import React, { Component } from "react";
import { login } from "../../actions/usuarioActions";
import { connect } from "react-redux";
import PropTypes from "prop-types";
import Alert from "../alert/Alert";
import { notifyUser } from "../../actions/notifyActions";

class Login extends Component {
  state = {
    username: "",
    password: "",
    capsLock: false,
    showPass: false
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
  capsLock = e => {
    if (e.getModifierState("CapsLock")) {
      this.setState({ capsLock: true });
    } else {
      this.setState({ capsLock: false });
    }
  };

  viewpass = e => {
    this.setState({ showPass: !this.state.showPass });
  };
  onChange = e => {
    this.setState({ [e.target.name]: e.target.value });
  };
  onGoogleClick = e => {
    e.preventDefault();
    window.location.replace("/api/connect/google");
  };
  render() {
    document.title = "Login";
    const passwordInput = document.getElementById("password");

    if (passwordInput) {
      if (this.state.showPass) {
        passwordInput.type = "text";
      } else {
        passwordInput.type = "password";
      }
    }

    const { message, messageType, errors } = this.props.notify;
    return (
      <React.Fragment>
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
                <form onSubmit={this.onSubmit} id="login-form">
                  <div className="form-group">
                    <label htmlFor="username">Usuario</label>
                    <input
                      id="username"
                      type="text"
                      name="username"
                      className="form-control register"
                      value={this.state.username}
                      onChange={this.onChange}
                    />
                  </div>

                  <div className="form-group">
                    <label htmlFor="password">Contraseña</label>
                    <div className="input-group">
                      <input
                        type="password"
                        name="password"
                        id="password"
                        className="form-control register"
                        value={this.state.password}
                        onChange={this.onChange}
                        style={{ borderRight: "none" }}
                        onKeyUp={this.capsLock}
                      />
                      <div className="input-group-append">
                        <label className="input-group-text" id="passlabel">
                          <div
                            id="caps"
                            className="d-flex align-items-center justify-content-center"
                          >
                            {this.state.capsLock ? (
                              <i className="fas fa-caret-up" />
                            ) : null}
                          </div>
                          <div
                            id="viewpass"
                            className="d-flex align-items-center justify-content-center"
                          >
                            {this.state.showPass ? (
                              <i
                                className="far fa-eye-slash"
                                onMouseUp={this.viewpass}
                              />
                            ) : (
                              <i
                                className="far fa-eye"
                                onMouseDown={this.viewpass}
                              />
                            )}
                          </div>
                        </label>
                      </div>
                    </div>
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
      </React.Fragment>
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
