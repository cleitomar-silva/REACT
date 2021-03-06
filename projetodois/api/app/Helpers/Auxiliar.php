<?php


class Auxiliar{



    public static function upload($arquivo,$pasta,$pastaGrupo = '',$preservaNome = '')
    {
        //$result = array();
        $arquivos = $arquivo;

        if( is_string($arquivos['name']) ) {
            //single file upload, file['name'], $file['type'] will be a string
            //$result[] = validateAndSave($file);
            Auxiliar::uploadFinal($arquivos,$pasta,$pastaGrupo,$preservaNome);
        }
        else if( is_array($arquivos['name']) ) {
            //multiple files uploaded
            $file_count = count($arquivos['name']);
            //echo $file_count;
            //in PHP if you upload multiple files with `avatar[]` name, $file['name'], $file['type'], etc will be an array
            for($i = 0; $i < $file_count; $i++) {
                $file_info = array(
                    'name' => $arquivos['name'][$i],
                    'type' => $arquivos['type'][$i],
                    'size' => $arquivos['size'][$i],
                    'tmp_name' => $arquivos['tmp_name'][$i],
                    'error' => $arquivos['error'][$i]
                );
                //$result[] = validateAndSave($file_info);
                //echo $file_info;
                Auxiliar::uploadFinal($file_info,$pasta,$pastaGrupo,$preservaNome);
            }
        }
        //break;
    }

    public static function uploadFinal($arquivo,$pasta,$pastaGrupo = '',$preservaNome = '')
    {
        if(!(empty($arquivo))){
            $arquivo1 = $arquivo;
            preg_match("/\.(gif|bmp|png|jpg|jpeg|txt|pdf|doc|docx|xls|xlsx|ppt|pptx|pps|zip|rar){1}$/i", $arquivo1["name"], $ext);

            $nomearquivo = $arquivo1["name"];
            $extensao = strrchr($nomearquivo, '.');
            $nomearquivoTratado = Auxiliar::retirarAcentos(str_replace('.','',str_replace(' ','_',stristr($nomearquivo, '.', true))));
            //$nomearquivoTratado = tirarAcentos(str_replace('.','',str_replace(' ','_',stristr($nomearquivo, '.', true))));
            //$nomearquivoTratado = md5(tirarAcentos(str_replace('.','',str_replace(' ','_',stristr($nomearquivo, '.', true)))));
            if ($preservaNome == 'N'){
                $arquivo_tratado = md5(uniqid(time())) . "." . $extensao;
            } else{
                $arquivo_tratado = $nomearquivoTratado.$extensao;
            }
            //echo $arquivo_tratado;
            //break;
            $caracteres = array(".","-","/");

            if (!($pastaGrupo == '')){
                $pastaGrupo = "/".str_replace($caracteres,"",$pastaGrupo);
                Auxiliar::recursive_mkdir("files".$pastaGrupo);
              //  copy("files/index.htm", "files".$pastaGrupo."/index.htm");
            }

            $pasta = str_replace($caracteres,"",$pasta);
            Auxiliar::recursive_mkdir("files".$pastaGrupo."/".$pasta);
          //  copy("files/index.htm", "files".$pastaGrupo."/".$pasta."/index.htm");

            $pastadestino = "files".$pastaGrupo."/".$pasta;
            //echo $pastaGrupo;
            //recursive_mkdir($pastadestino);

            //copy("files/index.htm", $pastadestino."/index.htm");

            $destino = $pastadestino."/".$arquivo_tratado;
            //echo $destino;

            move_uploaded_file($arquivo1['tmp_name'],$destino);

            //return $destino;

        }
    }

    public static function recursive_mkdir($path, $mode = 0777) {
        $dirs = explode('/', $path);
        $count = count($dirs);
        $path = '.';
        //echo $count;
        for ($i = 0; $i < $count; ++$i) {
            $path .= '/' . $dirs[$i];
            if (!is_dir($path) && !mkdir($path, $mode)) {
                //echo $path;
                return false;
            }
        }
        //echo $path;
        //break;
        return true;
    }

