import React from 'react';
import { useSanctum } from "react-sanctum";
import Button from '@mui/material/Button';
import { useNavigate } from 'react-router-dom';


const LogoutButton = () => {
    const { signOut } = useSanctum();
    let navigate  = useNavigate();

    const handleLogout = () => {
        signOut();
        navigate('/');
    }

    return <Button variant='outlined' onClick={handleLogout} size='small'>ログアウト</Button>;
}

export default LogoutButton;
