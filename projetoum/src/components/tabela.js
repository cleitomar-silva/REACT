import React from "react";

export default class Tabela extends React.Component{

    render(){
        return(
            <div className="container mt-5">
                <table className="table">
                    <thead>
                        <tr>
                            <td>Id</td>
                            <td>Marca</td>
                            <td>Modelo</td>
                            <td>Ano</td>
                        </tr>
                    </thead>
                    <tbody>
                        {this.props.arrayCarros.map(
                            row=>
                            <tr key={row.id} >
                                <td>{row.id}</td>
                                <td>{row.marca}</td>
                                <td>{row.modelo}</td>
                                <td>{row.ano}</td>                                
                            </tr>
                        )}
                    </tbody>
                </table>
               
            </div>
        );
    }

}