    public static function retirarAcentos($texto) {
        //$texto = utf8_encode($texto);
        $array1 = array( "??", "??", "??", "??", "??", "??", "??", "??", "??", "??", "??", "??", "??", "??", "??", "??", "??", "??", "??", "??", "??", "??", "??", "??", "??", "??", "??", "??", "??", "??", "??", "??", "??", "??", "??", "??", "??", "??", "??", "??", "??", "??", "??", "??", "??", "??" );
        $array2 = array( "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c", "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C" );

        return str_replace( $array1, $array2, $texto );
    }

    public static function enviaEmailUploadProducao($destinatario, $assunto, $mensagem, $anexo = '', $destinatario2, $assunto2, $mensagem2)
    {
        $header = 'Content-type: text/html; charset=utf-8' . "\r\n" . 'From: ';
        $msg = '<html>
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <title>CAFAZ - Sistema de protocolo</title>
        <!-- Bootstrap -->
        <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body>' .
            utf8_decode($mensagem)
            . '</body></html>';

        // Use este require se voc?? usou o Git
        require 'PHPMailer/PHPMailerAutoload.php';

        $Mailer = new PHPMailer();

        // define que ser?? usado SMTP
        $Mailer->IsSMTP();

        // envia email HTML
        $Mailer->isHTML(true);
        $Mailer->SMTPKeepAlive = true;
        $Mailer->SMTPDebug = 0;

        // codifica????o UTF-8, a codifica????o mais usada recentemente
        $Mailer->addCustomHeader = $header;
        $Mailer->Charset = 'UTF-8';

        // Configura????es do SMTP
        $Mailer->Host = 'smtp.office365.com';
        //$Mailer->Host = gethostbyname(SERVER_MAIL);
        $Mailer->Port = 587;
        $Mailer->SMTPSecure = 'tls';

        //$Mailer->SMTPSecure = 'tls';
        $Mailer->SMTPAuth = true;
        $Mailer->Username = 'nao-responda@cafaz.org.br';
        $Mailer->Password = 'tic@f4zSaude';
        $Mailer->From = 'nao-responda@cafaz.org.br';

        // Nome do remetente
        $Mailer->FromName = 'CAFAZ - Portal Tiss';

        // assunto da mensagem
        $Mailer->Subject = utf8_decode($assunto);

        // corpo da mensagem
        $Mailer->Body = $msg;
        $Mailer->AddAddress($destinatario);

        /*
        $totalFiles = count($anexo);
        for ($i = 0; $i < $totalFiles; $i++) {
            // echo $anexo[$i]['name'];
            // echo $anexo[$i]['path'];
            $path = $anexo[$i]['path'];
            $name = $anexo[$i]['name'];
            $Mailer->AddAttachment($path, $name);
        } */

        if (!($Mailer->Send())) {
            echo 'Erro do PHPMailer: ' . $Mailer->ErrorInfo;
        }
        $Mailer->ClearAttachments();

        $Mailer->Timeout = 200;
        $Mailer->ClearAddresses();

        // $Mailer->AddAddress($destinatario2);
        $destinatarios = explode(";", $destinatario2);
        $contDest = count($destinatarios);
        if ($contDest >= 1) {
            for ($c = 0; $c < $contDest; $c++) {
                //echo $destinatarios[$c];
                $Mailer->AddAddress($destinatarios[$c]);
            }
        }
        $Mailer->Subject = utf8_decode($assunto2);
        $header = 'Content-type: text/html; charset=utf-8' . "\r\n" . 'From: ';
        $Mailer->addCustomHeader = $header;

        $msg2 = '<html>
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <title>CAFAZ - Sistema de protocolo</title>
        <!-- Bootstrap -->
        <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body>' .
            utf8_decode($mensagem2)
            . '</body></html>';

        $Mailer->Body = $msg2;
        $Mailer->AltBody = '';
        $Mailer->Send();



        $Mailer->ClearAttachments();


        $Mailer->ClearAllRecipients();
        $Mailer->SmtpClose();


    }


