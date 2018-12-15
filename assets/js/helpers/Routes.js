import React, { Component } from "react";
import {
  BrowserRouter as Router,
  Route,
  Switch,
  Redirect
} from "react-router-dom";
import { connect } from "react-redux";
import PropTypes from "prop-types";

import AppNavbar from "../components/layout/AppNavbar";
import Stock from "../components/layout/Stock";
import ShowProducto from "../components/productos/ShowProducto";
import NewProducto from "../components/productos/NewProducto";
import EditProducto from "../components/productos/EditProducto";
import NotFound from "../components/pages/NotFound";
import Login from "../components/pages/Login";
import OrganizarMarcas from "../components/organizar/OrganizarMarcas";
import OrganizarCategorias from "../components/organizar/OrganizarCategorias";
import Register from "../components/pages/Register";
import Caja from "../components/caja/Caja";
import { getUsuario } from "../actions/usuarioActions";

class Routes extends Component {
  componentDidMount() {
    this.props.getUsuario();
  }

  state = {
    isAuthenticated: ""
  };

  static getDerivedStateFromProps(props, state) {
    const { usuario } = props;

    if (usuario.id) {
      return { isAuthenticated: true };
    } else {
      return { isAuthenticated: false };
    }
  }
  render() {
    const { isAuthenticated } = this.state;
    const { usuario } = this.props;

    const PrivateRoute = ({ component: Component, ...rest }) =>
      //Este ternary hace esperar a que el usuario cargue, esté logueado o no.

      usuario.user || usuario.username ? (
        <Route
          {...rest}
          render={props =>
            isAuthenticated === true ? (
              <Component {...props} />
            ) : (
              <Redirect to="/login" />
            )
          }
        />
      ) : //TODO: poner un spinner
      null;
    const AnonymousRoute = ({ component: Component, ...rest }) => (
      <Route
        {...rest}
        render={props =>
          isAuthenticated === false ? (
            <Component {...props} />
          ) : (
            <Redirect to="/" />
          )
        }
      />
    );

    return (
      <Router>
        <div className="App">
          <AppNavbar isAuthenticated={isAuthenticated} usuario={usuario} />
          <div className="container">
            <Switch>
              <PrivateRoute exact path="/caja" component={Caja} />
              <PrivateRoute
                exact
                path="/producto/:id/show" //El /show no tendría que estar.
                component={ShowProducto}
              />
              <PrivateRoute
                exact
                path="/producto/:id/edit" //El /edit no tendría que estar.
                component={EditProducto}
              />
              <PrivateRoute exact path="/producto" component={Stock} />
              <PrivateRoute
                exact
                path="/producto/new"
                component={NewProducto}
              />
              <PrivateRoute exact path="/marca" component={OrganizarMarcas} />
              <PrivateRoute
                exact
                path="/categoria"
                component={OrganizarCategorias}
              />
              <AnonymousRoute exact path="/login" component={Login} />
              <AnonymousRoute exact path="/register" component={Register} />
              <Route component={NotFound} />
            </Switch>
          </div>
        </div>
      </Router>
    );
  }
}

Routes.propTypes = {
  usuario: PropTypes.object.isRequired
};

const mapStateToProps = state => ({
  usuario: state.usuario.usuario
});

export default connect(
  mapStateToProps,
  { getUsuario }
)(Routes);
