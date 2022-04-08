import React from "react";
import {Routes, Route } from "react-router-dom"

import Home from "../pages/home/Home"; 
import Cadastrar from "../pages/Cadastrar";


export default function Rotas(){

    return(
        <Routes >
            <Route exact path="/" element={<Home/>} />
            <Route path="/cadastrar" element={<Cadastrar/>} />
            
        
            <Route path="*" element={<Home/>} /> 
        </Routes>
    );
    

}