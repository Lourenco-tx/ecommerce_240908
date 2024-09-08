<?php

use \Hcode\PageAdmin;
use \Hcode\Model\User;

//Rota Formulário Cadastar Usuário (users/create)
$app->get('/admin/users/create', function() { 
        User::verifyLogin();    
        $page = new PageAdmin();
        $page->setTpl("users-create");        
    });

// Rota Salvar Cadastrar Usuário - create_post - Botão Cadastrar Usuário 
$app->post('/admin/users/create_post', function() { 
    User::verifyLogin(); 
    $user = new User();
    $_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;
    $user->setData($_POST);
    $user->save();
    header("Location: /ecommerce/admin/users");
    exit;  
});

// Rota listar usuário (admin/users)     
$app->get('/admin/users', function() { 
    User::verifyLogin();
    $users = User::listAll();
    $page = new PageAdmin();
    $page->setTpl("users", array(
        "users"=>$users
    ));
});

// Rota Formulário Editar usuário (users-get) Template users-update.html
$app->get('/admin/users_get/:iduser', function($iduser) { 
    User::verifyLogin();   
    $user = new User();      
    $user->get((int)$iduser);   
    $page = new PageAdmin();        
    $page->setTpl("users-update", array(
        "user"=>$user->getValues()
    ));
});

// Rota Salvar Edição Usuário - users_post - Botão Salvar Template users-update.html 
$app->post('/admin/users_post/:iduser', function($iduser) { 
    User::verifyLogin();   
    $user = new User();
    $user->get((int)$iduser);
    $user->setData($_POST);
    $user->update();
    header("Location: /ecommerce/admin/users");
    exit; 
});

//Rota deletar usuário - users_delete - Botão Excluir Template users.html
$app->get('/admin/users_delete/:iduser', function($iduser) { 
        User::verifyLogin();
        $user = new User();      
        $user->get((int)$iduser);
        $user->delete();
        header("Location: /ecommerce/admin/users");
        exit; 
    });

?>