import "font-awesome/css/font-awesome.min.css"
import "./App.css"
import React from "react"
import { BrowserRouter } from 'react-router-dom'


import Routes from "./Rotas"
import Nav from "../components/template/Nav"
import Footer from "../components/template/Footer"

export default class App extends React.Component{
    render(){
        return(
            <BrowserRouter>
                 <div className="app">           
                    <Nav/>                    
                    <Routes/> 
                    <Footer/>
                </div>
            </BrowserRouter>       
        );  
    }

}



