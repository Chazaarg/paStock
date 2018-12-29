import React, { Component } from "react";
import { connect } from "react-redux";
import { createLoadingSelector } from "../../helpers/CreateLoadingSelector";
import { getVentas } from "../../actions/ventaActions";
import PropTypes from "prop-types";
import Loader from "react-loader";
import BootstrapTable from "react-bootstrap-table-next";
import ToolkitProvider, { Search } from "react-bootstrap-table2-toolkit";
import paginationFactory from "react-bootstrap-table2-paginator";

const expandRow = {
  renderer: row => (
    <div>
      <div className="row d-flex justify-content-end">
        <div className="col-2">Cantidad</div>
        <div className="col-2">Precio</div>
      </div>
      <hr />
      {row.ventaDetalle.map(detalle => (
        <div key={detalle.id} className="col-12">
          {detalle.variante ? (
            <React.Fragment>
              <div className="row-12">
                <h6>
                  {detalle.producto.marca
                    ? detalle.producto.nombre + " - " + detalle.producto.marca
                    : detalle.producto.nombre}
                </h6>
              </div>
              <div className="row-12 d-flex justify-content-end">
                <div className="col-2">
                  {detalle.variante.varianteTipo + ":"}
                </div>
                <div className="col-2">{detalle.variante.nombre}</div>
                <div className="col-2 text-center">{detalle.cantidad}</div>
                <div className="col-2 text-center">${detalle.precio}</div>
              </div>
            </React.Fragment>
          ) : (
            <React.Fragment>
              <div className="col-4">
                <h6>
                  {detalle.producto.marca
                    ? detalle.producto.nombre + " - " + detalle.producto.marca
                    : detalle.producto.nombre}
                </h6>
              </div>
              <div className="col-2 float-right">{detalle.cantidad}</div>
              <div className="col-2 float-right">${detalle.precio}</div>
            </React.Fragment>
          )}
        </div>
      ))}
    </div>
  ),
  showExpandColumn: true,
  expandByColumnOnly: true,
  expandHeaderColumnRenderer: ({ isAnyExpands }) => {
    return null;
  },
  expandColumnRenderer: ({ expanded }) => {
    if (expanded) {
      return (
        <i
          className="fas fa-minus showDetalles"
          style={{ cursor: "pointer" }}
        />
      );
    }
    return (
      <i className="fas fa-plus showDetalles" style={{ cursor: "pointer" }} />
    );
  }
};

const columns = [
  {
    dataField: "ventaDetalle.length",
    text: "Productos",
    searchable: false
  },
  {
    dataField: "id",
    text: "Venta",
    sort: true
  },
  {
    dataField: "createdAt.date",
    text: "Fecha",
    searchable: false,
    sort: true,
    formatter: cell => {
      const date = new Date(cell);
      let month = date.getMonth();
      switch (month) {
        case 0:
          month = "Enero";
          break;
        case 1:
          month = "Feb";
          break;
        case 2:
          month = "Marzo";
          break;
        case 3:
          month = "Abril";
          break;
        case 4:
          month = "Mayo";
          break;
        case 5:
          month = "Jun";
          break;
        case 6:
          month = "Jul";
          break;
        case 7:
          month = "Ago";
          break;
        case 8:
          month = "Sep";
          break;
        case 9:
          month = "Oct";
          break;
        case 10:
          month = "Nov";
          break;
        case 11:
          month = "Dic";
          break;

        default:
          break;
      }

      return month + " " + date.getDate();
    }
  },

  {
    dataField: "total",
    text: "Total",
    sort: true,
    formatter: cell => {
      return "$" + cell;
    }
  },
  {
    dataField: "cliente",
    text: "Cliente",
    sort: true
  }
];

const customTotal = (from, to, size) => (
  <span className="react-bootstrap-table-pagination-total small text-muted">
    {" "}
    Mostrando de {from} a {to}. Resultados en total: {size}.
  </span>
);

class Ventas extends Component {
  componentDidMount() {
    this.props.getVentas();
  }

  render() {
    const { isFetching, ventas } = this.props;

    const options = {
      showTotal: true,
      paginationTotalRenderer: customTotal,
      sizePerPageList: [10, 20, 30, { text: "Todos", value: ventas.length }]
    };
    const { SearchBar } = Search;

    return (
      <div>
        <h1>Ventas</h1>
        <Loader loaded={isFetching}>
          <ToolkitProvider
            keyField="id"
            data={ventas}
            columns={columns}
            bootstrap4={true}
            search={{ searchFormatted: true }}
          >
            {props => (
              <React.Fragment>
                <hr />
                <SearchBar
                  {...props.searchProps}
                  placeholder="Buscar ventas por: número, cliente o total"
                />
                <hr />
                <BootstrapTable
                  expandRow={expandRow}
                  pagination={paginationFactory(options)}
                  {...props.baseProps}
                />
              </React.Fragment>
            )}
          </ToolkitProvider>
        </Loader>
      </div>
    );
  }
}

const loadingSelector = createLoadingSelector(["FETCH_VENTAS"]);

Ventas.propTypes = {
  ventas: PropTypes.array.isRequired,
  getVentas: PropTypes.func.isRequired,
  isFetching: PropTypes.bool.isRequired
};

const mapStateToProps = state => ({
  ventas: state.venta.ventas,
  isFetching: loadingSelector(state),
  loading: state.loading
});

export default connect(
  mapStateToProps,
  { getVentas }
)(Ventas);
