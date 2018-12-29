import React, { Component } from "react";
import { connect } from "react-redux";
import PropTypes from "prop-types";
import { addCliente, deleteCliente } from "../../actions/ventaActions";
import { notifyUser } from "../../actions/notifyActions";

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

  onClienteSubmit = () => {
    if (this.props.cliente.id) {
      this.props.deleteCliente(this.props.cliente.id).then(() => {
        this.props.notifyUser(
          `Categoria ${this.props.cliente.nombre.toUpperCase()} eliminada.`,
          "warning",
          null
        );
      });
    }
  };

  onSubmit = e => {
    const { addCliente, notifyUser, newProp } = this.props;
    e.preventDefault();
    //Selecciona la nueva marca en el DOM.
    addCliente(this.state).then(() => {
      if (this.props.notify.messageType === "success") {
        newProp("cliente");

        this.setState({
          nombre: "",
          apellido: "",
          telefono: "",
          email: "",
          dni: "",
          direccion: "",
          localidad: ""
        });
        document.getElementById("cliente").classList.add("is-valid");
      }
    });

    //Luego de unos segundos borro el mensaje
    setTimeout(() => {
      notifyUser(null, null, null);
      document.getElementById("cliente").classList.remove("is-valid");
    }, 10000);
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
        <div className="row">
          <button
            type="button"
            className="text-danger btn btn-link pt-0 pb-0"
            onClick={this.onClienteSubmit}
          >
            <small>Eliminar CLIENTE seleccionado.</small>
          </button>
        </div>
        <hr />
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
  notify: PropTypes.object.isRequired,
  notifyUser: PropTypes.func.isRequired,
  addCliente: PropTypes.func.isRequired,
  deleteCliente: PropTypes.func.isRequired
};

const mapStateToProps = state => ({
  notify: state.notify
});
export default connect(
  mapStateToProps,
  { addCliente, deleteCliente, notifyUser }
)(Cliente);
