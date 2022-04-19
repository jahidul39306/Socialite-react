import React, { useEffect } from "react";
import { useState } from "react";
import axios from "axios";
import { Link } from "react-router-dom";
import { GoogleLogin, GoogleLogout } from 'react-google-login';

const clientId = "500246956156-63sh7sui5su1edaac3lplfic9tvccf5t.apps.googleusercontent.com";

const Registration = () => {

    const initialValues = { name: "", email: "", password: "", confirmPassword: "" };
    const [formValues, setFormValues] = useState(initialValues);
    const [formErrors, setFormErrors] = useState({});
    const [isSubmit, setIsSubmit] = useState(false);
    const [result, setResult] = useState({});

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormValues({ ...formValues, [name]: value });
    }

    const handleSubmit = (e) => {
        e.preventDefault();
        setFormErrors(validate(formValues));
        setIsSubmit(true);
    };

    // const handleGoogleReg = () =>{
    //     console.log("hollllaaa");
    //     axios.get("http://127.0.0.1:8000/api/registration/google").then(res => {
    //         const result = {};
    //         result.msg = res.data.msg;
    //         result.color = "text-green-600 font-bold text-l mb-1";
    //         if (res.data.color === 'red') {
    //             result.color = "text-red-600 font-bold text-l mb-1";
    //         }
    //         setResult(result);
    //     })
    // }

    useEffect(() => {
        if (Object.keys(formErrors).length === 0 && isSubmit) {
            console.log("called");

            axios.post("http://127.0.0.1:8000/api/registration/submit", formValues).then(res => {
                // console.log(res);
                const result = {};
                result.msg = res.data.msg;
                result.color = "text-green-600 font-bold text-l mb-1";
                if (res.data.color === 'red') {
                    result.color = "text-red-600 font-bold text-l mb-1";
                }
                setResult(result);
            })
        }
    }, [formErrors]);

    const validate = (values) => {
        const errors = {};
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/i;
        if (!values.name) {
            errors.name = "Name is required!";
        }
        if (!values.email) {
            errors.email = "Email is required!";
        }
        else if (!regex.test(values.email)) {
            errors.email = "Email format is wrong";
        }
        if (!values.password) {
            errors.password = "Password  is required!";
        }
        else if (values.password.length < 5) {
            errors.password = "Password must be more than 5 characters";
        }
        if (!values.confirmPassword) {
            errors.confirmPassword = "Confirm password  is required!";
        }
        else if (values.password !== values.confirmPassword) {
            errors.confirmPassword = "Confirm password does not match";
        }
        return errors;
    };

    const onLoginSuccess = (res) => {
        // console.log('Login Success:', res.profileObj);
        // console.log(res.profileObj.googleId);
        axios.get("http://127.0.0.1:8000/api/registration/google/submit", {
            params: {
                googleId : res.profileObj.googleId,
                name : res.profileObj.name,
                email : res.profileObj.email
            }
        })
        .then(res => {
            const result = {};
            result.msg = res.data.msg;
            result.color = "text-green-600 font-bold text-l mb-1";
            if (res.data.color === 'red') {
                result.color = "text-red-600 font-bold text-l mb-1";
            }
            setResult(result);
        })
    }


    return (

        <div className="h-screen flex">
            <div className="flex w-1/2 bg-gradient-to-tr from-purple-800 to-green-700 i justify-around items-center">
                <div>
                    <h1 className="text-white font-bold text-4xl font-sans">Socialite</h1>
                    <p className="text-white mt-1">Connecting people</p>
                    <Link to='/login'><button className="block w-full bg-green-600 mt-4 py-2 rounded-2xl text-white font-semibold mb-2">Login</button></Link>
                </div>
            </div>
            <div className="flex w-1/2 justify-center items-center bg-white">
                <form className="bg-white" onSubmit={handleSubmit}>
                    <h1 className="text-gray-800 font-bold text-2xl mb-1">Hello Again!</h1>
                    <p className="text-sm font-normal text-gray-600 mb-7">Welcome Back</p>

                    <div className="flex items-center border-2 py-2 px-3 rounded-2xl">
                        <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                        <input className="pl-2 outline-none border-none" type="text" name="name" id placeholder="Name" value={formValues.name} onChange={handleChange} />
                    </div>
                    <p className="text-red-600">{formErrors.name}</p>
                    <div className="flex items-center border-2 py-2 px-3 rounded-2xl mt-4">
                        <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                        <input className="pl-2 outline-none border-none" type="text" name="email" id placeholder="Email Address" value={formValues.email} onChange={handleChange} />
                    </div>
                    <p className="text-red-600">{formErrors.email}</p>
                    <div className="flex items-center border-2 py-2 px-3 rounded-2xl mt-4">
                        <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fillRule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clipRule="evenodd" />
                        </svg>
                        <input className="pl-2 outline-none border-none" type="password" name="password" id placeholder="Password" value={formValues.password} onChange={handleChange} />
                    </div>
                    <p className="text-red-600">{formErrors.password}</p>
                    <div className="flex items-center border-2 py-2 px-3 rounded-2xl mt-4">
                        <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fillRule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clipRule="evenodd" />
                        </svg>
                        <input className="pl-2 outline-none border-none" type="password" name="confirmPassword" id placeholder="Confirm Password" value={formValues.confirmPassword} onChange={handleChange} />
                    </div>
                    <p className="text-red-600">{formErrors.confirmPassword}</p>
                    <button type="submit" className="block w-full bg-indigo-600 mt-4 py-2 rounded-2xl text-white font-semibold mb-2">Registration</button>
                    <div>
                        <GoogleLogin
                        clientId={clientId}
                        buttonText="Registration with google"
                        onSuccess={onLoginSuccess}
                        cookiePolicy={'single_host_origin'}
                        />
                    </div>
                    <div className="flex items-center py-2 px-3"><p className={result.color}>{result.msg}</p></div>
                </form>
                
            </div>
        </div>
    )
}

export default Registration;