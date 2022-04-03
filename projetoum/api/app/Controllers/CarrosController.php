<?php


class CarrosController extends Controller
{

    public function __construct()
    {

        include_once "../app/Models/CarrosModel.php";
        $this->carrosModel = new CarrosModel;


    }

    public function index()
    {
        $this->view('home/erro');
    }


    public function listar()
    {
       $listaCarros = $this->carrosModel->exibeCarros();

       $output = [];

           
       foreach($listaCarros as $item)
       {            
           $temp_array = array();

           $temp_array['id']     = $item->id;
           $temp_array['marca']  = $item->marca;
           $temp_array['modelo'] = $item->modelo;
           $temp_array['ano']    = $item->ano;

           $output[] = $temp_array; 

       }

       header("Access-Control-Allow-Origin:*");
       header("Content-type: application/json");
       echo json_encode($output);


    }

    public function gravar()
    {
        $dado = (object)[];

        $dado->marca  = trim($_POST['marca']);
        $dado->modelo = trim($_POST['modelo']);
        $dado->ano    = trim($_POST['ano']);

        

       
       header("Access-Control-Allow-Origin:*");
       header("Content-type: application/json");
       echo json_encode($dado);


    }

 





}