    public static function removerMascara($valor){
        $valor = trim($valor);
        $valor = str_replace(".", "", $valor);
        $valor = str_replace(",", "", $valor);
        $valor = str_replace("-", "", $valor);
        $valor = str_replace("/", "", $valor);
        $valor = str_replace(")", "", $valor);
        $valor = str_replace("(", "", $valor);
        $valor = str_replace(" ", "", $valor);
        $valor = str_replace("}", "", $valor);
        $valor = str_replace("{", "", $valor);
        $valor = str_replace("\"", "", $valor);
        $valor = str_replace("\'", "", $valor);
        return $valor;
    }

    public static function removerMascara2($valor){
        $valor = trim($valor);
        $valor = str_replace("}", "", $valor);
        $valor = str_replace("{", "", $valor);
        $valor = str_replace("\"", "", $valor);
        $valor = str_replace("\'", "", $valor);

        return $valor;
    }

    public static function removerMascara3($valor){
        $valor = trim($valor);
        $valor = str_replace('{"procedimentos":[{', "", $valor);
        $valor = str_replace("}]}", "", $valor);

        return $valor;
    }




    public static function inverteData($data){
        if(count(explode("/",$data)) > 1){
            return implode("-",array_reverse(explode("/",$data)));
        }elseif(count(explode("-",$data)) > 1){
            return implode("/",array_reverse(explode("-",$data)));
        }
    }

    public static function mascaraCpfCnpj($val)
    {
        $maskared = '';
        $k = 0;

        $cont = strlen($val);

        $mask = $cont == 11 ? '###.###.###-##' : '##.###.###/####-##';

        for($i = 0; $i<=strlen($mask)-1; $i++) {
            if($mask[$i] == '#') {
                if(isset($val[$k])) $maskared .= $val[$k++];
            } else {
                if(isset($mask[$i])) $maskared .= $mask[$i];
            }
        }
        return $maskared;
    }


    public static function formaPagamento($dado)
    {
        $retorno ='';

        switch ($dado):
            case '1':
                $retorno = "Dep??sito/transfer??ncia banc??ria";
                break;
            case '2':
                $retorno = "Carteira";
                break;
            case '3':
                $retorno = "Boleto Banc??rio / DDA";
                break;
            case '4':
                $retorno = "Dinheiro/cheque";
                break;
            default:
                $retorno ='';
        endswitch;

        return $retorno;

    }

    public static function debitoCreditoIndicador($dado)
    {
        $retorno ='';

        switch ($dado):
            case '1':
                $retorno = "Debito";
                break;
            case '2':
                $retorno = "Cr??dito";
                break;
            default:
                $retorno ='';
        endswitch;

        return $retorno;

    }

    public static function colocarDecimal($valorParcela)
    {
        if(!strstr($valorParcela,','))
        {
            $valorParcela = number_format($valorParcela,2,',','.');
        }

        $ex = explode(',',$valorParcela);
        $ex = array_reverse($ex);

        if( strlen(trim($ex[0])) == 1 )
        {
            $valorParcela = $valorParcela.'0';
        }

        return $valorParcela;
    }

    public static function replaceVinguraPonto($valor){
        $valor = trim($valor);
        $valor = str_replace(".", "", $valor);
        $valor = str_replace(",", ".", $valor);

        return $valor;
    }


    public static function atendimentoRN($dado)
    {
        $tipo = [];
        $tipo[null] = ['nome' => ''];
        $tipo['']   = ['nome' => ''];
        $tipo['S']  = ['nome' => 'Sim'];
        $tipo['N']  = ['nome' => 'N??o'];

        return $tipo[trim($dado)]['nome'];

    }

