<?php

use \Hcode\Page;
use Hcode\Model\Products; 

//Rota Página Home Site
$app->get('/', function() {
        $products = Products::listAll();
        $page = new Page();
        $page->setTpl("index", [
			'products' => Products::checkList($products)        		
        ]);
    });

?>