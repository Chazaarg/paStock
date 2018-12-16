import React, { Component } from "react";
import ClienteVendedor from "./ClienteVendedor";
import ProductosCaja from "./ProductosCaja";
import VentaCaja from "./VentaCaja";

class Caja extends Component {
  render() {
    document.title = "Caja";

    return (
      <React.Fragment>
        <ClienteVendedor />

        <ProductosCaja />

        <VentaCaja />
      </React.Fragment>
    );
  }
}

export default Caja;
