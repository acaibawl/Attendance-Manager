import axios from "axios";
import React, { useEffect, useState } from "react";
import TextField from '@mui/material/TextField';
import Button from '@mui/material/Button';
import { Navigate } from "react-router-dom";
import { useSanctum } from "react-sanctum";
import can from "../../domain/permission/roleLevels";

const initialValues = {
    name: "",
    email: "",
    password: "",
  };

const UserNew: React.FC = () => {
  const { user } = useSanctum();
  const [ values, setValues] = useState(initialValues);

  const handleInputChange = (e: React.ChangeEvent<HTMLInputElement>) => {
      const target = e.target;
      const value = target.type === "checkbox" ? target.checked : target.value;
      const name = target.name;
      setValues({...values, [name]: value });
  };

  const handleRegister = () => {
    console.log('handleRegisterをリクエストします');
    console.log(values);
    axios
      .post("/api/users", values)
      .then(response => {
        setValues(initialValues);
        alert(`userId:${response.data.id}`)
      })
      .catch(error => {
        console.log('エラーです');
        console.log(error);
      });
  };

  return (
    can(user, "manager")
        ? (
        <div>
            <TextField name="name" id="name" label="名前" value={values.name} onChange={handleInputChange} variant="outlined" />
            <TextField name="email" id="email" label="email" value={values.email} onChange={handleInputChange} variant="outlined" type="email" />
            <TextField name="password" id="password" label="パスワード" value={values.password} onChange={handleInputChange} variant="outlined" type="password" />
            <Button variant='contained' onClick={handleRegister} size='small'>作成</Button>
        </div>
        )
        : <Navigate to="/" />
  )
};

export default UserNew;
