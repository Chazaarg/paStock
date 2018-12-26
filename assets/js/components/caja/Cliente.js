import React, { Component } from "react";
import { connect } from "react-redux";
import PropTypes from "prop-types";
import { addCliente } from "../../actions/ventaActions";

class Cliente extends Component {
  state = {
    nombre: "",
    apellido: "",
    telefono: "",
    email: "",
    dni: "",
    direccion: "",
    localidad: ""
  };
  onChange = e => {
    this.setState({
      [e.target.name]: e.target.value
    });
  };

  onSubmit = e => {
    e.preventDefault();
    this.props.addCliente(this.state);
  };

  render() {
    const {
      nombre,
      apellido,
      telefono,
      email,
      dni,
      direccion,
      localidad
    } = this.state;
    return (
      <div className="col-5 cliente">
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
          <div className="form-group col-10">
            <input
              type="text"
              className="form-control"
              value={telefono}
              placeholder="Teléfono"
              name="telefono"
              onChange={this.onChange}
            />
          </div>
        </div>
        <div className="form-row">
          <div className="form-group col-5">
            <input
              type="text"
              className="form-control"
              value={email}
              placeholder="Email"
              onChange={this.onChange}
              name="email"
            />
          </div>
          <div className="form-group col-5">
            <input
              type="text"
              className="form-control"
              value={dni}
              placeholder="DNI"
              onChange={this.onChange}
              name="dni"
            />
          </div>
        </div>
        <div className="form-row">
          <div className="form-group col-5">
            <input
              type="text"
              className="form-control"
              value={direccion}
              placeholder="Dirección"
              onChange={this.onChange}
              name="direccion"
            />
          </div>
          <div className="form-group col-5">
            <input
              type="text"
              className="form-control"
              value={localidad}
              placeholder="Localidad"
              onChange={this.onChange}
              name="localidad"
            />
          </div>
        </div>
        <div className="form-row">
          <button
            className="btn btn-secondary"
            onClick={this.onSubmit}
            type="button"
          >
            Agregar Cliente
          </button>
        </div>
      </div>
    );
  }
}
Cliente.propTypes = {
  addCliente: PropTypes.func.isRequired
};
export default connect(
  null,
  { addCliente }
)(Cliente);
