import React from "react";

const ProductoIndividual = props => {
  const { precio, cantidad, codigo_de_barras, toggle, onChange } = props;

  return (
    <div className="card">
      <div className="card-header" id="headingOne">
        <h5 className="mb-0">
          <button
            type="button"
            className="btn btn-link"
            data-toggle="collapse"
            data-target="#collapseOne"
            aria-expanded="true"
            aria-controls="collapseOne"
            onClick={toggle.bind(this, false)}
          >
            Producto individual
          </button>
        </h5>
      </div>

      <div
        id="collapseOne"
        className="collapse"
        aria-labelledby="headingOne"
        data-parent="#accordion"
      >
        <div className="card-body">
          <div className="form-group row">
            <label htmlFor="cantidad" className="col-sm-2 col-form-label">
              Cantidad
            </label>
            <div className="col-sm-10">
              <input
                type="number"
                className="form-control indInputs"
                name="cantidad"
                placeholder="Cantidad"
                value={cantidad}
                onChange={onChange}
              />
            </div>
          </div>
          <div className="form-group row">
            <label htmlFor="precio" className="col-sm-2 col-form-label">
              Precio
            </label>
            <div className="col-sm-10">
              <input
                type="number"
                className="form-control indInputs"
                name="precio"
                placeholder="Precio"
                value={precio}
                onChange={onChange}
              />
            </div>
          </div>
          <div className="form-group row">
            <label
              htmlFor="codigo_de_barras"
              className="col-sm-2 col-form-label"
            >
              Código de barras
            </label>
            <div className="col-sm-10">
              <input
                type="text"
                className="form-control indInputs"
                name="codigo_de_barras"
                placeholder="Código de barras"
                value={codigo_de_barras ? codigo_de_barras : ""}
                onChange={onChange}
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default ProductoIndividual;
