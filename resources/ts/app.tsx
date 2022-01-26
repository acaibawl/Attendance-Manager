import React from "react";
import ReactDOM from "react-dom";
import { BrowserRouter, Route, Routes } from "react-router-dom";

import NavBar from "./components/NavBar";
import Home from "./components/Home";
import About from "./components/About";
import Task from "./components/Task";
import Project from "./components/Project";
import User from "./components/User";
import MonthlySchedule from "./components/Attendances/MonthlySchedule";
import ScheduleCalendar from "./components/Attendances/ScheduleCalendar";

const App: React.FC = () => {
    return (
        <BrowserRouter>
            <NavBar />
            <Routes>
                <Route path="/about" element={<About />} />
                <Route path="/" element={<Home />} />
                <Route path="/tasks" element={<Task />} />
                <Route path="/projects" element={<Project />} />
                <Route path="/users/:userId" element={<User />} />
                <Route path="/users/:userId/attendances/schedules" element={<ScheduleCalendar />} />
            </Routes>
        </BrowserRouter>
    );
};

if (document.getElementById("app")) {
    ReactDOM.render(<App />, document.getElementById("app"));
}
