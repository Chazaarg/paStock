import React, { Component } from "react";
import { connect } from "react-redux";
import PropTypes from "prop-types";
import { addVendedor } from "../../actions/ventaActions";

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
    e.preventDefault();
    this.props.addVendedor(this.state);
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
  addVendedor: PropTypes.func.isRequired
};
export default connect(
  null,
  { addVendedor }
)(Vendedor);
