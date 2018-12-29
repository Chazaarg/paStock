import React from "react";
import BootstrapTable from "react-bootstrap-table-next";
import ToolkitProvider from "react-bootstrap-table2-toolkit";
import cellEditFactory from "react-bootstrap-table2-editor";

const Marcas = props => {
  const { marcas, notifyUser, updateMarca, deleteMarca } = props;

  const nombreFormatter = (cell, row) => {
    return (
      <div className="row">
        <div
          style={{ fontSize: "1.3rem", cursor: "pointer" }}
          className="col-1 text-danger"
          onClick={() => {
            deleteMarca(row.id).then(() => {
              notifyUser(
                `Marca ${cell.toUpperCase()} eliminada.`,
                "warning",
                null
              );
            });
          }}
        >
          &times;
        </div>
        <div className="col-8 m-auto " style={{ wordWrap: "break-word" }}>
          {cell}
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
    let marcaExistente;
    marcas.forEach(marca => {
      if (marca.nombre.toLowerCase() === newValue.toLowerCase()) {
        marcaExistente = {
          valid: false,
          message: "Esta marca ya existe."
        };
      }
    });
    if (marcaExistente) return marcaExistente;

    if (updateMarca({ nombre: newValue, id: row.id })) {
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
    <div className="col-6 float-left pr-0">
      <ToolkitProvider
        keyField="id"
        data={marcas}
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
  );
};

export default Marcas;
