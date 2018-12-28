import React, { Component } from "react";
import { connect } from "react-redux";
import PropTypes from "prop-types";
import { addVendedor } from "../../actions/ventaActions";
import { notifyUser } from "../../actions/notifyActions";

class Vendedor extends Component {
  state = {
    nombre: "",
    apellido: "",
    apodo: ""
  };
  onChange = e => {
    this.setState({
      [e.target.name]: e.target.value
    });
  };
  onSubmit = e => {
    const { addVendedor, notifyUser, newProp } = this.props;

    e.preventDefault();
    //Selecciona la nueva marca en el DOM.

    addVendedor(this.state).then(() => {
      if (this.props.notify.messageType === "success") {
        newProp("vendedor");

        this.setState({
          nombre: "",
          apellido: "",
          apodo: ""
        });
        document.getElementById("vendedor").classList.add("is-valid");
      }
    });

    //Luego de unos segundos borro el mensaje
    setTimeout(() => {
      notifyUser(null, null, null);
      document.getElementById("cliente").classList.remove("is-valid");
    }, 10000);
  };
  render() {
    const { nombre, apellido, apodo } = this.state;
    return (
      <div className="col-5 vendedor">
        <div className="form-row">
          <div className="form-group col-5">
            <input
              type="text"
              className="form-control"
              value={nombre}
              placeholder="Nombre"
              onChange={this.onChange}
              name="nombre"
            />
          </div>
          <div className="form-group col-5">
            <input
              type="text"
              className="form-control"
              value={apellido}
              placeholder="Apellido"
              onChange={this.onChange}
              name="apellido"
            />
          </div>
        </div>
        <div className="form-row">
          <div className="form-group col-5">
            <input
              type="text"
              className="form-control"
              value={apodo}
              placeholder="Apodo"
              onChange={this.onChange}
              name="apodo"
            />
          </div>
        </div>

        <div className="form-row">
          <button
            className="btn btn-secondary"
            type="button"
            onClick={this.onSubmit}
          >
            Agregar Vendedor
          </button>
        </div>
      </div>
    );
  }
}
Vendedor.propTypes = {
  notify: PropTypes.object.isRequired,
  notifyUser: PropTypes.func.isRequired,
  addVendedor: PropTypes.func.isRequired
};

const mapStateToProps = state => ({
  notify: state.notify
});

export default connect(
  mapStateToProps,
  { addVendedor, notifyUser }
)(Vendedor);
