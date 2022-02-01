import axios from "axios";
import React, { useEffect, useState } from "react";
import TextField from '@mui/material/TextField';
import Button from '@mui/material/Button';
import { Navigate } from "react-router-dom";
import { useSanctum } from "react-sanctum";
import can from "../../domain/permission/roleLevels";
import { SubmitHandler, useForm } from "react-hook-form";
import * as yup from 'yup';
import { yupResolver } from '@hookform/resolvers/yup';

type FormInput = {
    name: string;
    email: string;
    role: number;
    password: string;
};

type FormAttributes = "name" | "email" | "role" | "password";

const requiredMessaga = '必須項目です';
const userFormSchema = yup.object({
    name: yup.string().required(requiredMessaga),
    email: yup
        .string()
        .required(requiredMessaga)
        .email('メールアドレスのフォーマットで入力してください'),
    role: yup.
        number()
        .required(requiredMessaga)
        .min(0, '0以上で入力してください')
        .max(30, '30以下で入力してください'),
    password: yup
        .string()
        .required(requiredMessaga)
        .min(8, '8文字以上で入力してください'),
})

const initialValues = {
    name: "",
    email: "",
    role: 0,
    password: "",
  };

const UserNew: React.FC = () => {
  const { user } = useSanctum();
  const { register, handleSubmit, setError, reset, formState:{ errors }} = useForm<FormInput>({
        mode: 'onChange',
        criteriaMode: 'all',
        shouldFocusError: true,
        resolver: yupResolver(userFormSchema),
        defaultValues: initialValues,
    });

    // フォーム送信時の処理
    const onSubmit: SubmitHandler<FormInput> = (data) => {
        // バリデーションチェックOK！なときに行う処理を追加
        axios
            .post("/api/users", data)
            .then(response => {
                reset();
                alert(`userId:${response.data.id}`)
            })
            .catch(error => {
                Object.keys(error.response.data.errors).forEach((key) => {
                    const assertedKey = key as FormAttributes;
                    error.response.data.errors[key].forEach((message: string) => {
                        setError(assertedKey, { message: message, type: 'manual' }, { shouldFocus: true });
                    });
                });
            });
    };

  return (
    can(user, "manager")
        ? (
        <div>
            <TextField  {...register('name')} id="name" label="名前" variant="outlined" error={'name' in errors} helperText={errors.name?.message} />
            <TextField  {...register('email')} id="email" label="email" variant="outlined" type="email" error={'email' in errors} helperText={errors.email?.message} />
            <TextField  {...register('role')} id="role" label="role" variant="outlined" type="number" error={'role' in errors} helperText={errors.role?.message} />
            <TextField  {...register('password')} id="password" label="パスワード" variant="outlined" type="password" error={'password' in errors} helperText={errors.password?.message} />
            <Button variant='contained' onClick={handleSubmit(onSubmit)} size='small'>作成</Button>
        </div>
        )
        : <Navigate to="/" />
  )
};

export default UserNew;
