import React, { useEffect, useState } from "react";
import {useParams} from "react-router-dom";



export default function Visualizar()
{
    const [data, setData] = useState([]);

    const { id } = useParams();
    
    useEffect(() => {
        const getProduto = async () =>{
            await fetch("http://localhost/REACT/projetodois/api/produtos/visualisar/" + id)
            .then((response)=>response.json())      // tras uma reposta
            .then((responseJson)=>{   // essa reposta vou manipular
                setData(responseJson);               
            });
        }
        getProduto();
    },[id]);   


    return(
        <div className="container mt-5">
            <div className="card">
                <div className="card-body">
                    <h1>Visualizar</h1>
                    <p className="mt-5">Id: {data.id}</p>
                    <p>Titulo: {data.titulo}</p>
                    <p>Descrição: {data.descricao}</p>
                </div>
            </div>

        </div>
    )
}