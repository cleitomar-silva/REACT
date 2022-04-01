<?php

include_once "ClassConexao.php";

class ClassCarros extends ClassConexao{


    public function exibeCarros()
    {
        $BFetch = $this->conectaDB()->prepare("select * from carros");
        $BFetch->execute();

        $output = [];
       
        foreach($BFetch as $item)
        {            
            $temp_array = array();

            $temp_array['id']     = $item['id'];
            $temp_array['marca']  = $item['marca'];
            $temp_array['modelo'] = $item['modelo'];
            $temp_array['ano']    = $item['ano'];

            $output[] = $temp_array; 

        }

       
        

        header("Access-Control-Allow-Origin:*");
        header("Content-type: application/json");
        echo json_encode($output);


    }

}