    public static function conselhoProfissao($dado)
    {
        $tipo = [];

        $tipo['']   = [ 'nome' => '' ];
        $tipo[null] = [ 'nome' => '' ];
        $tipo["01"] = [ 'nome' => 'Conselho Regional de Assist??ncia Social (CRAS)' ];
        $tipo["02"] = [ 'nome' => 'Conselho Regional de Enfermagem (COREN)' ];
        $tipo["03"] = [ 'nome' => 'Conselho Regional de Farm??cia (CRF)' ];
        $tipo["04"] = [ 'nome' => 'Conselho Regional de Fonoaudiologia (CRFA)' ];
        $tipo["05"] = [ 'nome' => 'Conselho Regional de Fisioterapia e Terapia Ocupacional (CREFITO)' ];
        $tipo["06"] = [ 'nome' => 'Conselho Regional de Medicina (CRM)' ];
        $tipo["07"] = [ 'nome' => 'Conselho Regional de Nutri????o (CRN)' ];
        $tipo["08"] = [ 'nome' => 'Conselho Regional de Odontologia (CRO)' ];
        $tipo["09"] = [ 'nome' => 'onselho Regional de Psicologia (CRP)' ];
        $tipo["10"] = [ 'nome' => 'Outros Conselhos (OUT)' ];

        return $tipo[trim($dado)]['nome'];

    }

    public static function caraterAtendimento($dado)
    {
        $tipo = [];
        $tipo[null] = ['nome' => ''];
        $tipo['']   = ['nome' => ''];
        $tipo[1]  = ['nome' => 'Eletiva'];
        $tipo[2]  = ['nome' => 'Urg??ncia/Emerg??ncia'];

        return $tipo[trim($dado)]['nome'];

    }

    public static function UFDescricao($dado)
    {
        $tipo = [];
        $tipo[null] = [ 'id' => '', 'nome' => '' ];
        $tipo['']   = [ 'id' => '', 'nome' => '' ];
        $tipo['11'] = [ 'id' => '11', 'nome' => 'Rond??nia' ];
        $tipo['12'] = [ 'id' => '12', 'nome' => 'Acre' ];
        $tipo['13'] = [ 'id' => '13', 'nome' => 'Amazonas' ];
        $tipo['14'] = [ 'id' => '14', 'nome' => 'Roraima' ];
        $tipo['15'] = [ 'id' => '15', 'nome' => 'Par??' ];
        $tipo['16'] = [ 'id' => '16', 'nome' => 'Amap??' ];
        $tipo['17'] = [ 'id' => '17', 'nome' => 'Tocantins' ];
        $tipo['21'] = [ 'id' => '21', 'nome' => 'Maranh??o' ];
        $tipo['22'] = [ 'id' => '22', 'nome' => 'Piau??' ];
        $tipo['23'] = [ 'id' => '23', 'nome' => 'Cear??' ];
        $tipo['24'] = [ 'id' => '24', 'nome' => 'Rio Grande do Norte' ];
        $tipo['25'] = [ 'id' => '25', 'nome' => 'Para??ba' ];
        $tipo['26'] = [ 'id' => '26', 'nome' => 'Pernambuco' ];
        $tipo['27'] = [ 'id' => '27', 'nome' => 'Alagoas' ];
        $tipo['28'] = [ 'id' => '28', 'nome' => 'Sergipe' ];
        $tipo['29'] = [ 'id' => '29', 'nome' => 'Bahia' ];
        $tipo['31'] = [ 'id' => '31', 'nome' => 'Minas Gerais' ];
        $tipo['32'] = [ 'id' => '32', 'nome' => 'Esp??rito Santo' ];
        $tipo['33'] = [ 'id' => '33', 'nome' => 'Rio de Janeiro' ];
        $tipo['35'] = [ 'id' => '35', 'nome' => 'S??o Paulo' ];
        $tipo['41'] = [ 'id' => '41', 'nome' => 'Paran??' ];
        $tipo['42'] = [ 'id' => '42', 'nome' => 'Santa Catarina' ];
        $tipo['43'] = [ 'id' => '43', 'nome' => 'Rio Grande do Sul' ];
        $tipo['50'] = [ 'id' => '50', 'nome' => 'Mato Grosso do Sul' ];
        $tipo['51'] = [ 'id' => '51', 'nome' => 'Mato Grosso' ];
        $tipo['52'] = [ 'id' => '52', 'nome' => 'Goi??s' ];
        $tipo['53'] = [ 'id' => '53', 'nome' => 'Distrito Federal' ];
        $tipo['98'] = [ 'id' => '98', 'nome' => 'Pa??ses Estrangeiros' ];


        return $tipo[$dado]['nome'];
    }

