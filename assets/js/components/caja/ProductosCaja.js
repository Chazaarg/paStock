import React, { Component } from "react";
import ProductoCaja from "./ProductoCaja";

class ProductosCaja extends Component {
  render() {
    return (
      <div className="row-12">
        <div className="row-12 pb-3 d-flex justify-content-start">
          <div className="col-3">
            <h4 style={{ fontSize: "1.4rem" }}>Código de Barras</h4>
          </div>
          <div className="col-5">
            <h4 style={{ fontSize: "1.4rem" }}>Producto</h4>
          </div>
          <div className="col-2">
            <h4 style={{ fontSize: "1.4rem" }}>Cantidad</h4>
          </div>
          <div className="col-2">
            <h4 style={{ fontSize: "1.4rem" }}>Precio</h4>
          </div>
        </div>
        <ProductoCaja />
        <ProductoCaja />
        <ProductoCaja />
        <ProductoCaja />
        <ProductoCaja />
      </div>
    );
  }
}

export default ProductosCaja;
