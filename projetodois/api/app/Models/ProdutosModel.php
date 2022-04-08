<?php


class ProdutosModel
{

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }


    public function exibe()
    {
        
        $this->db->query("SELECT * FROM produtos");
      
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
        $this->db->query("INSERT INTO produtos 
                                            (titulo,
                                             descricao                                             
                                            ) 
                                            VALUES (:titulo, 
                                                    :descricao                                                    
                                                    ) ");
        $this->db->bind("titulo", $dados->titulo);
        $this->db->bind("descricao", $dados->descricao);
      
       
        if($this->db->executa())
        {
            return $this->db->ultimoIdInserido();

        }else
        {
            return false;
        }
    }  



}