    public static function convertePalavras($string)
    {
        $string = str_replace('CA??MERA', 'C??MERA', $string);
        $string = str_replace('ACESSA??RIOS', 'ACESS??RIOS', $string);
        $string = str_replace('PRA??TESE', 'PR??TESE', $string);
        $string = str_replace('INTERMEDIA??RIOS', 'INTERMEDI??RIOS', $string);
        $string = str_replace('A??ssea', '??ssea', $string);
        $string = str_replace('CIRA??RGICO', 'CIR??RGICO', $string);
        $string = str_replace('DENTA??RIA', 'DENT??RIA', $string);
        $string = str_replace('POLA??MERO', 'POL??MERO', $string);
        $string = str_replace('TITA??NIO', 'TIT??NIO', $string);
        $string = str_replace('DESCARTA??VEIS', 'DESCART??VEIS', $string);
        $string = str_replace('DIRECIONA??VEL', 'DIRECION??VEL', $string);
        $string = str_replace('CA??NULA', 'C??NULA', $string);
        $string = str_replace('PRA??-TRANSFUSIONAIS', 'PR??-TRANSFUSIONAIS', $string);
        $string = str_replace('UTILIZAA??A??O', 'UTILIZA????O', $string);
        $string = str_replace('BALA??O', 'BAL??O', $string);
        $string = str_replace(' PA?? ', ' P?? ', $string);
        $string = str_replace('DIA??RIA', 'DI??RIA', $string);
        $string = str_replace('SESSA??O', 'SESS??O', $string);
        $string = str_replace('COLOCAA??A??O', 'COLOCA????O', $string);
        $string = str_replace('fA??gado', 'f??gado', $string);
        $string = str_replace('vesA??cula', 'ves??cula', $string);
        $string = str_replace('BALCA??NICO', 'BALC??NICO', $string);
        $string = str_replace('SESSA??O', 'SESS??O', $string);
        $string = str_replace('LesA??es', 'Les??es', $string);
        $string = str_replace('SILA??NCIO', 'SIL??NCIO', $string);



        $string = str_replace('A??', '??', $string);
        $string = str_replace('A??', '??', $string);
        $string = str_replace('A??', '??', $string);
        $string = str_replace('A??', '??', $string);
        $string = str_replace('A??', '??', $string);
        $string = str_replace('A??', '??', $string);
        $string = str_replace('A??', '??', $string);
        $string = str_replace(' A?? ', ' - ', $string);


        return $string;
    }

    public static function mostrarSexo($dado)
    {
        $tipo = [];
        $tipo[null] = ['nome' => ''];
        $tipo['']   = ['nome' => ''];
        $tipo[1]  = ['nome' => 'Masculino'];
        $tipo[3]  = ['nome' => 'Feminino'];

        return $tipo[trim($dado)]['nome'];
    }

    public static function mostrarEstadiamento($dado)
    {
        $tipo = [];
        $tipo[null] = ['nome' => ''];
        $tipo['']   = ['nome' => ''];
        $tipo[1]  = ['nome' => 'I'];
        $tipo[2]  = ['nome' => 'II'];
        $tipo[3]  = ['nome' => 'III'];
        $tipo[4]  = ['nome' => 'IV'];
        $tipo[5]  = ['nome' => 'N??o se aplica'];


        return $tipo[trim($dado)]['nome'];
    }

