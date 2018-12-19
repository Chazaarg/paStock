import React, { Component } from "react";
import { notify404 } from "../../actions/notifyActions";
import { connect } from "react-redux";
import PropTypes from "prop-types";

class NotFound extends Component {
  componentWillUnmount() {
    //Esto hace un clear a notify cada vez que cambie de ruta.
    const { notify404 } = this.props;
    notify404(false);
  }
  render() {
    document.title = "Página no encontrada";
    return (
      <div>
        <h1 className="display-4">
          <span className="text-secondary">404</span> Page Not Found
        </h1>
        <p className="lead">La página no existe</p>
      </div>
    );
  }
}

NotFound.propTypes = {
  notify404: PropTypes.func.isRequired
};

export default connect(
  null,
  { notify404 }
)(NotFound);
