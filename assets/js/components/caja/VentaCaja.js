import React, { Component } from "react";
import CajaAlert from "../alert/CajaAlert";

class VentaCaja extends Component {
  render() {
    const {
      onChange,
      ventaTipo,
      descuento,
      onSubmit,
      productos,
      notify
    } = this.props;

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
          backgroundColor: "#fff",
          height: "21vh"
        }}
        className="d-flex align-items-end"
      >
        <div className="col-12">
          <div
            className="row d-flex justify-content-center pt-3"
            style={{
              borderTop: "1px solid black"
            }}
          >
            <div className="col-4 form-group">
              <label htmlFor="formaDePago">Tipo de Pago</label>

              <select
                name="ventaTipo"
                id="formaDePago"
                onChange={onChange}
                value={ventaTipo}
                className="form-control col-8 ventaInput"
              >
                <option>Tipo de pago</option>
                <option value={2}>Efectivo</option>
                <option value={1}>Tarjeta</option>
              </select>
            </div>
            <div className="col-4 form-group">
              <label htmlFor="total">Total</label>
              <input
                className="form-control ventaInput"
                type="number"
                name="total"
                id="total"
                value={total}
                readOnly
              />
              &emsp;
            </div>
            <div className="col-4">
              <div className="row d-flex justify-content-between">
                <label htmlFor="descuento">Descuento</label>
              </div>
              <div className="row">
                <input
                  className="form-control ventaInput"
                  type="number"
                  name="descuento"
                  id="descuento"
                  onChange={onChange}
                  value={descuento}
                />
              </div>
            </div>
          </div>
          <div className="row d-flex justify-content-end mb-1">
            {notify.message ? (
              <CajaAlert
                message={notify.message}
                messageType={notify.messageType}
                errors={notify.errors}
              />
            ) : null}
            <div className="col-4">
              <button
                type="submit"
                onClick={onSubmit}
                className="btn btn-block btn-success pt-2 pb-2"
              >
                VENDER
              </button>
            </div>
          </div>
        </div>
      </div>
    );
  }
}

export default VentaCaja;
