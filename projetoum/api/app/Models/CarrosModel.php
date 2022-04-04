<?php


class CarrosModel
{

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }


    public function exibeCarros()
    {
        
        $this->db->query("SELECT * FROM carros");
      
        $resultado = $this->db->resultados();

        if($resultado)
        {
           return $resultado;

        }else
        {
            return false;
        }
        

    } 

    public function armazenar($dados)
    {
        $this->db->query("INSERT INTO carros 
                                            (marca,
                                             modelo,
                                             ano
                                             ) 
                                            VALUES (:marca, 
                                                    :modelo, 
                                                    :ano
                                                    ) ");
        $this->db->bind("marca", $dados->marca);
        $this->db->bind("modelo", $dados->modelo);
        $this->db->bind("ano", $dados->ano);
       
        if($this->db->executa())
        {
            return $this->db->ultimoIdInserido();

        }else
        {
            return false;
        }
    }



}