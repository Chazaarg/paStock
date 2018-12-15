import React, { Component } from "react";

class VentaCaja extends Component {
  render() {
    return (
      <React.Fragment>
        <div className="row-12 d-flex justify-content-center">
          <div className="col-4">Tipo de venta</div>
          <div className="col-4 form-group">
            <label htmlFor="total">Total</label>
            <input className="form-control" type="text" name="total" />
          </div>
          <div className="col-4">
            <div className="row">
              <label htmlFor="descuento">Descuento</label>
              <input className="form-control" type="text" name="descuento" />
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
      </React.Fragment>
    );
  }
}

export default VentaCaja;
