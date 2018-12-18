import React, { Component } from "react";

class Contact extends Component {
  state = {
    name: "",
    email: "",
    message: ""
  };
  onChange = e => {
    this.setState({ [e.target.name]: e.target.value });
  };
  render() {
    return (
      <section id="contact">
        <h1 className="section-header">CONTACTO</h1>

        <div className="contact-wrapper">
          <form className="form-horizontal" role="form">
            <div className="form-group">
              <div className="col-sm-12">
                <input
                  type="text"
                  className="form-control"
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
                  className="form-control"
                  id="email"
                  placeholder="EMAIL"
                  name="email"
                  onChange={this.onChange}
                />
              </div>
            </div>

            <textarea
              className="form-control"
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
                    <a href="tel:1-212-555-5555" title="Give me a call">
                      (015) 2314-6048
                    </a>
                  </span>
                </i>
              </li>

              <li className="list-item">
                <i className="fa fa-envelope fa-2x">
                  <span className="contact-text gmail">
                    <a href="mailto:#" title="Send me an email">
                      pastock@gmail.com
                    </a>
                  </span>
                </i>
              </li>
            </ul>

            <div className="author">Chazarreta Patricio</div>
            <hr style={{ borderColor: "#111" }} />
            <ul className="social-media-list">
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
            </ul>
          </div>
        </div>
      </section>
    );
  }
}
export default Contact;
