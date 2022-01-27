import React from 'react';
import { Link } from 'react-router-dom';
import HomeIcon from '@mui/icons-material/Home';
import { useSanctum } from "react-sanctum";
import Button from '@mui/material/Button';

const NavBar = () => {
    const { authenticated, user, signOut } = useSanctum();

    return (
        <div>
            <Link to="/"><HomeIcon /> Home</Link>
            <Link to="/about">About</Link>
            <Link to="/tasks">tasks</Link>
            <Link to="/projects">projects</Link>
            <Link to="/users/new">user作成</Link>
            <Link to={`/users/${user.id}`}>user</Link>
            <Button variant='outlined' onClick={signOut} size='small'>ログアウト</Button>
        </div>
    );
}

export default NavBar;
