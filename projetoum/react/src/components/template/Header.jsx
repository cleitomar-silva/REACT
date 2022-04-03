
import React from "react"

export default class Header extends React.Component{
    
    render(){
        return(
        <header className="header">
            <h1 className="mt-3 ms-3 fs-6">
                <i className={`fa fa-${this.props.icon}`}></i> {this.props.title}
            </h1>
        </header>
        );
    }

}