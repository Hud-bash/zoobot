import React, {Component} from 'react';
import ReactDOM from "react-dom";
import Router from "./components/navigation/Router";
import ZooKeeperTheme from "./components/themes/ZooKeeperTheme";

class App extends Component {
    render() {
        return <Router/>;
    }
}

ReactDOM.render(
    <ZooKeeperTheme>
        <App />
    </ZooKeeperTheme>
    , document.getElementById('root'));