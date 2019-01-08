import React, { Component } from "react";
import LoginForm from "./LoginForm";
import RecoveryForm from "./RecoveryForm";
import CodeForm from "./CodeForm";
import PasswordForm from "./PasswordForm";
import SuccessForm from "./SuccessForm";

class Login extends Component {
  state = {
    step: 1,
    email: "",
    code: ""
  };

  onChange = e => {
    //Este onChange es para cambiar "email" o "code" cada vez que se uno de estos se ingresa correctamente en posteriores componentes. Esto es para asegurar de que se realice el procedimiento en la misma sesión y que no se pueda utilizar el código en otro momento, ya que sí o sí se tendrá que actualizar en state con el nuevo código para avanzar.

    this.setState({ [e.key]: e.value });
  };

  firstStep = () => {
    this.setState({
      step: 1
    });
  };

  // Proceed to next step
  nextStep = () => {
    const { step } = this.state;
    this.setState({
      step: step + 1
    });
  };

  // Go back to prev step
  prevStep = () => {
    const { step } = this.state;
    this.setState({
      step: step - 1
    });
  };
  render() {
    const { step, email, code } = this.state;

    switch (step) {
      case 1:
        return <LoginForm nextStep={this.nextStep} />;
      case 2:
        return (
          <RecoveryForm
            nextStep={this.nextStep}
            prevStep={this.prevStep}
            onChange={this.onChange.bind(this)}
          />
        );
      case 3:
        return (
          <CodeForm
            nextStep={this.nextStep}
            prevStep={this.prevStep}
            email={email}
            onChange={this.onChange.bind(this)}
          />
        );
      case 4:
        return (
          <PasswordForm
            prevStep={this.prevStep}
            nextStep={this.nextStep}
            email={email}
            code={code}
          />
        );
      case 5:
        return <SuccessForm email={email} firstStep={this.firstStep} />;
    }
  }
}

export default Login;
