import React from 'react';
import ReactDOM from 'react-dom/client';
import './index.css';
import App from './App';
import reportWebVitals from './reportWebVitals';
import Login from './Components/Login';
import Registration from './Components/Registration';
import {BrowserRouter as Router, Route, Routes} from 'react-router-dom';
import Header from './Components/Header';
import Logout from './Components/Logout';


const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(
  <React.StrictMode>
    <Router>
      <Routes>
        <Route exact path="/registration" element={<Registration />}></Route>
        <Route exact path="/login" element={<Login />}></Route>
        <Route exact path="/header" element={<Header />}></Route>
        <Route exact path="/logout" element={<Logout />}></Route>
      </Routes>
    </Router>
  </React.StrictMode>
);

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
reportWebVitals();
