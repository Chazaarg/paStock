import React from "react";

export default function SortVentas(props) {
  const {
    sort,
    sortOnChange,
    applyCustom,
    desde,
    hasta,
    customOnChange
  } = props;
  return (
    <div className="row-12 d-flex">
      <div className="input-group col-6">
        <div className="input-group-prepend">
          <label className="input-group-text" htmlFor="sortVenta">
            Filtrar ventas por fechas
          </label>
        </div>
        <select
          name="sortVenta"
          id="sortVenta"
          className="custom-select"
          style={{ WebkitAppearance: "none" }}
          onChange={sortOnChange}
        >
          <option value="">...</option>
          <option value={0}>Todas las ventas</option>
          <option value={1}>Último día</option>
          <option value={2}>Última semana</option>
          <option value={3}>Último mes</option>
          <option value={4}>Personalizar</option>
        </select>
      </div>
      {sort === 4 ? (
        <React.Fragment>
          <div className="input-group col-2">
            <div className="input-group-prepend">
              <label className="input-group-text" htmlFor="desde">
                Desde:
              </label>
            </div>
            <input
              type="text"
              name="desde"
              id="desde"
              value={desde}
              onChange={customOnChange}
              placeholder="dd/mm/yyyy"
            />
          </div>
          <div className="input-group col-2">
            <div className="input-group-prepend">
              <label className="input-group-text" htmlFor="hasta">
                Hasta:
              </label>
            </div>
            <input
              type="text"
              name="hasta"
              id="hasta"
              value={hasta}
              onChange={customOnChange}
              placeholder="dd/mm/yyyy"
            />
          </div>
          <div className="input-group col-2">
            <button className="btn btn-info" onClick={applyCustom}>
              Aplicar
            </button>
          </div>
        </React.Fragment>
      ) : null}
    </div>
  );
}
