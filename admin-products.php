<?php

//Rotas Admin Products

use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Products;

//Rota Lista Produtos - Template products.html
$app->get('/admin/products', function() { 
    User::verifyLogin();
    $products = Products::listAll();
    $page = new PageAdmin();    
    $page->setTpl("products", [
    	"products"=>$products
    ]);
  });

//Rota Criar Produtos - Template products-create.html
$app->get('/admin/products/create', function() { 
    User::verifyLogin();   
    $page = new PageAdmin();    
    $page->setTpl("products-create");
  });

//Rota Salvar Produto - Template products-create.html
$app->post('/admin/products/post-create', function() { 
    User::verifyLogin();   
    $product = new Products();    
    $product->setData($_POST);
    $product->save();
    header("Location: /ecommerce/admin/products");
    exit;
  });

//Rota Editar Produtos- Template products-create.html
$app->get('/admin/products_get/:idproduct', function($idproduct) { 
    User::verifyLogin(); 
    $product = new Products(); 
    $product->get((int)$idproduct);   
    $page = new PageAdmin();     
    $page->setTpl("products-update", [
    	'product'=>$product->getValues()
    ]);
  });

//Rota Editar Produtos- Template products-create.html
$app->post('/admin/products_post/:idproduct', function($idproduct) { 
    User::verifyLogin(); 
    $product = new Products(); 
    $product->get((int)$idproduct);   
    $product->setTpl($_POST);
    $product->save();
    $product->setPhoto($_FILES["file"]);
    header("Location: /ecommerce/admin/products");
    exit;
  });

//Rota Excluir Produtos- Template products-create.html
$app->get('/admin/products_delete/:idproduct', function($idproduct) { 
    User::verifyLogin(); 
    $product = new Products(); 
    $product->get((int)$idproduct);   
    $product->delete();
    header("Location: /ecommerce/admin/products");
    exit;
  });

?>