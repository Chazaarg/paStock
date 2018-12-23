import React from "react";

export default function ProductoCaja(props) {
  const { nombre, precio, codigoDeBarras, cantidad } = props.producto;

  const {
    onProductoChange,
    idx,
    onCodigoDeBarrasChange,
    handleRemoveProducto
  } = props;

  return (
    <div className="row-12 pb-4 d-flex justify-content-start">
      <span
        className="text-danger"
        style={{ fontSize: "1.6rem", cursor: "pointer" }}
        onClick={handleRemoveProducto(idx)}
      >
        {" "}
        &times;{" "}
      </span>

      <div className="col-3 form-group">
        <input
          type="text"
          className="form-control"
          name="codigoDeBarras"
          value={codigoDeBarras}
          onChange={onCodigoDeBarrasChange(idx)}
        />
      </div>
      <div className="col-5 form-group">
        <input
          readOnly
          type="text"
          value={nombre}
          className="form-control"
          name="nombre"
          onChange={onProductoChange(idx)}
        />
      </div>
      <div className="col-2 form-group">
        <input
          type="number"
          value={cantidad}
          className="form-control"
          name="cantidad"
          onChange={onProductoChange(idx)}
        />
      </div>
      <div className="form-group" style={{ maxWidth: "8,333rem" }}>
        <input
          type="number"
          value={precio}
          className="form-control"
          name="precio"
          onChange={onProductoChange(idx)}
        />
      </div>
    </div>
  );
}
