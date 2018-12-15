import React from "react";

export default function ProductoCaja() {
  return (
    <div className="row-12 pb-4 d-flex justify-content-start">
      <div className="col-3 form-group">
        <input type="text" className="form-control" name="codigoDeBarras" />
      </div>
      <div className="col-5 form-group">
        <input type="text" className="form-control" name="nombre" />
      </div>
      <div className="col-2 form-group">
        <input type="text" className="form-control" name="cantidad" />
      </div>
      <div className="col-2 form-group">
        <input type="text" className="form-control" name="precio" />
      </div>
    </div>
  );
}
