import React from "react";
import PropTypes from "prop-types";

export default function CajaAlert(props) {
  const { message, messageType, errors } = props;

  /* ------------------- VENTA INPUTS ------------------- */
  const ventaInputs = Array.from(document.getElementsByClassName("ventaInput"));

  /* ------------------- PRODUCTO INPUTS ------------------- */
  const productoInputs = Array.from(
    document.getElementsByClassName("productoInput")
  );

  //Antes que nada, me aseguro de quitarles el error.
  ventaInputs.forEach(ventaInput => {
    if (ventaInput.classList.contains("is-invalid")) {
      ventaInput.classList.remove("is-invalid");
      const errMesage = ventaInput.parentElement.getElementsByClassName(
        "text-danger"
      )[0];

      if (errMesage) {
        ventaInput.parentElement.removeChild(errMesage);
      }
    }
  });
  //Antes que nada, me aseguro de quitarles el error.
  productoInputs.forEach(productoInput => {
    if (productoInput.classList.contains("is-invalid")) {
      productoInput.classList.remove("is-invalid");
      const errMesage = productoInput.parentElement.getElementsByClassName(
        "text-danger"
      )[0];

      if (errMesage) {
        productoInput.parentElement.removeChild(errMesage);
      }
    }
  });

  if (errors) {
    //Si hay errores en los VENTA INPUTS entonces los recorro y a los errores también.
    if (errors["ventaError"]) {
      ventaInputs.forEach(ventaInput => {
        //Creo el elemento small que contendrá el mensaje de error.
        const small = document.createElement("small");

        errors["ventaError"].forEach(ventaError => {
          if (ventaInput.id === ventaError.value) {
            ventaInput.classList.add("is-invalid");
            small.innerHTML = ventaError.message;

            if (ventaInput.labels) {
              small.classList.add("float-left", "text-danger");
              ventaInput.labels[0].parentElement.append(small);
            } else {
              small.classList.add("float-right", "text-danger");
              ventaInput.parentElement.append(small);
            }
          }
        });
      });
    }

    if (errors["productoError"]) {
      //Variable para recorrer inputs de 4 en 4.
      let doblePar = 0;

      errors["productoError"].forEach(productoError => {
        for (let i = 1; i < productoInputs.length; i++) {
          //Tengo que agarrar inputs de 4 en 4.
          if (i > doblePar && i < doblePar + 4) {
            productoError
              ? productoError.forEach(error => {
                  //Creo el elemento small que contendrá el mensaje de error.
                  const small = document.createElement("small");
                  small.innerHTML = error.message;
                  small.classList.add("float-right", "text-danger");

                  if (productoInputs[i].id === error.value) {
                    productoInputs[i].classList.add("is-invalid");
                    productoInputs[i].parentElement.append(small);
                  }
                })
              : null;
          }
        }

        doblePar += 4;
      });
    }
  }

  if (messageType === "success") {
    return <div className="alert alert-success col-8 pt-2 pb-2">{message}</div>;
  } else if (messageType === "error") {
    return <div className="alert alert-danger col-8 pt-2 pb-2">{message}</div>;
  } else {
    return null;
  }
}
