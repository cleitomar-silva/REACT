import React from "react";
import { BrowserRouter } from 'react-router-dom'

import Routes from "./Rotas"
import Nav from "../componentes/Nav";

export default function App(){

  return(
    <BrowserRouter>
      <div>        
          <Nav/>   
          <Routes/> 
      </div>
    </BrowserRouter> 
  );


}
