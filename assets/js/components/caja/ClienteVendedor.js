import React from "react";
import Cliente from "./Cliente";
import Vendedor from "./Vendedor";
import Select from "react-select";

export default function ClienteVendedor(props) {
  const {
    onClienteVendedorChange,
    cliente,
    vendedor,
    vendedores,
    clientes
  } = props;
  let [optionsVendedor] = [
    vendedores.map(vendedor => ({
      nombre: "vendedor",
      value: vendedor.id,
      label: vendedor.nombre
    }))
  ];
  let [optionsCliente] = [
    clientes.map(cliente => ({
      nombre: "cliente",
      value: cliente.id,
      label: cliente.nombre
    }))
  ];
  return (
    <section className="accordion col-12" id="ClienteVendedor">
      <div className="row">
        <div className="col-5">
          <label id="vendedorInput">Vendedor</label>
        </div>
        <div className="col-5">
          <label id="clienteInput">Cliente</label>
        </div>
      </div>
      <div className="d-flex bd-highlight mb-3">
        <div className="col-5 bd-highligh pl-0">
          {/* Vendedor */}
          <Select
            name="vendedor"
            id="vendedor"
            value={
              vendedor.id === undefined
                ? null
                : {
                    label: vendedor.nombre,
                    value: vendedor.id,
                    nombre: "vendedor"
                  }
            }
            onChange={onClienteVendedorChange}
            options={optionsVendedor}
            placeholder="Seleccione un vendedor..."
            className="ventaInput"
          />
          &emsp;
        </div>

        {/* Cliente */}

        <div className="col-5 bd-highlight pl-2">
          <Select
            name="cliente"
            id="cliente"
            value={
              cliente.id === undefined
                ? null
                : {
                    label: cliente.nombre,
                    value: cliente.id,
                    nombre: "cliente"
                  }
            }
            onChange={onClienteVendedorChange}
            options={optionsCliente}
            placeholder="Seleccione un cliente..."
            className="ventaInput"
          />
          &emsp;
        </div>

        {/* collapseBTN */}

        <div className="col-2 ml-auto bd-highlight" id="headingOne">
          <button
            className="btn btn-link"
            type="button"
            data-toggle="collapse"
            data-target="#collapseOne"
            aria-expanded="true"
            aria-controls="collapseOne"
          >
            <i
              className="fas fa-users-cog text-dark"
              style={{ fontSize: "1.5rem" }}
            />
          </button>
        </div>
      </div>

      {/* Config Collapse */}

      <div className="col-12 d-inline ">
        <div
          id="collapseOne"
          className="collapse"
          aria-labelledby="headingOne"
          data-parent="#ClienteVendedor"
        >
          <div className="d-flex justify-content-start bd-highlight">
            <Vendedor />
            <Cliente />
          </div>
        </div>
      </div>
    </section>
  );
}
