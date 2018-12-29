import React, { Component } from "react";
import { registerUser } from "../../actions/usuarioActions";
import { connect } from "react-redux";
import PropTypes from "prop-types";
import Alert from "../alert/Alert";
import { notifyUser } from "../../actions/notifyActions";

class Register extends Component {
  state = {
    username: "",
    password: "",
    email: "",
    passwordVerifyIsValid: true
  };

  componentWillUnmount() {
    //Esto hace un clear a notify cada vez que cambie de ruta.
    const { message } = this.props.notify;
    const { notifyUser } = this.props;

    message && notifyUser(null, null, null);
  }

  onSubmit = e => {
    e.preventDefault();

    const { username, password, email, passwordVerifyIsValid } = this.state;
    const { registerUser } = this.props;

    registerUser({ username, password, email, passwordVerifyIsValid });
  };

  onChange = e => {
    this.setState({ [e.target.name]: e.target.value });

    //Verificar contraseña.
    if (e.target.name === "password") {
      this.verifyPassword();
    }
  };

  verifyPassword = () => {
    const passRegister = document.getElementById("passwordRegister");
    const passRepeat = document.getElementById("passwordRepeat");

    //Creo el elemento small que contendrá el mensaje de error.
    const small = document.createElement("small");
    small.classList.add("float-right", "text-danger");
    small.innerHTML = "La contraseña no coincide.";

    //Primero me deshago de errores anteriores.
    if (passRepeat.classList.contains("is-invalid")) {
      passRepeat.classList.remove("is-invalid");
      passRepeat.parentElement.removeChild(
        passRepeat.parentElement.getElementsByClassName("text-danger")[0]
      );
    }

    if (passRepeat.value === passRegister.value) {
      passRepeat.classList.add("is-valid");
      this.setState({ passwordVerifyIsValid: true });
    } else {
      passRepeat.classList.add("is-invalid");
      passRepeat.parentElement.prepend(small);
      this.setState({ passwordVerifyIsValid: false });
    }
  };

  onGoogleClick = e => {
    e.preventDefault();
    window.location.replace("/api/connect/google");
  };
  render() {
    document.title = "Registrarse";

    const { message, messageType, errors } = this.props.notify;

    return (
      <div>
        <div className="row">
          <div className="col-md-6 mx-auto">
            <div className="card">
              <div className="card-body">
                {//Si hay un mensaje, entonces lo muestro en la alerta.
                message ? (
                  <Alert
                    message={message}
                    messageType={messageType}
                    errors={errors}
                  />
                ) : null}
                <h1 className="text-center pb-4 pt-3">Registrarse</h1>
                <form onSubmit={this.onSubmit} noValidate>
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
                    <i
                      className="far fa-question-circle float-right mr-1"
                      title="La contraseña debe tener mínimo 6 caracteres y contener una letra y un número."
                      style={{
                        fontSize: "1rem",
                        cursor: "help"
                      }}
                    />
                    <input
                      id="passwordRegister"
                      type="password"
                      name="password"
                      className="form-control register"
                      value={this.state.password}
                      onChange={this.onChange}
                    />
                  </div>
                  <div className="form-group">
                    <label htmlFor="passwordRepeat">Repetir Contraseña</label>
                    <input
                      id="passwordRepeat"
                      type="password"
                      name="passwordRepeat"
                      className="form-control"
                      onChange={this.verifyPassword}
                    />
                  </div>
                  <div className="form-group">
                    <label htmlFor="email">Email</label>
                    <input
                      type="email"
                      name="email"
                      className="form-control register"
                      value={this.state.email}
                      onChange={this.onChange}
                    />
                  </div>
                  <input
                    type="submit"
                    value="Registrarse"
                    className="btn btn-dark btn-block"
                  />
                </form>
                <div className="row  pt-3">
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

Register.propTypes = {
  registerUser: PropTypes.func.isRequired,
  notifyUser: PropTypes.func.isRequired
};

export default connect(
  (state, props) => ({
    notify: state.notify
  }),
  {
    registerUser,
    notifyUser
  }
)(Register);
