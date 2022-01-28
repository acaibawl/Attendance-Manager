import React from 'react';
import { Link } from 'react-router-dom';
import HomeIcon from '@mui/icons-material/Home';
import { useSanctum } from "react-sanctum";
import LogoutButton from './LogoutButton';
import can from '../domain/permission/roleLevels'

const NavBar = () => {
    const { authenticated, user, signOut } = useSanctum();

    return (
        <div>
            <Link to="/"><HomeIcon /> Home</Link>
            <Link to="/about">About</Link>
            <Link to="/tasks">tasks</Link>
            <Link to="/projects">projects</Link>
            {can(user, "manager") &&
                <Link to="/users/new">user作成</Link>
            }
            <Link to={`/users/${user.id}`}>user</Link>
            <LogoutButton />
        </div>
    );
}

export default NavBar;
