
# DOCUMENTAÇÃO

## 1 - Mover pasta.  Alteração no nome da pasta raiz, Alteração no nome do banco de dados ou for mover a pasta raiz de um lugar para outro.

    1.1 - Colocar no htaccess da pasta public o nome da pasta raiz
    
        <ifModule mod_rewrite.c>
        Options -Multiviews
        RewriteEngine On
        RewriteBase /nome_pasta_raiz/public
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^(.+)$ index.php?url=$1 [QSA,L]
        </ifModule>
    
    
    1.2 - Alterar arquivo configuracoes, mudar valor da variavel URL
    
        Caminho - app/configuracao.php';
    
    1.3 - Banco de dados
        
        Caminho - app/Libraries/Database.php';




## 2 - Nova página. Para criar uma nova página inserir:

    Rota       ********** caminho - app/Libraries/Rota.php, metodo destino();
    Menu       ********** caminho - app/Views/header.php
    Controller ********** caminho - app/Controllers;
    Model      ********** caminho - app/Models;
    View       ********** caminho - app/Views;
    Js         ********** caminho - public/js;




## 3 - Url

    1 - Na classe Rota() so informar a primeira posicao da url ex: agencia, nao necessita informar as outras 
        posicoes ex: tiss/novo, tiss/editar/12 etc. 




## Comentarios
     
   




















