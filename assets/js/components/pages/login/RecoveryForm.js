import React, { Component } from "react";
import { connect } from "react-redux";
import PropTypes from "prop-types";
import { recoverPassword } from "../../../actions/usuarioActions";
import { notifyUser } from "../../../actions/notifyActions";
import Alert from "../../alert/Alert";

class RecoveryForm extends Component {
  state = {
    email: ""
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
  onSubmit = e => {
    e.preventDefault();
    const { email } = this.state;

    this.props.recoverPassword({ email }).then(() => {
      if (this.props.notify.messageType === "success") {
        this.props.nextStep();
        this.props.onChange({ key: "email", value: email });
      }
      setTimeout(() => {
        this.props.notifyUser(null, null, null);
      }, 10000);
    });
  };

  prev = e => {
    e.preventDefault();
    this.props.prevStep();
  };

  render() {
    const { message, messageType, errors } = this.props.notify;

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
                Recuperar contraseña
              </h1>

              <hr />
              <p className="card-text mb-4">
                Ingrese su correo electrónico y le llegara un mail con un código
                para cambiar su contraseña:
              </p>
              <form onSubmit={this.onSubmit} id="login-form">
                <div className="form-group">
                  <label htmlFor="email">Email</label>
                  <input
                    id="email"
                    type="text"
                    name="email"
                    className="form-control register"
                    value={this.state.email}
                    onChange={this.onChange}
                  />
                </div>

                <input
                  type="submit"
                  value="Aceptar"
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

RecoveryForm.propTypes = {
  recoverPassword: PropTypes.func.isRequired,
  notifyUser: PropTypes.func.isRequired,
  notify: PropTypes.object.isRequired
};

const mapStateToProps = state => ({
  notify: state.notify
});

export default connect(
  mapStateToProps,
  {
    recoverPassword,
    notifyUser
  }
)(RecoveryForm);
