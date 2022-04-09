import React, {useState, useEffect } from "react";
import { Link } from "react-router-dom";


export default function Home(){

  const [data, setData] = useState([]);

  const getProdutos = async() =>{
    fetch("http://localhost/REACT/projetodois/api/produtos/listar") // acesso essa url
        .then((response)=>response.json())      // tras uma reposta
        .then((responseJson)=>{   // essa reposta vou manipular
            setData(responseJson);            
        });
  }

  // Quando acessar essa pagina ele é executado
  useEffect(()=>{
    getProdutos();
  },[]);

  return (
    <div className="container mt-5">
      <h1>Listar</h1>
      <table className="table">
        <thead>
          <tr>
            <th scope="col">Id</th>
            <th scope="col">Título</th>
            <th scope="col">Descricao</th>
            <th scope="col">Ações</th>
          </tr>
        </thead>
        <tbody>
          {Object.values(data).map(produto =>(
            <tr key={produto.id}>
              <th>{produto.id}</th>
              <td>{produto.titulo}</td>
              <td>{produto.descricao}</td>
              <td>
                <Link className="btn btn-sm btn-info me-3" to={"/visualizar/" + produto.id}>Visualizar</Link>
                 Editar Apagar
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}


