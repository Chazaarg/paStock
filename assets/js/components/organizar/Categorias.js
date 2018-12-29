import React from "react";
import BootstrapTable from "react-bootstrap-table-next";
import ToolkitProvider from "react-bootstrap-table2-toolkit";
import cellEditFactory from "react-bootstrap-table2-editor";

import Subcategorias from "./Subcategorias";

const Categorias = props => {
  const {
    categorias,
    categoria,
    subcategorias,
    subcategoriasClick,
    closeNav,
    openNav,
    deleteSubcategoria,
    updateSubcategoria,
    deleteCategoria,
    updateCategoria,
    notifyUser,
    newProp,
    notify
  } = props;

  const nombreFormatter = (cell, row) => {
    return (
      <div className="row">
        <div
          style={{ fontSize: "1.3rem", cursor: "pointer" }}
          className="col-1 text-danger"
          onClick={() =>
            deleteCategoria(row.id).then(
              notifyUser(`Categoria ${cell} eliminada.`, "warning", null)
            )
          }
        >
          &times;
        </div>
        <div className="col-8 m-auto " style={{ wordWrap: "break-word" }}>
          {cell}
        </div>
        <div className="float-right col-3">
          <span
            style={{
              width: "6rem",
              height: "2rem",
              fontSize: "0.6rem",
              textAlign: "center",
              fontWeight: "bold"
            }}
            className="btn btn-warning m-auto"
            onClick={e => {
              openNav(e);
              subcategoriasClick(row);
            }}
          >
            SUBCATEGORIAS
          </span>
        </div>
      </div>
    );
  };

  const editCell = (newValue, row, column, done) => {
    if (newValue === "") {
      return {
        valid: false,
        message: "Este campo es requerido."
      };
    }
    let categoriaExistente;
    categorias.forEach(categoria => {
      if (categoria.nombre.toLowerCase() === newValue.toLowerCase()) {
        categoriaExistente = {
          valid: false,
          message: "Esta categoría ya existe."
        };
      }
    });
    if (categoriaExistente) return categoriaExistente;

    if (updateCategoria({ nombre: newValue, id: row.id })) {
      return true;
    }

    return {
      valid: false,
      message: "Lo sentimos, ha habido un error."
    };
  };
  const columns = [
    {
      dataField: "nombre",
      text: "Nombre",
      sort: true,
      formatter: nombreFormatter,
      headerAlign: (column, colIndex) => "center",
      validator: editCell
    }
  ];

  return (
    <React.Fragment>
      <div className="col-6 float-left pr-0">
        <ToolkitProvider
          keyField="id"
          data={categorias}
          columns={columns}
          bootstrap4={true}
        >
          {props => (
            <BootstrapTable
              {...props.baseProps}
              cellEdit={cellEditFactory({
                mode: "dbclick"
              })}
            />
          )}
        </ToolkitProvider>
      </div>
      <div className="col-6 float-right pl-0" id="sideNavContainer">
        <div className="col p-0" style={{ height: "100%", display: "none" }}>
          {/* Subcategorias */}
          <div className="p-0 col-2 float-left" style={{ height: "100%" }} />
          <Subcategorias
            closeNav={closeNav}
            subcategorias={subcategorias}
            categorias={categorias}
            categoria={categoria}
            deleteSubcategoria={deleteSubcategoria}
            notifyUser={notifyUser}
            newProp={newProp}
            notify={notify}
            updateSubcategoria={updateSubcategoria}
          />
        </div>
      </div>
    </React.Fragment>
  );
};

export default Categorias;
