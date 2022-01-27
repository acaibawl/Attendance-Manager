import React from "react";
import ReactDOM from "react-dom";
import { Sanctum } from "react-sanctum";

import CheckAuthentication from "./CheckAuthentication";

const sanctumConfig = {
    apiUrl: "http://127.0.0.1:8000",
    csrfCookieRoute: "sanctum/csrf-cookie",
    signInRoute: "login",
    signOutRoute: "logout",
    userObjectRoute: "api/user",
  };

const App: React.FC = () => {
    return (
        <Sanctum config={sanctumConfig}>
            <CheckAuthentication />
        </Sanctum>
    );
};

if (document.getElementById("app")) {
    ReactDOM.render(<App />, document.getElementById("app"));
}
