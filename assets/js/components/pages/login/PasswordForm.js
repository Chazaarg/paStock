import React, { Component } from "react";
import PropTypes from "prop-types";
import { connect } from "react-redux";
import { notifyUser } from "../../../actions/notifyActions";
import { changePassword } from "../../../actions/usuarioActions";
import Alert from "../../alert/Alert";

class PasswordForm extends Component {
  state = {
    password: "",
    capsLock: false,
    showPass: false
  };

  componentWillUnmount() {
    //Hago un clear a notify si se sale del componente.
    const { message } = this.props.notify;
    const { notifyUser } = this.props;

    message && notifyUser(null, null, null);
  }

  onChange = e => {
    this.setState({ [e.target.name]: e.target.value });
  };

  prev = e => {
    e.preventDefault();
    this.props.prevStep();
  };

  onSubmit = e => {
    e.preventDefault();
    const { password } = this.state;
    const { email, code } = this.props;

    this.props.changePassword({ code, email, password }).then(() => {
      if (this.props.notify.messageType === "success") {
        this.props.nextStep();
      }
      setTimeout(() => {
        this.props.notifyUser(null, null, null);
      }, 10000);
    });
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

  render() {
    const { message, messageType, errors } = this.props.notify;

    const passwordInput = document.getElementById("password");

    if (passwordInput) {
      if (this.state.showPass) {
        passwordInput.type = "text";
      } else {
        passwordInput.type = "password";
      }
    }

    return (
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
              <h1 className="text-center pb-4 pt-3 card-title">
                Ingrese la nueva contraseña.
              </h1>
              <hr />
              <form onSubmit={this.onSubmit} id="login-form">
                <div className="form-group">
                  <label htmlFor="password">Ingrese la nueva contraseña.</label>
                  <i
                    className="far fa-question-circle float-right mr-1"
                    title="La contraseña debe tener mínimo 6 caracteres y contener una letra y un número."
                    style={{
                      fontSize: "1rem",
                      cursor: "help"
                    }}
                  />
                  <div className="input-group mt-3">
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
                  value="Enviar contraseña"
                  className="btn btn-dark btn-block"
                />
              </form>
              <div className="row pt-3">
                <div className="col-6">
                  <a href="" className="card-link" onClick={this.prev}>
                    Volver
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    );
  }
}

PasswordForm.propTypes = {
  notifyUser: PropTypes.func.isRequired,
  notify: PropTypes.object.isRequired,
  changePassword: PropTypes.func.isRequired
};

const mapStateToProps = state => ({
  notify: state.notify
});

export default connect(
  mapStateToProps,
  {
    notifyUser,
    changePassword
  }
)(PasswordForm);
