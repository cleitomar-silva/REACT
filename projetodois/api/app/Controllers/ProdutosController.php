<?php


class ProdutosController extends Controller
{

    public function __construct()
    {

        include_once "../app/Models/ProdutosModel.php";
        $this->model = new ProdutosModel;


    }

    public function index()
    {
        $this->view('home/erro');
    }


    public function listar()
    {
        header("Access-Control-Allow-Origin:*");
        header("Content-type: application/json; charset=UTF-8");

        $lista = $this->model->exibe();

        $output = [];
           
        foreach($lista as $item)
        {            
            $temp_array = array();

            $temp_array['id']        = $item->id;
            $temp_array['titulo']    = $item->titulo;
            $temp_array['descricao'] = $item->descricao;      

            $output[] = $temp_array; 

        }

      
       echo json_encode($output);
    }

    
    public function gravar()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");

        $dado = (object)[];        

        $_POST = json_decode(file_get_contents("php://input"),true);  

        if($_POST){
            $dado->titulo  = trim($_POST['titulo']);
            $dado->descricao = trim($_POST['descricao']);          

            $retorno = $this->model->armazenar($dado);            
        }

        echo json_encode($retorno);

    } 

    public function visualisar($id = 0)
    {
        header("Access-Control-Allow-Origin:*");
        header("Content-type: application/json; charset=UTF-8");

        $lista = false;
 
        if($id)
        {      
            $lista = $this->model->visualizar($id);
        }

        echo json_encode($lista);

    }

 





}