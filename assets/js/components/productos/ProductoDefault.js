import React from "react";
import MarcaModal from "../layout/MarcaModal";
import CategoriaModal from "../layout/CategoriaModal";
import SubCategoriaModal from "../layout/SubCategoriaModal";
import Select from "react-select";

const ProductoDefault = props => {
  const {
    nombre,
    marca,
    categoria,
    sub_categoria,
    descripcion,
    categorias,
    marcas,
    subcategorias,
    onChange,
    newProp,
    notify,
    handleMarcaChange,
    handleCategoriaChange,
    handleSubcategoriaChange
  } = props;
  let [optionsMarca] = [
    marcas.map(marca => ({
      nombre: "marca",
      value: marca.id,
      label: marca.nombre
    }))
  ];
  let [optionsCategoria] = [
    categorias.map(categoria => ({
      nombre: "categoria",
      value: categoria.id,
      label: categoria.nombre
    }))
  ];
  let [optionsSubcategoria] = [
    subcategorias
      .filter(
        subcategoria => subcategoria.categoria === parseInt(categoria.id, 0)
      )
      .map(subcategoria => ({
        nombre: "sub_categoria",
        value: subcategoria.id,
        label: subcategoria.nombre
      }))
  ];
  return (
    <React.Fragment>
      <div className="card border-light mt-5">
        <div className="card-header">Nombre y Marca</div>
        <div className="card-body">
          <div className="form-row d-flex justify-content-between">
            <div className="form-group col-md-8">
              <input
                type="text"
                placeholder="Nombre..."
                name="nombre"
                className="form-control productoDefault"
                value={nombre}
                onChange={onChange}
              />
            </div>
            <div className="form-group col-md-4">
              <Select
                isClearable
                name="marca"
                value={
                  marca.id === undefined
                    ? null
                    : { label: marca.nombre, value: marca.id }
                }
                onChange={handleMarcaChange}
                options={optionsMarca}
                placeholder="Seleccione una marca..."
              />
              <MarcaModal
                newProp={newProp.bind(this)}
                notify={notify}
                btnClass="text-secondary btn btn-link float-right"
              />
            </div>
          </div>
        </div>
      </div>
      <div className="card border-light mt-5">
        <div className="card-header">Categoria</div>
        <div className="card-body">
          <div className="form-row d-flex justify-content-between mt-3">
            <div className="form-group col-md-6">
              <Select
                isClearable
                name="categoria"
                value={
                  categoria.id === undefined
                    ? null
                    : { label: categoria.nombre, value: categoria.id }
                }
                onChange={handleCategoriaChange}
                options={optionsCategoria}
                placeholder="Seleccione una categoria..."
              />
              <CategoriaModal
                newProp={newProp.bind(this)}
                notify={notify}
                btnClass="text-secondary btn btn-link"
              />
            </div>
            <div className="form-group col-md-4">
              <Select
                isClearable
                name="sub_categoria"
                value={
                  sub_categoria.id === undefined
                    ? null
                    : {
                        label: sub_categoria.nombre,
                        value: sub_categoria.id
                      }
                }
                onChange={handleSubcategoriaChange}
                options={optionsSubcategoria}
                placeholder="Seleccione una sub categoria..."
              />
              <SubCategoriaModal
                categoria={categoria}
                newProp={newProp.bind(this)}
                notify={notify}
                optionsCategoria={optionsCategoria}
                btnClass="text-secondary btn btn-link"
              />
            </div>
          </div>
        </div>
      </div>

      <div className="card border-light mt-5">
        <div className="card-header">
          <label htmlFor="descripcion">Descripción</label>
        </div>
        <div className="card-body">
          <div className="form-group">
            <textarea
              className="form-control productoDefault"
              name="descripcion"
              rows="3"
              value={descripcion ? descripcion : ""}
              onChange={onChange}
            />
          </div>
        </div>
      </div>
    </React.Fragment>
  );
};

export default ProductoDefault;
