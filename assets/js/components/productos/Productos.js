import React, { Component } from "react";
import { Link } from "react-router-dom";
import { connect } from "react-redux";
import PropTypes from "prop-types";
import {
  getProductos,
  getMarcas,
  getCategorias,
  getSubcategorias
} from "../../actions/productosActions";
import { createLoadingSelector } from "../../helpers/CreateLoadingSelector";
import Loader from "react-loader";
import BootstrapTable from "react-bootstrap-table-next";
import ToolkitProvider, { Search } from "react-bootstrap-table2-toolkit";
import paginationFactory from "react-bootstrap-table2-paginator";
import SortProductos from "./SortProductos";

const categoriaFormatter = (cell, row) => {
  if (row.sub_categoria) {
    return `${cell} > ${row.sub_categoria.nombre}`;
  }

  return cell;
};
const varianteFormatter = (cell, row) => {
  if (!row.variantes) {
    return null;
  }
  const varianteColumns = [
    {
      dataField: "nombre",
      text: "Nombre"
    }
  ];
  return (
    <BootstrapTable
      keyField="id"
      data={row.variantes}
      columns={varianteColumns}
      bootstrap4={true}
      headerClasses="d-none"
    />
  );
};
const productoCantidadFormatter = (cell, row) => {
  if (!row.variantes) {
    return row.cantidad;
  }

  const varianteColumns = [
    {
      dataField: "cantidad",
      text: "Cantidad"
    }
  ];
  return (
    <BootstrapTable
      keyField="id"
      data={row.variantes}
      columns={varianteColumns}
      bootstrap4={true}
      headerClasses="d-none"
    />
  );
};
const productoPrecioFormatter = (cell, row) => {
  if (!row.variantes) {
    return "$" + parseFloat(row.precio).toFixed(2);
  }

  const variantePrecioFormatter = (cell, row) => {
    return "$" + parseFloat(row.precio).toFixed(2);
  };

  const varianteColumns = [
    {
      dataField: "precio",
      text: "Precio",
      formatter: variantePrecioFormatter
    }
  ];
  return (
    <BootstrapTable
      keyField="id"
      data={row.variantes}
      columns={varianteColumns}
      bootstrap4={true}
      headerClasses="d-none"
    />
  );
};
const { SearchBar } = Search;
const columns = [
  {
    dataField: "nombre",
    text: "Nombre",
    sort: true
  },
  {
    dataField: "marca.nombre",
    text: "Marca",
    sort: true
  },

  {
    dataField: "productoCantidad",
    text: "Cantidad",
    isDummyField: true,
    searchable: false,
    formatter: productoCantidadFormatter
  },
  {
    dataField: "productoPrecio",
    text: "Precio",
    isDummyField: true,
    searchable: false,
    formatter: productoPrecioFormatter
  },
  {
    dataField: "variantes",
    text: "Variante",
    searchable: false,
    formatter: varianteFormatter
  },
  {
    dataField: "categoria.nombre",
    text: "Categoria",
    formatter: categoriaFormatter,
    sort: true
  },
  {
    dataField: "detalles",
    text: "",
    isDummyField: true,
    searchable: false,
    formatter: (cell, row) => {
      return (
        <Link
          to={`/producto/${row.id}/show`}
          className="btn btn-secondary ml-auto"
        >
          Detalles
        </Link>
      );
    }
  },
  {
    dataField: "editar",
    text: "",
    isDummyField: true,
    searchable: false,
    formatter: (cell, row) => {
      return (
        <Link
          to={`/producto/${row.id}/edit`}
          className="btn btn-secondary ml-auto"
        >
          Editar
        </Link>
      );
    }
  }
];

const customTotal = (from, to, size) => (
  <span className="react-bootstrap-table-pagination-total small text-muted">
    {" "}
    Mostrando de {from} a {to}. Resultados en total: {size}.
  </span>
);

class Productos extends Component {
  state = {
    sort: {
      sortProducto: 0,
      sortMarca: "",
      sortCategoria: ""
    }
  };
  componentDidMount() {
    this.props.getProductos();
    this.props.getCategorias();
    this.props.getSubcategorias();
    this.props.getMarcas();
  }

  sortOnChange = e => {
    this.setState(
      {
        sort: {
          ...this.state.sort,
          [e.target.name]: e.target.value
        }
      },
      () => {
        this.props.getProductos(this.state.sort);
      }
    );
  };

  static getDerivedStateFromProps(props, state) {
    const { loading } = props;
    //Cuando se sale, le asigno false a FETCH_PRODUCTOS, para que vuelva a cargar la página al volver.
    if (loading.FETCH_PRODUCTOS) {
      return (loading["FETCH_PRODUCTOS"] = false);
    }
    return state;
  }

  render() {
    const { productos, isFetching } = this.props;

    const options = {
      showTotal: true,
      paginationTotalRenderer: customTotal,
      sizePerPageList: [10, 20, 30, { text: "Todos", value: productos.length }]
    };

    return (
      <Loader loaded={isFetching}>
        <SortProductos
          sortOnChange={this.sortOnChange.bind(this)}
          marcas={this.props.marcas}
          categorias={this.props.categorias}
          subcategorias={this.props.subcategorias}
        />
        <ToolkitProvider
          keyField="id"
          data={productos}
          columns={columns}
          bootstrap4={true}
          search={{ searchFormatted: true }}
        >
          {props => (
            <React.Fragment>
              <hr />
              <SearchBar
                {...props.searchProps}
                placeholder="Buscar productos por: nombre, marca o categoria"
              />
              <hr />
              <BootstrapTable
                pagination={paginationFactory(options)}
                {...props.baseProps}
              />
            </React.Fragment>
          )}
        </ToolkitProvider>
      </Loader>
    );
  }
}

const loadingSelector = createLoadingSelector(["FETCH_MARCAS"]);

Productos.propTypes = {
  productos: PropTypes.array.isRequired,
  getProductos: PropTypes.func.isRequired,
  getCategorias: PropTypes.func.isRequired,
  getSubcategorias: PropTypes.func.isRequired,
  getMarcas: PropTypes.func.isRequired,
  isFetching: PropTypes.bool.isRequired
};

const mapStateToProps = state => ({
  productos: state.producto.productos,
  categorias: state.producto.categorias,
  subcategorias: state.producto.subcategorias,
  marcas: state.producto.marcas,
  isFetching: loadingSelector(state),
  loading: state.loading
});

export default connect(
  mapStateToProps,
  { getProductos, getMarcas, getCategorias, getSubcategorias }
)(Productos);
