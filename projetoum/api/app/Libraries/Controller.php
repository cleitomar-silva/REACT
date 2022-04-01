<?php


class Controller
{

    public function model($model)
    {
        include_once "../app/Models/".$model.".php";
        return new $model;
    }

    public function view($view, $dados = [])
    {
        $arquivo = ("../app/Views/".$view.".php");
        if(file_exists($arquivo))
        {
            include_once $arquivo;
        }else{
            die("O arquivo de visualização não existe!");
        }

    }


}