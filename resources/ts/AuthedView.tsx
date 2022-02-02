import React from "react";
import { useSanctum } from "react-sanctum";
import { BrowserRouter, Route, Routes } from "react-router-dom";

import NavBar from "./components/NavBar";
import Home from "./components/Home";
import About from "./components/About";
import Task from "./components/Task";
import Project from "./components/Project";
import User from "./components/User";
import UserNew from "./components/User/UserNew";
import MonthlySchedule from "./components/Attendances/MonthlySchedule";
import ScheduleCalendar from "./components/Attendances/Schedule/ScheduleCalendar";
import ScheduleNew from "./components/Attendances/Schedule/ScheduleNew";
import ScheduleIndex from "./components/Attendances/Schedule/ScheduleIndex";


const AuthedView = () => {
    return (
        <BrowserRouter>
            <NavBar />
            <Routes>
                <Route path="/about" element={<About />} />
                <Route path="/" element={<Home />} />
                <Route path="/tasks" element={<Task />} />
                <Route path="/projects" element={<Project />} />
                <Route path="/users/new" element={<UserNew />} />
                <Route path="/users/:userId" element={<User />} />
                <Route path="/users/:userId/attendances/scheduleCalender" element={<ScheduleCalendar />} />
                <Route path="/users/:userId/attendances/schedules/new" element={<ScheduleNew />} />
                <Route path="/users/:userId/attendances/schedules" element={<ScheduleIndex />} />
            </Routes>
        </BrowserRouter>
    );
};

export default AuthedView;
