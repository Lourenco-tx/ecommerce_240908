<?php

use \Hcode\PageAdmin;
use \Hcode\Model\User;

//Rota Página Administrativa
$app->get('/admin', function() {
        User::verifyLogin();
        $page = new PageAdmin();
        $page->setTpl("index");
    });

//Rota Formulário Login (login_get)
$app->get('/admin/login_get', function() {
        $page = new PageAdmin([
            "header" => false,
            "footer" => false
        ]);
        $page->setTpl("login");
    });

//Rota logar no administrativo (login_post)
$app->post('/admin/login_post', function() {       
        try {
        $user = User::login($_POST["login"], $_POST["password"]);
        if ($user) {
            // Usuário logado com sucesso
            header("Location: /ecommerce/admin");
        } else {
            // Exibir mensagem de erro "Usuário inexistente ou senha inválida"            
                echo '<script>
                    function mostrarAlertaERedirecionar() {
                    return new Promise(resolve => {
                    alert("Usuário inexistente ou senha inválida!");
                    resolve();
                    });
                    }

                    mostrarAlertaERedirecionar().then(() => {
                    window.location.href = "/ecommerce/admin/login_get";
                    });
                    </script>';          
         
        }
        } catch (\Exception $e) {
            // Tratar outras possíveis exceções
            echo "Ocorreu um erro: " . $e->getMessage();
        }
        exit;
    });

//Rota sair do administrativo (sign_out) 
$app->get('/admin/sign_out', function() {
        User::logout();
        header("Location: /ecommerce/");
        exit;
    });

?>
