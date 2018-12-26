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
    <div className="row-12 d-flex justify-content-start">
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
          className="form-control productoInput"
          name="codigoDeBarras"
          id="codigoDeBarras"
          value={codigoDeBarras}
          onChange={onCodigoDeBarrasChange(idx)}
        />
        &emsp;
      </div>
      <div className="col-5 form-group">
        <input
          readOnly
          type="text"
          value={nombre}
          className="form-control productoInput"
          name="nombre"
          id="producto"
          onChange={onProductoChange(idx)}
        />
        &emsp;
      </div>
      <div className="col-2 form-group">
        <input
          type="number"
          value={cantidad}
          className="form-control productoInput"
          name="cantidad"
          id="cantidad"
          onChange={onProductoChange(idx)}
        />
        &emsp;
      </div>
      <div className="form-group" style={{ maxWidth: "8,333rem" }}>
        <input
          type="number"
          value={precio}
          className="form-control productoInput"
          name="precio"
          id="precio"
          onChange={onProductoChange(idx)}
        />
        &emsp;
      </div>
    </div>
  );
}
