import React from "react";

export default function Vendedor() {
  return (
    <div className="col-5">
      <div className="form-row">
        <div className="form-group col-10">
          <input
            type="text"
            className="form-control"
            id="nombreCliente"
            placeholder="Nombre"
          />
        </div>
      </div>
      <div className="form-row">
        <div className="form-group col-10">
          <input
            type="text"
            className="form-control"
            id="telefonoCliente"
            placeholder="Teléfono"
          />
        </div>
      </div>
      <div className="form-row">
        <div className="form-group col-5">
          <input
            type="text"
            className="form-control"
            id="emailCliente"
            placeholder="Email"
          />
        </div>
        <div className="form-group col-5">
          <input
            type="text"
            className="form-control"
            id="dniCliente"
            placeholder="DNI"
          />
        </div>
      </div>
      <div className="form-row">
        <div className="form-group col-5">
          <input
            type="text"
            className="form-control"
            id="direccionCliente"
            placeholder="Dirección"
          />
        </div>
        <div className="form-group col-5">
          <input
            type="text"
            className="form-control"
            id="localidadCliente"
            placeholder="Localidad"
          />
        </div>
      </div>
      <div className="form-row">
        <button className="btn btn-secondary" id="agregarCliente" type="button">
          Agregar Cliente
        </button>
      </div>
    </div>
  );
}
