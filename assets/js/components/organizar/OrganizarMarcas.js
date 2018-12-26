import React, { Component } from "react";
import { connect } from "react-redux";
import PropTypes from "prop-types";

import { createLoadingSelector } from "../../helpers/CreateLoadingSelector";
import Loader from "react-loader";

import MarcaModal from "../layout/MarcaModal";
import { notifyUser } from "../../actions/notifyActions";

import {
  getMarcas,
  updateMarca,
  deleteMarca
} from "../../actions/productosActions";
import Marcas from "./Marcas";
import ProductoAlert from "../alert/ProductoAlert";

class OrganizarMarcas extends Component {
  state = {};
  componentDidMount() {
    this.props.getMarcas();
  }

  componentWillUnmount() {
    //Esto hace un clear a notify cada vez que cambie de ruta.
    const { message } = this.props.notify;
    const { notifyUser } = this.props;

    message && notifyUser(null, null, null);
  }

  newProp = () => {
    //Luego de unos segundos borro el mensaje
    setTimeout(() => {
      this.props.notifyUser(null, null, null);
    }, 10000);
  };

  render() {
    document.title = "Organizar Marcas";
    const { marcas, notify, updateMarca, deleteMarca } = this.props;

    return (
      <React.Fragment>
        {/* Heading */}
        <div className="row pt-4 pb-2 d-flex justify-content-start">
          <div className="col-md-6 pr-0">
            <h2>Organizar Marcas</h2>
          </div>

          {notify.message ? (
            <div className="col-md-4">
              <ProductoAlert
                message={notify.message}
                messageType={notify.messageType}
                errors={notify.errors}
              />
            </div>
          ) : null}
        </div>

        <div className="row d-flex justify-content-end">
          <div className="col-md-6">
            <MarcaModal
              newProp={this.newProp.bind(this)}
              notify={notify}
              btnClass="btn btn-success text-dark"
            />
          </div>
        </div>

        <div className="row">
          <Loader loaded={this.props.isFetching}>
            {/* Categorias */}

            <Marcas
              updateMarca={updateMarca.bind(this)}
              deleteMarca={deleteMarca.bind(this)}
              marcas={marcas}
              notifyUser={this.props.notifyUser.bind(this)}
            />
          </Loader>
        </div>
      </React.Fragment>
    );
  }
}
const loadingSelector = createLoadingSelector(["FETCH_MARCAS", "NOTIFY_USER"]);

OrganizarMarcas.propTypes = {
  getMarcas: PropTypes.func.isRequired,
  deleteMarca: PropTypes.func.isRequired,
  updateMarca: PropTypes.func.isRequired,
  isFetching: PropTypes.bool.isRequired,
  notifyUser: PropTypes.func.isRequired,
  notify: PropTypes.object.isRequired
};

const mapStateToProps = state => ({
  notify: state.notify,
  marcas: state.producto.marcas,
  isFetching: loadingSelector(state),
  loading: state.loading
});

export default connect(
  mapStateToProps,
  {
    getMarcas,
    updateMarca,
    deleteMarca,
    notifyUser
  }
)(OrganizarMarcas);
