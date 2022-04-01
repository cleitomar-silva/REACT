import React from "react";
import Tabela from "./tabela";

export default class App extends React.Component{


    constructor(){
        super();
        this.state=({
            db: []
        });
        this.exibirCarros();

    }

    exibirCarros()
    {
        fetch("http://localhost/REACT/projetoum/api/carros/listar") // acesso essa url
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
                <Tabela arrayCarros={this.state.db} />
            </div>
        );
    }
}
