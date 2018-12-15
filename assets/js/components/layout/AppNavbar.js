import React, { Component } from "react";
import { Link } from "react-router-dom";
import { logOut } from "../../actions/usuarioActions";
import { connect } from "react-redux";
import PropTypes from "prop-types";

class AppNavbar extends Component {
  onLogoutClick = e => {
    e.preventDefault();
    this.props.logOut();
    //TODO: Que esto me redireccione a alguna parte.
  };

  render() {
    const { isAuthenticated } = this.props;
    const { usuario } = this.props;

    return (
      <nav className="navbar navbar-expand-md navbar-light bg-light ml-auto">
        <div className="container">
          <Link to="/" className="navbar-brand">
            paStock
          </Link>
          {// Este ternary espera al usuario, esté logueado o no.

          usuario.user || usuario.username ? (
            isAuthenticated ? (
              <React.Fragment>
                <ul className="navbar-nav mr-auto">
                  <li className="nav-item">
                    <Link to="/producto" className="nav-link">
                      Stock
                    </Link>
                  </li>
                  <li className="nav-item">
                    <Link to="/caja" className="nav-link">
                      Caja
                    </Link>
                  </li>
                  <li className="nav-item">
                    <Link to="/marca" className="nav-link">
                      Organizar Marcas
                    </Link>
                  </li>
                  <li className="nav-item">
                    <Link to="/categoria" className="nav-link">
                      Organizar Categorias
                    </Link>
                  </li>
                </ul>

                <ul className="navbar-nav mr-0">
                  <li className="nav-item">
                    <a href="#!" className="nav-link">
                      {usuario.username}
                    </a>
                  </li>
                </ul>
                <ul className="navbar-nav mr-0">
                  <li className="nav-item">
                    <a
                      href="#!"
                      className="nav-link"
                      onClick={this.onLogoutClick}
                    >
                      Logout
                    </a>
                  </li>
                </ul>
              </React.Fragment>
            ) : (
              <React.Fragment>
                <span />
                <ul className="navbar-nav mr-0">
                  <li className="nav-item">
                    <Link to="/login" className="nav-link">
                      Login
                    </Link>
                  </li>
                  <li className="nav-item">
                    <Link to="/register" className="nav-link">
                      Register
                    </Link>
                  </li>
                </ul>
              </React.Fragment>
            )
          ) : null}
        </div>
      </nav>
    );
  }
}

AppNavbar.propTypes = {
  logOut: PropTypes.func.isRequired
};

export default connect(
  null,
  { logOut }
)(AppNavbar);
