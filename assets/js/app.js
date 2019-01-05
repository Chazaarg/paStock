import React, { Component } from "react";
import { Provider } from "react-redux";

//Style
//Redux
import Routes from "./helpers/Routes";
import store from "./store";
import HttpsRedirect from "react-https-redirect";

class App extends Component {
  render() {
    return (
      <HttpsRedirect>
        <Provider store={store}>
          <Routes />
        </Provider>
      </HttpsRedirect>
    );
  }
}
export default App;
