import React from "react";
import ReactDOM from "react-dom";
import { BrowserRouter, Route, Routes } from "react-router-dom";

import NavBar from "./components/NavBar";
import Home from "./components/Home";
import About from "./components/About";

const App = () => {
    return (
        <BrowserRouter>
            <NavBar />
            <Routes>
                <Route path="/about" element={<About />} />
                <Route path="/" element={<Home />} />
            </Routes>
        </BrowserRouter>
    );
};

if (document.getElementById("app")) {
    ReactDOM.render(<App />, document.getElementById("app"));
}
