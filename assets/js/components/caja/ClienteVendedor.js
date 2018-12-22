import React, { Component } from "react";
import Cliente from "./Cliente";
import Vendedor from "./Vendedor";

class ClienteVendedor extends Component {
  render() {
    return (
      <section className="accordion col-12" id="ClienteVendedor">
        <div className="d-flex bd-highlight mb-3">
          <div className="col-5 p-2 bd-highlight">
            {/* Vendedor */}

            <input
              type="text"
              readOnly
              className="form-control-plaintext"
              id="staticEmail"
              value="Vendedor"
            />
          </div>

          {/* Cliente */}

          <div className="col-5 p-2 bd-highlight">
            <input
              type="text"
              readOnly
              className="form-control-plaintext"
              id="staticEmail"
              value="Cliente"
            />
          </div>

          {/* collapseBTN */}

          <div className="col-2 ml-auto p-2 bd-highlight" id="headingOne">
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
              <Cliente />
              <Vendedor />
            </div>
          </div>
        </div>
      </section>
    );
  }
}

export default ClienteVendedor;
