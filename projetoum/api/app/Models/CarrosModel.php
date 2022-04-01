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

}