    public static function mostrarFinalidade($dado)
    {
        $tipo = [];
        $tipo[null] = ['nome' => ''];
        $tipo['']   = ['nome' => ''];
        $tipo[1]  = ['nome' => 'Curativa'];
        $tipo[2]  = ['nome' => 'Neoadjuvante'];
        $tipo[3]  = ['nome' => 'Adjuvante'];
        $tipo[4]  = ['nome' => 'Paliativa'];
        $tipo[5]  = ['nome' => 'Controle'];


        return $tipo[trim($dado)]['nome'];
    }

    public static function mostrarEcog($dado)
    {
        $tipo = [];
        $tipo[null] = ['nome' => ''];
        $tipo['']   = ['nome' => ''];
        $tipo[0]  = ['nome' => 'Totalmente ativo capaz de exercer, sem restri????es, todas as atividades que exercia antes do diagn??stico.'];
        $tipo[1]  = ['nome' => 'N??o exerce atividade f??sica extenuante, por??m ?? capaz de realizar um trabalho leve em casa ou no escrit??rio.'];
        $tipo[2]  = ['nome' => 'Caminha e ?? capaz de exercer as atividades de autocuidado, mas ?? incapaz de realizar qualquer atividade de trabalho. Permanece fora do leito mais de 50% das horas de vig??lia.'];
        $tipo[3]  = ['nome' => 'Capacidade de autocuidado limitada. Permanece no leito ou cadeira mais de 50% das horas de vig??lia.'];
        $tipo[4]  = ['nome' => 'Completamente dependente. N??o ?? capaz de exercer qualquer atividade de autocuidado. Totalmente confinado ?? cama ou cadeira.'];


        return $tipo[trim($dado)]['nome'];
    }

    public static function mostrarTumor($dado)
    {
        $tipo = [];
        $tipo[null] = ['nome' => ''];
        $tipo['']   = ['nome' => ''];
        $tipo[1]   = ['nome' => 'T1'];
        $tipo[2]   = ['nome' => 'T2'];
        $tipo[3]   = ['nome' => 'T3'];
        $tipo[4]   = ['nome' => 'T4'];
        $tipo[5]   = ['nome' => 'T0'];
        $tipo[6]   = ['nome' => 'Tis'];
        $tipo[7]   = ['nome' => 'Tx'];
        $tipo[8]   = ['nome' => 'N??o se aplica'];
        $tipo[9]   = ['nome' => 'Sem informa????o'];

        return $tipo[trim($dado)]['nome'];
    }

    public static function mostrarNodulo($dado)
    {
        $tipo = [];
        $tipo[null] = ['nome' => ''];
        $tipo['']   = ['nome' => ''];
        $tipo[1]   = ['nome' => 'N1'];
        $tipo[2]   = ['nome' => 'N2'];
        $tipo[3]   = ['nome' => 'N3'];
        $tipo[4]   = ['nome' => 'N0'];
        $tipo[5]   = ['nome' => 'NX'];
        $tipo[8]   = ['nome' => 'N??o se aplica'];
        $tipo[9]   = ['nome' => 'Sem informa????o'];

        return $tipo[trim($dado)]['nome'];
    }

    public static function mostrarMetastase($dado)
    {
        $tipo = [];
        $tipo[null] = ['nome' => ''];
        $tipo['']   = ['nome' => ''];
        $tipo[1]   = ['nome' => 'M1'];
        $tipo[2]   = ['nome' => 'M0'];
        $tipo[3]   = ['nome' => 'Mx'];
        $tipo[8]   = ['nome' => 'N??o se aplica'];
        $tipo[9]   = ['nome' => 'Sem informa????o'];

        return $tipo[trim($dado)]['nome'];
    }

    public static function mostrarTipoQuimioterapia($dado)
    {
        $tipo = [];
        $tipo[null] = ['nome' => ''];
        $tipo['']   = ['nome' => ''];
        $tipo[1]   = ['nome' => '1?? linha'];
        $tipo[2]   = ['nome' => '2?? linha'];
        $tipo[3]   = ['nome' => '3?? linha'];
        $tipo[4]   = ['nome' => 'Outras linhas'];


        return $tipo[trim($dado)]['nome'];
    }

