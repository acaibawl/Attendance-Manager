import React from 'react';
import { Link } from 'react-router-dom';
import HomeIcon from '@mui/icons-material/Home';
import { useSanctum } from "react-sanctum";

const NavBar = () => {
    const { authenticated, user, signIn } = useSanctum();

    return (
        <div>
            <Link to="/"><HomeIcon /> Home</Link>
            <Link to="/about">About</Link>
            <Link to="/tasks">tasks</Link>
            <Link to="/projects">projects</Link>
            <Link to={`/users/${user.id}`}>user</Link>
        </div>
    );
}

export default NavBar;
