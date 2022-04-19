import React from "react";
import {useNavigate } from "react-router-dom";

const Logout = () =>{
    const navigate = new useNavigate();
    localStorage.clear();
    navigate("/login");
    return(<h1>Hello</h1>);
}
export default Logout;