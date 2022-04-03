import React from "react"
import Header from "../template/Header"
import * as  Config from "../../main/Config";

// ATUALIZAR_CARROS
// GRAVAR_CARROS

export default class carroCrud extends React.Component{
    
    constructor(){
        super();
        this.state=({
            list: [],
            marca: '',
            modelo:'',
            ano: '',           
            url: Config.GRAVAR_CARROS
           
        });
    }

    limpar(){
        this.setState({ marca: this.state.marca })
    }

    gravar(e)
    {
        e.preventDefault();

       fetch(this.state.url) // acesso essa url
        .then((response)=>response.json())      // tras uma reposta
        .then((responseJson)=>{   // essa reposta vou manipular
            this.setState({
                id: responseJson
            });
            
        }) 
        
    }     


    render(){
        return(
            <div>
                <Header icon="car" title="Carros" />

                

                <div className="container">
                    <form onSubmit={e =>this.gravar(e)} method="post">
                        <div className="row">
                            <div className="col-lg-3">
                                <div className="mb-3">
                                    <label htmlFor="marca" className="form-label">Marca</label>
                                    <input type="text" className="form-control form-control-sm" id="marca" name="marca" />
                                </div>  
                            </div>
                            <div className="col-lg-3">
                                <div className="mb-3">
                                    <label htmlFor="modelo" className="form-label">Modelo</label>
                                    <input type="text" className="form-control form-control-sm" id="modelo" name="modelo" />
                                </div>  
                            </div>
                            <div className="col-lg-3">
                                <div className="mb-3">
                                    <label htmlFor="ano" className="form-label">Ano</label>
                                    <input type="text" className="form-control form-control-sm" id="ano" name="ano" />
                                </div>  
                            </div>
                        </div>
                                         
                        
                        <button type="submit" className="btn btn-primary" >                            
                            Gravar
                        </button>
                    </form>

                </div>
               
            </div>
            

                

        );
    }

}