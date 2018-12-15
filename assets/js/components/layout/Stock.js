import React from "react";
import Productos from "../productos/Productos";
import Nuevo from "./Nuevo";

export default () => {
  return (
    <React.Fragment>
      <div className="row pt-4 pb-2">
        <div className="col-md-10">
          <h2>Productos</h2>
        </div>
        <div className="col-md-2">
          <Nuevo />
        </div>
      </div>
      <div className="row">
        <Productos />
      </div>
    </React.Fragment>
  );
};
