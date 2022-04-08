<?php

/*
     * Class Rota
     * Cria as URL, carrega os controladores, métodos e parametros
     * FORMATO URL - /controlador/metodo/parametros
 */


class Rota
{

    private $controlador = 'PaginasController';
    private $metodo = 'index';
    private $parametros = [];


    public function __construct()
    {

        $url = $this->url() ? $this->url() : [0];

        $controller = $this->destino($url[0]);

        //  verifica se o controlador digitado na url existe
        if(file_exists('../app/Controllers/'.$controller.'.php'))
        {
            $this->controlador = $controller;
            unset($url[0]);
        }

        include_once '../app/Controllers/'.$this->controlador.'.php';

        // instancia o controlador
        $this->controlador = new $this->controlador;

        // verifica se existe metodo digitado na url
        if(isset($url[1]))
        {
            if(method_exists($this->controlador, $url[1]))
            {
                $this->metodo = $url[1];
                unset($url[1]);
            }
        }

        $this->parametros = $url ? array_values($url) : [];
        call_user_func_array([$this->controlador, $this->metodo], $this->parametros);
    }

    private function url()
    {
        $url = filter_input(INPUT_GET,'url',FILTER_SANITIZE_URL);
        if(isset($url))
        {
            $url = trim(rtrim($url,'/'));
            $url = explode('/', $url);

           return $url;
        }
    }

    private function destino($caminho = '')
    {
        switch (trim($caminho))
        {
            case 'produtos':                   return 'ProdutosController'; break;
          

            default:                         return ''; break;
        }

    }


}