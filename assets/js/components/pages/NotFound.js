import React, { Component } from "react";
import { notifyUser } from "../../actions/notifyActions";
import { connect } from "react-redux";
import PropTypes from "prop-types";

class NotFound extends Component {
  componentWillUnmount() {
    //Esto hace un clear a notify cada vez que cambie de ruta.
    const { notifyUser } = this.props;
    notifyUser(null, null, null);
  }
  render() {
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
  notifyUser: PropTypes.func.isRequired
};

export default connect(
  null,
  { notifyUser }
)(NotFound);
