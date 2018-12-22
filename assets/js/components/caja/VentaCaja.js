import React, { Component } from "react";

class VentaCaja extends Component {
  render() {
    const {
      total,
      descuento,
      onChange,
      ventaTipo,
      aplicarDescuento
    } = this.props;
    return (
      <div
        style={{
          position: "fixed",
          bottom: "0",
          backgroundColor: "#fff",
          width: "80%",
          paddingBottom: "2%"
        }}
      >
        <div
          className="row d-flex justify-content-center pt-3"
          style={{
            borderTop: "1px solid black"
          }}
        >
          <div className="col-4 form-group">
            <select
              name="ventaTipo"
              onChange={onChange}
              value={ventaTipo}
              className="form-control col-8"
            >
              <option>Tipo de pago</option>
              <option value="Efectivo">Efectivo</option>
              <option value="Tarjeta">Tarjeta</option>
            </select>
          </div>
          <div className="col-4 form-group">
            <label htmlFor="total">Total</label>
            <input
              className="form-control"
              type="number"
              name="total"
              value={total}
              readOnly
            />
          </div>
          <div className="col-4">
            <div className="row d-flex justify-content-between">
              <label htmlFor="descuento">Descuento</label>
              <button className="btn btn-link p-0" onClick={aplicarDescuento}>
                Aplicar
              </button>
            </div>
            <div className="row">
              <input
                className="form-control"
                type="number"
                name="descuento"
                id="descuento"
              />
            </div>
          </div>
        </div>
        <div className="row d-flex justify-content-end">
          <div className="col-4">
            <button
              type="submit"
              className="btn btn-success pt-2 pb-2"
              style={{ width: "100%" }}
            >
              VENDER
            </button>
          </div>
        </div>
      </div>
    );
  }
}

export default VentaCaja;
