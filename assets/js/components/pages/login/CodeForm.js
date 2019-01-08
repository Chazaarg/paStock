import React, { Component } from "react";
import { connect } from "react-redux";
import PropTypes from "prop-types";
import { sendPasswordCode } from "../../../actions/usuarioActions";
import { notifyUser } from "../../../actions/notifyActions";
import Alert from "../../alert/Alert";

class CodeForm extends Component {
  state = {
    code: ""
  };
  componentWillUnmount() {
    //Hago un clear a notify si se sale del componente.
    const { message } = this.props.notify;
    const { notifyUser } = this.props;

    message && notifyUser(null, null, null);
  }
  prev = e => {
    e.preventDefault();
    this.props.prevStep();
  };
  onChange = e => {
    this.setState({ [e.target.name]: e.target.value });
  };

  onSubmit = e => {
    e.preventDefault();
    const { code } = this.state;
    const { email } = this.props;

    this.props.sendPasswordCode({ code, email }).then(() => {
      if (this.props.notify.messageType === "success") {
        this.props.nextStep();
        this.props.onChange({ key: "code", value: code });
      }
      setTimeout(() => {
        this.props.notifyUser(null, null, null);
      }, 10000);
    });
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
              <h6 className="card-subtitle mb-2 text-success">
                ¡Email enviado con éxito!
              </h6>
              <p className="card-text mb-4">
                <br />
                Por favor ingrese el código enviado.
              </p>
              <form onSubmit={this.onSubmit} id="login-form">
                <div className="form-group">
                  <label htmlFor="code">Ingrese el código</label>
                  <input
                    id="code"
                    type="text"
                    name="code"
                    className="form-control register"
                    value={this.state.code}
                    onChange={this.onChange}
                  />
                </div>

                <input
                  type="submit"
                  value="Ingresar código"
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
CodeForm.propTypes = {
  sendPasswordCode: PropTypes.func.isRequired,
  notifyUser: PropTypes.func.isRequired,
  notify: PropTypes.object.isRequired
};

const mapStateToProps = state => ({
  notify: state.notify
});

export default connect(
  mapStateToProps,
  {
    sendPasswordCode,
    notifyUser
  }
)(CodeForm);
