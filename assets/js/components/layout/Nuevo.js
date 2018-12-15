import React, { Component } from "react";
import { Link } from "react-router-dom";

class Nuevo extends Component {
  render() {
    return (
      <Link to="producto/new" className="btn btn-success btn-block">
        <i className="fas fa-plus" /> Nuevo
      </Link>
    );
  }
}

export default Nuevo;
