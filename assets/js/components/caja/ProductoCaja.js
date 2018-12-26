import React from "react";
import Select from "react-select";

export default function ProductoCaja(props) {
  const { nombre, precio, codigoDeBarras, cantidad, id } = props.producto;

  const {
    onProductoChange,
    onProductoSelectChange,
    idx,
    onCodigoDeBarrasChange,
    handleRemoveProducto,
    dbProductos
  } = props;

  let optionsProductos = [];
  dbProductos.map(producto => {
    if (!producto.variantes) {
      optionsProductos = [
        ...optionsProductos,
        {
          nombre: "individual",
          value: producto.id,
          label: producto.marca
            ? producto.nombre + " - " + producto.marca.nombre
            : producto.nombre
        }
      ];
    } else {
      producto.variantes.forEach(variante => {
        optionsProductos = [
          ...optionsProductos,
          {
            nombre: "variante",
            value: "var" + variante.id,
            label: producto.marca
              ? producto.nombre +
                " : " +
                variante.nombre +
                " - " +
                producto.marca.nombre
              : producto.nombre + " : " + variante.nombre
          }
        ];
      });
    }
  });

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
        <Select
          name="producto"
          id="producto"
          value={
            !id
              ? null
              : !props.producto.variante
              ? {
                  label: nombre,
                  value: id,
                  nombre: "producto"
                }
              : { label: nombre, value: "var" + id, nombre: "producto" }
          }
          onChange={onProductoSelectChange(idx)}
          options={optionsProductos}
          placeholder="Seleccione un producto..."
          className="productoInput d-none producto"
        />
        <input
          readOnly
          type="text"
          value={nombre}
          className="form-control productoInput"
          name="nombre"
          id="producto"
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
