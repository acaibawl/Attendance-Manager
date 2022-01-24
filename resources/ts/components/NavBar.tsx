import React from 'react';
import { Link } from 'react-router-dom';
import HomeIcon from '@mui/icons-material/Home';

const NavBar = () => {
    return (
        <div>
            <Link to="/"><HomeIcon /> Home</Link>
            <Link to="/about">About</Link>
            <Link to="/tasks">tasks</Link>
            <Link to="/projects">projects</Link>
            <Link to="/users/1">user</Link>
        </div>
    );
}

export default NavBar;
