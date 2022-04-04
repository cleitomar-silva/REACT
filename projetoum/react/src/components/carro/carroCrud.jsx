import React, {useState} from "react"
import Header from "../template/Header"
import * as  Config from "../../main/Config";
import axios from "axios";
// import { UseHistory } from 'react-router-dom';

// ATUALIZAR_CARROS
// GRAVAR_CARROS

const initialValue = {
    marca: '',
    modelo:'',
    ano: '',           
    url: Config.GRAVAR_CARROS
}



export default function CarroCrud()
{
    
    const [values, setValues] = useState(initialValue);
    // const history = UseHistory();

    

    function gravar(e)
    {
        e.preventDefault();

    
        axios.post(values.url, values)
        .then((response) => {
            console.log(response.data);
        });
        
              
    }    
    

    function pegarValores(ev) 
    {
              
        const { name, value } = ev.target;         

        setValues({ ...values, [name]: value  });
        
    }


    
        return(
            <div>
                <Header icon="car" title="Carros" />

                

                <div className="container">
                    <form onSubmit={gravar} >
                        <div className="row">
                            <div className="col-lg-3">
                                <div className="mb-3">
                                    <label htmlFor="marca" className="form-label">Marca</label>
                                    <input type="text" className="form-control form-control-sm" id="marca" name="marca" onChange={pegarValores} />
                                </div>  
                            </div>
                            <div className="col-lg-3">
                                <div className="mb-3">
                                    <label htmlFor="modelo" className="form-label">Modelo</label>
                                    <input type="text" className="form-control form-control-sm" id="modelo" name="modelo" onChange={pegarValores} />
                                </div>  
                            </div>
                            <div className="col-lg-3">
                                <div className="mb-3">
                                    <label htmlFor="ano" className="form-label">Ano</label>
                                    <input type="text" className="form-control form-control-sm" id="ano" name="ano" onChange={pegarValores} />
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