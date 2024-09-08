<?php

use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Category;

//Rota Formulário Nova Categoria - Botão Nova Categoria - Template categories.html
$app->get('/admin/categories/create', function() { 
        User::verifyLogin();
        $page = new PageAdmin();
        $page->setTpl("categories-create");
  });

//Rota Salvar Nova Categoria - Botão Salvar - Template categories.html
$app->post('/admin/categories/create_post', function() { 
    User::verifyLogin();           
    $category = new Category();   
    $category->setData($_POST);
    $category->save();
    header("Location: /ecommerce/admin/categories");
    exit; 
});

//Rota Listar Categorias (/admin/categories)
$app->get('/admin/categories', function() { 
    User::verifyLogin();        
    $categories = Category::listAll();     
    $page = new PageAdmin();
    $page->setTpl("categories", [
        'categories'=>$categories
    ]);
});

// Rota Formulário Editar Categoria (categories_get) Botão Editar Template categories-update.html
$app->get('/admin/categories_get/:idcategory', function($idcategory) { 
    User::verifyLogin();                   
    $category = Category::listByIdCategory((int)$idcategory);
    $page = new PageAdmin();        
    $page->setTpl("categories-update", array(
            "category"=>$category
    ));
});

// Rota Salvar Edição Categoria (categories_post) Botão Salvar Template categoria-update.html 
$app->post('/admin/categories_post/:idcategory', function($idcategory) { 
    User::verifyLogin();
    $category = new Category;                   
    $category->get((int)$idcategory);
    $category->setData($_POST);
    $category->save();
    header("Location: /ecommerce/admin/categories");    
    exit;
});

//Rota deletar Categoria (/admin/categories_delete) Botão Excluir Template categories-update.html
$app->get("/admin/categories_delete/:idcategory", function($idcategory) {  
    User::verifyLogin(); 
    $category = new Category(); 
    $category->get((int)$idcategory);        
    $category->delete(); 
    header("Location: /ecommerce/admin/categories");    
    exit;        
});

$app->get('/category/:idcategory', function($idcategory) 
{  
    $category = new Category();
    $page = new Page();  
    $category = Category::listByIdCategory((int)$idcategory);                     
    $page->setTpl("category", [
        'category'=>$category,  
        'products'=>[]      
    ]);
});

?>