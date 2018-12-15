import React from "react";
import classnames from "classnames";
import PropTypes from "prop-types";

const ProductoAlert = props => {
  const { message, messageType, errors } = props;
  //Todos los inputs.
  let inputs = document.getElementsByClassName("is-invalid");
  inputs = Array.from(inputs);

  //Si recibo un array con los errores específicos para cada input...
  if (errors) {
    //Si hay errores en el producto...
    if (errors["productoError"] || errors["varianteError"]) {
      //Agarro los inputs de productoDefault.
      let defaultInputs = document.getElementsByClassName("productoDefault");
      defaultInputs = Array.from(defaultInputs);
      //Agarro los inputs de ProductoIndividual.
      let indInputs = document.getElementsByClassName("indInputs");
      indInputs = Array.from(indInputs);
      //Agarro los inputs de ProductoVariantes.
      let varInputs = document.getElementsByClassName("varInputs");
      varInputs = Array.from(varInputs);

      //Antes que nada, me aseguro de eliminar errores anteriores.
      if (inputs) {
        inputs.forEach(input => {
          if (input.classList.contains("is-invalid")) {
            input.classList.remove("is-invalid");
            const errMesage = input.parentElement.getElementsByClassName(
              "text-danger"
            )[0];
            if (errMesage) {
              input.parentElement.removeChild(errMesage);
            }
          }
        });
      }

      //Para cualquier tipo de producto verifico errores en los defaultInputs.
      if (errors.productoError.length > 0) {
        defaultInputs.forEach(input => {
          //Creo el elemento small que contendrá el mensaje de error.
          const small = document.createElement("small");
          small.classList.add("float-right", "text-danger");

          errors.productoError.forEach(error => {
            if (error.value === input.name) {
              input.classList.add("is-invalid");
              small.innerHTML = error.message;
              input.parentElement.append(small);
            }
          });
        });
      }
      //Si el producto tiene errores en las variantes.
      const cantDeVariantes = errors.varianteError.length;
      if (cantDeVariantes > 0) {
        //Variable para recorrer inputs de 4 en 4.
        let doblePar = 0;
        //Por cada variante
        errors.varianteError.forEach((variante, varIdx) => {
          for (let i = 1; i < varInputs.length; i++) {
            //Tengo que agarrar inputs de 4 en 4.
            if (i > doblePar && i < doblePar + 4) {
              variante.forEach(error => {
                if (varInputs[i].name === error.value) {
                  varInputs[i].classList.add("is-invalid");
                }
                if (error.value === "varianteTipo") {
                  varInputs[0].classList.add("is-invalid");
                }
              });
            }
          }
          doblePar += 4;
        });
      }
      //Si el producto no tiene variantes:
      else {
        indInputs.forEach(input => {
          errors.productoError.forEach(error => {
            if (error.value === input.name) {
              input.classList.add("is-invalid");
            }
          });
        });
      }
    }
    //Si hay errores en los Modal...
    else {
      if (errors !== null) {
        let modalInputs = document.getElementsByClassName("modalInput");
        modalInputs = Array.from(modalInputs);
        modalInputs.forEach((input, idx) => {
          //Primero me aseguro de eliminar errores y mensajes anteriores del DOM.
          if (input.classList.contains("is-invalid")) {
            input.classList.remove("is-invalid");
            input.parentElement.removeChild(
              input.parentElement.getElementsByClassName("text-danger")[idx]
            );
          }
          //Creo el elemento small que contendrá el mensaje de error.
          const small = document.createElement("small");
          small.classList.add("float-right", "text-danger");
          errors.forEach(error => {
            if (error.value === input.name || error.value === input.id) {
              input.classList.add("is-invalid");
              small.innerHTML = error.message;
              input.parentElement.insertBefore(small, input);
            }
          });
        });
      }
    }
  } else {
    //Si no hay errores, me aseguro de sacarle el mensaje de error a defaultInput. Esto es para newProducto.
    if (inputs) {
      inputs.forEach(input => {
        if (input.classList.contains("is-invalid")) {
          input.classList.remove("is-invalid");
          const errMesage = input.parentElement.getElementsByClassName(
            "text-danger"
          )[0];
          if (errMesage) {
            input.parentElement.removeChild(errMesage);
          }
        }
      });
    }
  }
  if (errors) {
    if (errors["productoError"]) {
      return (
        <div
          className={classnames("alert", {
            "alert-success": messageType === "success",
            "alert-danger": messageType === "error"
          })}
        >
          {message}
        </div>
      );
    } else {
      return null;
    }
  }
  //Para los Modal
  else if (messageType === "success") {
    return <div className="alert alert-success">{message}</div>;
  } else if (messageType === "warning") {
    return <div className="alert alert-warning">{message}</div>;
  } else {
    return null;
  }
};

ProductoAlert.propTypes = {
  message: PropTypes.string.isRequired,
  messageType: PropTypes.string.isRequired
};

export default ProductoAlert;
