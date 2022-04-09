import React, {useState} from "react";

export default function Cadastrar()
{

    const [produto, setProduto] = useState({
        titulo: '',
        descricao: ''
    })

    const [status, setStatus] = useState({        
        type: '',
        mensagem: ''
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
            if(responseJson)
            {
                setStatus({
                    type: 'sucesso',
                    mensagem: "Gravado" 
                })
            }
            else
            {
                setStatus({
                    type: 'erro',
                    mensagem: 'Nao foi possivel cadastrar produto' 
                })
            }

        })
        .catch(() =>{
            setStatus({
                type: 'erro',
                mensagem: "Erro! Nao foi possivel conectar" 
            })
        })

    }

    return (
        <div className="container mt-5">
            <div className="card">
                <div className="card-body">

                    {status.type === 'erro' ? 
                       <div className="alert alert-danger" role="alert">
                            {status.mensagem}                         
                        </div>
                         : ""                         
                    }
                    {status.type === 'sucesso' ? 
                       <div className="alert alert-success" role="alert">
                            {status.mensagem}
                        </div>
                         : ""                         
                    }

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