import React from "react";
import classnames from "classnames";
import PropTypes from "prop-types";

const Alert = props => {
  const { message, messageType, errors } = props;
  //Agarro todos los inputs que haya en el formulario que tengan la clase form-control.
  const inputs = document.getElementsByClassName("register");
  //TODO: puedo mejorar el código de abajo.
  //Si recibo un array con los errores específicos para cada input.
  if (errors[0]) {
    //Por cada input...
    [].forEach.call(inputs, function(el) {
      //Creo un elemento small que contendrá el mensaje de error.
      const small = document.createElement("small");
      small.classList.add("float-right", "text-danger");
      //Recorro los errores. Si el valor del error coincide con el nombre del input, me quedo con el mensaje que contenga el error y lo ingreso en el elemento small.
      let contains = false;
      errors.forEach(error => {
        if (error.value === el.name) {
          contains = true;
          small.innerHTML = error.message;
        }
      });
      //Con este if elimino la clase is-invalid y el elemento small de todos los inputs, si es que los tienen. Con esto me aseguro de que no haya repeticiones.
      if (el.classList.contains("is-invalid")) {
        el.classList.remove("is-invalid");
        el.parentElement.removeChild(
          el.parentElement.getElementsByClassName("text-danger")[0]
        );
      }
      //Si el valor del error coincide con el nombre del input, entonces el input es inválido e ingreso el elemento small en el DOM. De otra forma, el input es válido.
      if (contains) {
        el.classList.add("is-invalid");
        el.parentElement.prepend(small);
      } else {
        el.classList.add("is-valid");
      }
    });
  } else if (messageType === "error") {
    //Esto es para el login. Si no hay un array que contenga los errores específicos para cada input, entonces todos los inputs son inválidos.
    [].forEach.call(inputs, function(el) {
      el.classList.add("is-invalid");
    });
  }

  /*
  errors
    ? Object.keys(errors).map((key, index) => {
        const input = document.getElementsByName(key)[0];
        input.classList.add(
          classnames({
            "is-invalid": errors[key].status === "error",
            "is-valid": errors[key].status !== "error"
          })
        );
        const small = document.createElement("small");
        small.classList.add("float-right", "text-danger");
        small.innerHTML = errors[key].message;

        input.parentElement.prepend(small);
      })
    : null;
    */

  /*
        const input = document.getElementsByName(errors.indexOf(error))[0];
        input.classList.add(
          classnames({
            "is-invalid": error.status === "error",
            "is-valid": error.status !== "error"
          })
        );
        const small = document.createElement("small");
        small.classList.add("float-right", "text-danger");
        small.innerHTML = error.message;

        input.parentElement.prepend(small);
        
      )*/

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
};

Alert.propTypes = {
  message: PropTypes.string.isRequired,
  messageType: PropTypes.string.isRequired
};

export default Alert;
