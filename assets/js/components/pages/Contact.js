import React, { Component } from "react";
import { notifyUser } from "../../actions/notifyActions";
import { sendEmail } from "../../actions/usuarioActions";

import { connect } from "react-redux";
import PropTypes from "prop-types";
import ProductoAlert from "../alert/ProductoAlert";

class Contact extends Component {
  state = {
    name: "",
    email: "",
    message: ""
  };

  componentWillUnmount() {
    //Esto hace un clear a notify cada vez que cambie de ruta.
    const { message } = this.props.notify;
    const { notifyUser } = this.props;

    message && notifyUser(null, null, null);
  }
  onChange = e => {
    this.setState({ [e.target.name]: e.target.value });
  };
  onSubmit = e => {
    e.preventDefault();
    const { name, email, message } = this.state;
    const mail = {
      name,
      email,
      message
    };

    this.props.sendEmail(mail).then(() => {
      if (this.props.notify.messageType === "success") {
        this.setState = {
          name: "",
          email: "",
          message: ""
        };
      }

      //Luego de unos segundos borro el mensaje
      setTimeout(() => {
        this.props.notifyUser(null, null, null);
      }, 10000);
      window.scrollTo(0, 0);
    });
  };
  render() {
    document.title = "Contacto";

    const { notify } = this.props;

    return (
      <section id="contact">
        <h1 className="section-header">CONTACTO</h1>
        {notify.message ? (
          <div className="m-auto" style={{ maxWidth: "23rem" }}>
            <ProductoAlert
              message={notify.message}
              messageType={notify.messageType}
              errors={notify.errors}
            />
          </div>
        ) : null}

        <div className="contact-wrapper">
          <form className="form-horizontal" onSubmit={this.onSubmit} noValidate>
            <div className="form-group">
              <div className="col-sm-12">
                <input
                  type="text"
                  className="form-control contact"
                  id="name"
                  placeholder="NOMBRE"
                  name="name"
                  onChange={this.onChange}
                />
              </div>
            </div>

            <div className="form-group">
              <div className="col-sm-12">
                <input
                  type="email"
                  className="form-control contact"
                  id="email"
                  placeholder="EMAIL"
                  name="email"
                  onChange={this.onChange}
                />
              </div>
            </div>

            <textarea
              className="form-control contact"
              rows="10"
              placeholder="MENSAJE"
              name="message"
              onChange={this.onChange}
            />

            <button
              className="btn btn-primary send-button"
              id="submit"
              type="submit"
              value="SEND"
            >
              <div className="button">
                <i className="fa fa-paper-plane" />
                <span className="send-text">ENVIAR</span>
              </div>
            </button>
          </form>

          <div className="direct-contact-container">
            <ul className="contact-list">
              <li className="list-item">
                <i className="fa fa-phone fa-2x">
                  <span className="contact-text phone">
                    <a href="tel:1-212-555-5555" title="Llamame">
                      (015) 2314-6048
                    </a>
                  </span>
                </i>
              </li>

              <li className="list-item">
                <i className="fa fa-envelope fa-2x">
                  <span className="contact-text gmail">
                    <a href="mailto:#" title="Enviame un mail">
                      chazarreta.patricio@gmail.com
                    </a>
                  </span>
                </i>
              </li>
            </ul>

            <div className="author">Chazarreta Patricio</div>
            <hr style={{ borderColor: "#111" }} />
            <ul className="social-media-list d-flex justify-content-between">
              <li>
                <a
                  href="#"
                  target="_blank"
                  className="contact-icon"
                  style={{
                    fontSize: "1.9rem"
                  }}
                >
                  CV
                </a>
              </li>
              <li>
                <a href="#" target="_blank" class="contact-icon">
                  <i class="fas fa-globe" />
                </a>
              </li>
            </ul>
          </div>
        </div>
      </section>
    );
  }
}

Contact.propTypes = {
  notifyUser: PropTypes.func.isRequired,
  sendEmail: PropTypes.func.isRequired,
  notify: PropTypes.object.isRequired
};

const mapStateToProps = state => ({
  notify: state.notify
});

export default connect(
  mapStateToProps,
  { notifyUser, sendEmail }
)(Contact);
