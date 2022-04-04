import React from "react";
import {Routes, Route } from "react-router-dom"

import Home from "../components/home/Home"; 
import Carro from "../components/carro/CarroCrud"

export default function Rotas(){

        return(
            <Routes >
                <Route exact path="/" element={<Home/>} />
                <Route path="/carro" element={<Carro/>} />
                <Route path="*" element={<Home/>} />
            </Routes>
        );
    

}