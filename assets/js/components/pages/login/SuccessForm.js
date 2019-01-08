import React from "react";

export default function SuccessForm(props) {
  return (
    <div className="row">
      <div className="col-md-6 mx-auto">
        <div className="card">
          <div className="card-body">
            <h1 className="text-center pb-4 pt-3 card-title">
              Contraseña modificada.
            </h1>
            <h5 className="card-title text-success">
              Tu contraseña ha sido modificada con éxito
            </h5>
            <hr />

            <button
              type="button"
              onClick={e => {
                e.preventDefault();
                props.firstStep();
              }}
              className="btn btn-secondary btn-lg btn-block"
            >
              ¡Iniciar sesión!
            </button>
          </div>
        </div>
      </div>
    </div>
  );
}
