import React from "react";

export default function Cliente() {
  return (
    <div className="col-5">
      <div className="form-row">
        <div className="form-group col-5">
          <input
            type="text"
            className="form-control"
            id="inputAddress"
            placeholder="Nombre"
          />
        </div>
        <div className="form-group col-5">
          <input
            type="text"
            className="form-control"
            id="inputAddress2"
            placeholder="Apellido"
          />
        </div>
      </div>
      <div className="form-row">
        <div className="form-group col-5">
          <input
            type="text"
            className="form-control"
            id="inputAddress2"
            placeholder="Apodo"
          />
        </div>
      </div>

      <div className="form-row">
        <button className="btn btn-secondary" type="button">
          Agregar Vendedor
        </button>
      </div>
    </div>
  );
}