    public static function mostrarUnidadeMedida($dado)
    {
        $tipo = [];
        $tipo[null] = ['nome' => ''];
        $tipo['']   = ['nome' => ''];
        $tipo['001']   = ['nome' => 'AMP Ampola'];
        $tipo['002']   = ['nome' => 'BUI Bilh??es de Unidades Internacionais'];
        $tipo['003']   = ['nome' => 'BG Bisnaga'];
        $tipo['004']   = ['nome' => 'BOLS Bolsa'];
        $tipo['005']   = ['nome' => 'CX Caixa'];
        $tipo['006']   = ['nome' => 'CAP C??psula'];
        $tipo['007']   = ['nome' => 'CARP Carpule'];
        $tipo['008']   = ['nome' => 'COM Comprimido'];
        $tipo['009']   = ['nome' => 'DOSE Dose'];
        $tipo['010']   = ['nome' => 'DRG Dr??gea'];
        $tipo['011']   = ['nome' => 'ENV Envelope'];
        $tipo['012']   = ['nome' => 'FLAC Flaconete'];
        $tipo['013']   = ['nome' => 'FR Frasco'];
        $tipo['014']   = ['nome' => 'FA Frasco Ampola'];
        $tipo['015']   = ['nome' => 'GAL Gal??o'];
        $tipo['016']   = ['nome' => 'GLOB Gl??bulo'];
        $tipo['017']   = ['nome' => 'GTS Gotas'];
        $tipo['018']   = ['nome' => 'G Grama'];
        $tipo['019']   = ['nome' => 'L Litro'];
        $tipo['020']   = ['nome' => 'MCG Microgramas'];
        $tipo['021']   = ['nome' => 'MUI Milh??es de Unidades Internacionais'];
        $tipo['022']   = ['nome' => 'MG Miligrama'];
        $tipo['023']   = ['nome' => 'ML Mililitro'];
        $tipo['024']   = ['nome' => 'OVL ??vulo'];
        $tipo['025']   = ['nome' => 'PAS Pastilha'];
        $tipo['026']   = ['nome' => 'LT Lata'];
        $tipo['027']   = ['nome' => 'PER P??rola'];
        $tipo['028']   = ['nome' => 'PIL P??lula'];
        $tipo['029']   = ['nome' => 'PT Pote'];
        $tipo['030']   = ['nome' => 'KG Quilograma'];
        $tipo['031']   = ['nome' => 'SER Seringa'];
        $tipo['032']   = ['nome' => 'SUP Suposit??rio'];
        $tipo['033']   = ['nome' => 'TABLE Tablete'];
        $tipo['034']   = ['nome' => 'TUB Tubete'];
        $tipo['035']   = ['nome' => 'TB Tubo'];
        $tipo['036']   = ['nome' => 'UN Unidade'];
        $tipo['037']   = ['nome' => 'UI Unidade Internacional'];
        $tipo['038']   = ['nome' => 'CM Cent??metro'];
        $tipo['039']   = ['nome' => 'CONJ Conjunto'];
        $tipo['040']   = ['nome' => 'KIT Kit'];
        $tipo['041']   = ['nome' => 'M?? Ma??o'];
        $tipo['042']   = ['nome' => 'M Metro'];
        $tipo['043']   = ['nome' => 'PC Pacote'];
        $tipo['044']   = ['nome' => 'P?? Pe??a'];
        $tipo['045']   = ['nome' => 'RL Rolo'];
        $tipo['046']   = ['nome' => 'GY Gray'];
        $tipo['047']   = ['nome' => 'CGY Centgray'];
        $tipo['048']   = ['nome' => 'PAR Par'];
        $tipo['049']   = ['nome' => 'ADES Adesivo Transd??rmico'];
        $tipo['050']   = ['nome' => 'COM EFEV Comprimido Efervecente'];
        $tipo['051']   = ['nome' => 'COM MST Comprimido Mastig??vel'];
        $tipo['052']   = ['nome' => 'SACHE Sache'];

        return $tipo[trim($dado)]['nome'];
    }

