import React, { Component } from "react";
import { Provider } from "react-redux";

//Style
import "../css/global.scss";
import "../css/app.css";
import "react-bootstrap-table-next/dist/react-bootstrap-table2.min.css";
import "react-bootstrap-table2-paginator/dist/react-bootstrap-table2-paginator.min.css";

//Redux
import Routes from "./helpers/Routes";
import store from "./store";

class App extends Component {
  render() {
    return (
      <Provider store={store}>
        <Routes />
      </Provider>
    );
  }
}
export default App;
