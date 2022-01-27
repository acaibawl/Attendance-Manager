import React from "react";
import { useSanctum } from "react-sanctum";

import AuthedView from "./AuthedView";
import Login from "./Login";


const CheckAuthentication = () => {
  const { authenticated, user, signIn } = useSanctum();

  if (authenticated === true) {
    return <AuthedView />;
  } else {
    return <Login />
  }
};

export default CheckAuthentication;
