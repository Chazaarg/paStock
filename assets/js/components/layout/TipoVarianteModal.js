import React, { Component } from "react";
import { connect } from "react-redux";
import PropTypes from "prop-types";
import {
  addVarianteTipo,
  deleteVarianteTipo
} from "../../actions/productosActions";
import { notifyUser } from "../../actions/notifyActions";

import {
  Modal,
  ModalHeader,
  Button,
  ModalBody,
  Form,
  FormGroup,
  Label,
  Input
} from "reactstrap";

class TipoVarianteModal extends Component {
  state = {
    modal: false,
    nombre: ""
  };

  toggle = () => {
    this.setState({
      modal: !this.state.modal
    });
  };

  onChange = e => {
    this.setState({ [e.target.name]: e.target.value });
  };

  onSubmit = e => {
    e.preventDefault();
    const { addVarianteTipo } = this.props;

    const newVarianteTipo = {
      nombre: this.state.nombre
    };

    //Añadir varianteTipo

    addVarianteTipo(newVarianteTipo).then(() => {
      if (this.props.notify.messageType === "success") {
        this.setState({
          nombre: ""
        });
        this.toggle();
      }
      //Luego de unos segundos borro el mensaje
      setTimeout(() => {
        this.props.notifyUser(null, null, null);
      }, 10000);
    });
  };

  render() {
    return (
      <React.Fragment>
        <div className="row">
          <button
            type="button"
            className="text-secondary btn btn-link"
            onClick={this.toggle}
          >
            <small>Añadir nuevo tipo de variante</small>
          </button>
          {this.props.varianteTipoId ? (
            <button
              type="button"
              className="text-danger btn btn-link"
              onClick={() => {
                this.props
                  .deleteVarianteTipo(this.props.varianteTipoId)
                  .then(() => {
                    if (this.props.notify.messageType !== "error") {
                      this.props.notifyUser(
                        `Tipo de variante  eliminado.`,
                        "warning",
                        null
                      );
                    }
                    //Luego de unos segundos borro el mensaje
                    setTimeout(() => {
                      this.props.notifyUser(null, null, null);
                    }, 10000);
                  });
              }}
            >
              <small>Eliminar tipo de variante seleccionado.</small>
            </button>
          ) : null}
        </div>
        <hr />
        <Modal isOpen={this.state.modal} toggle={this.toggle}>
          <ModalHeader toggle={this.toggle}>
            Añadir tipo de variante
          </ModalHeader>
          <ModalBody>
            <Form onSubmit={this.onSubmit}>
              <FormGroup>
                <Label for="tipoDeVariante">Tipo de Variante</Label>
                <Input
                  className="modalInput"
                  type="text"
                  name="nombre"
                  id="tipoDeVariante"
                  placeholder="Nombre..."
                  onChange={this.onChange}
                />
                <Button
                  type="button"
                  onClick={this.onSubmit}
                  color="dark"
                  style={{ marginTop: "2rem" }}
                  block
                >
                  Añadir tipo de variante
                </Button>
              </FormGroup>
            </Form>
          </ModalBody>
        </Modal>
      </React.Fragment>
    );
  }
}
TipoVarianteModal.propTypes = {
  addVarianteTipo: PropTypes.func.isRequired,
  deleteVarianteTipo: PropTypes.func.isRequired,
  notifyUser: PropTypes.func.isRequired
};

export default connect(
  null,
  { addVarianteTipo, deleteVarianteTipo, notifyUser }
)(TipoVarianteModal);
