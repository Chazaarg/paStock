import React, { Component } from "react";

class VentaCaja extends Component {
  render() {
    const { onChange, ventaTipo, descuento, onSubmit, productos } = this.props;

    //Total
    let total = 0;

    //Por cada producto, se multiplica la cantidad y el precio y se le suma al total.
    productos.forEach(producto => {
      total += producto.cantidad * producto.precio;
    });

    //Si se paga en efectivo, se resta un 15 por ciento y se redondea.
    if (ventaTipo == 2) {
      total = total - Math.round(total * 0.15);
    }
    //Se le resta el descuento al total.
    total -= descuento;

    return (
      <div
        style={{
          position: "fixed",
          bottom: "0",
          backgroundColor: "#fff",
          width: "80%",
          height: "17vh",
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
              <option value={2}>Efectivo</option>
              <option value={1}>Tarjeta</option>
            </select>
          </div>
          <div className="col-4 form-group">
            <label htmlFor="total">Total</label>
            <input
              className="form-control"
              type="number"
              name="total"
              id="total"
              value={total}
              readOnly
            />
          </div>
          <div className="col-4">
            <div className="row d-flex justify-content-between">
              <label htmlFor="descuento">Descuento</label>
            </div>
            <div className="row">
              <input
                className="form-control"
                type="number"
                name="descuento"
                onChange={onChange}
                value={descuento}
              />
            </div>
          </div>
        </div>
        <div className="row d-flex justify-content-end">
          <div className="col-4">
            <button
              type="submit"
              onClick={onSubmit}
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
