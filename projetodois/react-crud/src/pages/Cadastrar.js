import React, {useState} from "react";

export default function Cadastrar()
{

    const [produto, setProduto] = useState({
        titulo: '',
        descricao: ''
    })

    function valorInput(e) 
    {              
        e.preventDefault();

       setProduto({...produto, [e.target.name]: e.target.value  });
        
    }

    async function cadastrarProduto(e)
    {
        e.preventDefault();      
        
        await fetch("http://localhost/REACT/projetodois/api/produtos/gravar", {
            method:"POST",
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(produto)
        })
        .then((response) => response.json())     
        .then((responseJson) => {
            console.log(responseJson);
        }); 

    }

    return (
        <div className="container mt-5">
            <div className="card">
                <div className="card-body">
                    <form onSubmit={cadastrarProduto}>
                        <div className="mb-3">
                            <label htmlFor="titulo" className="form-label">Titulo</label>
                            <input type="text" className="form-control" id="titulo" name="titulo" onChange={valorInput}/>                            
                        </div>
                        <div className="mb-3">
                            <label htmlFor="descricao" className="form-label">Descrição</label>
                            <input type="text" className="form-control" id="descricao" name="descricao" onChange={valorInput}/>                            
                        </div>
                        
                        <button type="submit" className="btn btn-primary">Gravar</button>
                    </form>
                </div>
            </div>

        </div>
    );
}