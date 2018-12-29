import React from "react";
import Cliente from "./Cliente";
import Vendedor from "./Vendedor";
import Select from "react-select";

export default function ClienteVendedor(props) {
  const {
    onClienteChange,
    onVendedorChange,
    cliente,
    vendedor,
    vendedores,
    clientes,
    newProp
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

  //Quito la opción de cliente genérico ya que no es necesaria.
  optionsCliente = optionsCliente.filter(
    optionCliente => optionCliente.value !== 1
  );

  return (
    <section className="accordion col-12" id="ClienteVendedor">
      <div className="row">
        <div className="col-5">
          <label id="vendedorInput">Vendedor</label>
        </div>
        <div className="col-5">
          <label id="clienteInput">Cliente</label>
          &nbsp;
          <i
            className="far fa-question-circle"
            title="De no escoger ningún cliente, se seleccionará uno genérico. "
            style={{ fontSize: "0.6rem", cursor: "help" }}
          />
        </div>
      </div>
      <div className="d-flex bd-highlight">
        <div className="col-5 bd-highligh pl-0">
          {/* Vendedor */}
          <Select
            isClearable
            name="vendedor"
            id="vendedor"
            value={
              vendedor.id === undefined
                ? undefined
                : {
                    label: vendedor.nombre,
                    value: vendedor.id,
                    nombre: "vendedor"
                  }
            }
            onChange={onVendedorChange}
            options={optionsVendedor}
            placeholder="Seleccione un vendedor..."
            className="ventaInput"
          />
          &emsp;
        </div>

        {/* Cliente */}

        <div className="col-5 bd-highlight pl-2">
          <Select
            isClearable
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
            onChange={onClienteChange}
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

      <div className="col-12">
        <div
          id="collapseOne"
          className="collapse"
          aria-labelledby="headingOne"
          data-parent="#ClienteVendedor"
        >
          <div className="d-flex justify-content-start bd-highlight">
            <Vendedor newProp={newProp} vendedor={vendedor} />
            <Cliente newProp={newProp} cliente={cliente} />
          </div>
        </div>
      </div>
    </section>
  );
}
