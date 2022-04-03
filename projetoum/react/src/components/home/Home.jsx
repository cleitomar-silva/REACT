import React from "react";
import Tabela from "../Tabela";
import Header from "../template/Header";
import * as  Config from "../../main/Config";



export default class Home extends React.Component{
   
    constructor(){
        super();
        this.state=({
            db: [],
            url: Config.LISTAR_CARROS
        });
        this.exibirCarros();

    }
    
    

    exibirCarros()
    {
        fetch(this.state.url) // acesso essa url
        .then((response)=>response.json())      // tras uma reposta
        .then((responseJson)=>{   // essa reposta vou manipular
            this.setState({
                db: responseJson
            });
            
        })
    }

    


    render(){
        
        return(
            <div>
                <Header icon="home" title="Inicio" />
                <Tabela arrayCarros={this.state.db}  />
            </div>
        );
    }

}