import React from "react";

export default function SortProductos(props) {
  const { sortOnChange, marcas, categorias, subcategorias } = props;
  return (
    <div className="row-12 d-flex justify-content-start">
      <div className="input-group col-4">
        <div className="input-group-prepend">
          <label className="input-group-text" htmlFor="sortProducto">
            Ordenar productos por:
          </label>
        </div>
        <select
          name="sortProducto"
          id="sortProducto"
          className="custom-select"
          style={{ WebkitAppearance: "none" }}
          onChange={sortOnChange}
        >
          <option value="0">...</option>
          <option value="1">Más nuevo al más viejo</option>
          <option value="2">Más viejo al más nuevo</option>
          <option value="3">Mayor precio a menor precio</option>
          <option value="4">Menor precio a mayor precio</option>
          <option value="5">Mayor cantidad a menor cantidad</option>
          <option value="6">Menor cantidad a mayor cantidad</option>
        </select>
      </div>
      <div className="input-group col-4">
        <div className="input-group-prepend">
          <label className="input-group-text" htmlFor="sortMarca">
            Filtrar por marca:
          </label>
        </div>
        <select
          name="sortMarca"
          id="sortMarca"
          className="custom-select"
          style={{ WebkitAppearance: "none" }}
          onChange={sortOnChange}
        >
          <option value="">...</option>
          {marcas.map(marca => {
            return (
              <option key={marca.id} value={marca.id}>
                {marca.nombre}
              </option>
            );
          })}
        </select>
      </div>
      <div className="input-group col-4">
        <div className="input-group-prepend">
          <label className="input-group-text" htmlFor="sortCategoria">
            Filtrar por categoria:
          </label>
        </div>
        <select
          name="sortCategoria"
          id="sortCategoria"
          className="custom-select"
          style={{ WebkitAppearance: "none" }}
          onChange={sortOnChange}
        >
          <option value="">...</option>
          {categorias.map(categoria => {
            return (
              <React.Fragment key={categoria.id}>
                <option value={categoria.id} className="font-weight-bold">
                  {categoria.nombre}
                </option>
                {subcategorias.map(subcategoria => {
                  if (subcategoria.categoria === categoria.id) {
                    return (
                      <option
                        key={"sub" + subcategoria.id}
                        value={"sub" + subcategoria.id}
                      >
                        {subcategoria.nombre}
                      </option>
                    );
                  }
                })}
              </React.Fragment>
            );
          })}
        </select>
      </div>
    </div>
  );
}
