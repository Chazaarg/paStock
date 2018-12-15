import React from "react";
import TipoVarianteModal from "../layout/TipoVarianteModal";

const ProductoVariantes = props => {
  const {
    variantes,
    varianteTipos,
    toggle,
    varianteTipoOnChange,
    varianteTipoId,
    varianteOnChange,
    handleRemoveVariante,
    handleAddVariante,
    notify
  } = props;

  return (
    <div className="card">
      <div className="card-header" id="headingTwo">
        <h5 className="mb-0">
          <button
            type="button"
            className="btn btn-link collapsed"
            data-toggle="collapse"
            data-target="#collapseTwo"
            aria-expanded="false"
            aria-controls="collapseTwo"
            onClick={toggle.bind(this, true)}
          >
            Producto con variantes
          </button>
        </h5>
      </div>
      <div
        id="collapseTwo"
        className="collapse"
        aria-labelledby="headingTwo"
        data-parent="#accordion"
      >
        <div className="card-body">
          <div className="form-group col-md-4">
            <select
              name="varianteTipo"
              className="form-control varInputs"
              onChange={varianteTipoOnChange}
              value={varianteTipoId}
            >
              <option>Elige el tipo de variante:</option>
              {varianteTipos.map(varianteTipo => (
                <option key={varianteTipo.id} value={varianteTipo.id}>
                  {varianteTipo.nombre}
                </option>
              ))}
            </select>
            <TipoVarianteModal notify={notify} />
          </div>
          {variantes
            ? variantes.map((variante, idx) => (
                <div key={idx} className="variante">
                  <hr />
                  <h5 className="card-title p-2 p-2">Variante #{idx + 1}</h5>
                  <div className="form-group row">
                    <label htmlFor="nombre" className="col-sm-2 col-form-label">
                      Nombre
                    </label>
                    <div className="col-sm-10">
                      <input
                        type="text"
                        className="form-control varInputs"
                        name="nombre"
                        placeholder="Nombre"
                        value={variante.nombre}
                        onChange={varianteOnChange(idx)}
                      />
                    </div>
                  </div>
                  <div className="form-group row">
                    <label
                      htmlFor="cantidad"
                      className="col-sm-2 col-form-label"
                    >
                      Cantidad
                    </label>
                    <div className="col-sm-10">
                      <input
                        type="number"
                        className="form-control varInputs"
                        name="cantidad"
                        placeholder="Cantidad"
                        value={variante.cantidad}
                        onChange={varianteOnChange(idx)}
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
                        className="form-control varInputs"
                        name="precio"
                        placeholder="Precio"
                        value={variante.precio}
                        onChange={varianteOnChange(idx)}
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
                        className="form-control varInputs"
                        name="codigo_de_barras"
                        placeholder="Código de barras"
                        value={variante.codigo_de_barras}
                        onChange={varianteOnChange(idx)}
                      />
                    </div>
                  </div>
                  <div className="form-group row">
                    <button
                      type="button"
                      onClick={handleRemoveVariante(idx)}
                      className="btn btn-danger float-right m-3"
                    >
                      Eliminar variante
                    </button>
                  </div>
                </div>
              ))
            : null}
          <div className="row-12 d-flex justify-content-center">
            <button
              type="button"
              onClick={handleAddVariante}
              className="btn btn-primary"
            >
              Añadir variante
            </button>
          </div>
        </div>
      </div>
    </div>
  );
};

export default ProductoVariantes;