    public static function mostrarViaAdministracao($dado)
    {
        $tipo = [];
        $tipo[null] = ['nome' => ''];
        $tipo['']   = ['nome' => ''];
        $tipo['01']   = ['nome' => 'Bucal'];
        $tipo['02']   = ['nome' => 'Capilar'];
        $tipo['03']   = ['nome' => 'Dermatol??gica'];
        $tipo['04']   = ['nome' => 'Epidural'];
        $tipo['05']   = ['nome' => 'Gastrostomia/jejunostomia'];
        $tipo['06']   = ['nome' => 'Inalat??ria'];
        $tipo['07']   = ['nome' => 'Intra- ??ssea'];
        $tipo['08']   = ['nome' => 'Intra-arterial'];
        $tipo['09']   = ['nome' => 'Intra-articular'];
        $tipo['10']   = ['nome' => 'Intracard??aca'];
        $tipo['11']   = ['nome' => 'Intrad??rmica'];
        $tipo['12']   = ['nome' => 'Intralesional'];
        $tipo['13']   = ['nome' => 'Intramuscular'];
        $tipo['14']   = ['nome' => 'Intraperitonial'];
        $tipo['15']   = ['nome' => 'Intrapleural'];
        $tipo['16']   = ['nome' => 'Intratecal'];
        $tipo['17']   = ['nome' => 'Intratraqueal'];
        $tipo['18']   = ['nome' => 'Intrauterina'];
        $tipo['19']   = ['nome' => 'Intravenosa'];
        $tipo['20']   = ['nome' => 'Intravesical'];
        $tipo['21']   = ['nome' => 'Intrav??trea'];
        $tipo['22']   = ['nome' => 'Irriga????o'];
        $tipo['23']   = ['nome' => 'Nasal'];
        $tipo['24']   = ['nome' => 'Oft??lmica'];
        $tipo['25']   = ['nome' => 'Oral'];
        $tipo['26']   = ['nome' => 'Otol??gica'];
        $tipo['27']   = ['nome' => 'Retal'];
        $tipo['28']   = ['nome' => 'Sonda enteral'];
        $tipo['29']   = ['nome' => 'Sonda g??strica'];
        $tipo['30']   = ['nome' => 'Subcut??nea'];
        $tipo['31']   = ['nome' => 'Sublingual'];
        $tipo['32']   = ['nome' => 'Transd??rmica'];
        $tipo['33']   = ['nome' => 'Uretral'];
        $tipo['34']   = ['nome' => 'Vaginal'];
        $tipo['35']   = ['nome' => 'Outras'];


        return $tipo[trim($dado)]['nome'];
    }

    public static function mostrarDiagImagem($dado)
    {
        $tipo = [];
        $tipo[null] = ['nome' => ''];
        $tipo['']   = ['nome' => ''];
        $tipo[1]  = ['nome' => 'Tomografia'];
        $tipo[2]  = ['nome' => 'Resson??ncia Magn??tica'];
        $tipo[3]  = ['nome' => 'Raios-X'];
        $tipo[4]  = ['nome' => 'Outras'];
        $tipo[5]  = ['nome' => 'Ultrassonografia'];
        $tipo[6]  = ['nome' => 'PET'];

        return $tipo[trim($dado)]['nome'];
    }

    public static function valorAtributo($dado)
    {
        $tipo = [];
        $tipo[null]       = ['nome' => ''];
        $tipo['']         = ['nome' => ''];
        $tipo['Direito']  = ['nome' => 'D'];
        $tipo['Esquerdo'] = ['nome' => 'E'];

        return $tipo[trim($dado)]['nome'];
    }

    public static function converteDescricao($dado)
    {

        $arrayJson =  json_decode($dado);

        return $arrayJson->DP;

    }



}