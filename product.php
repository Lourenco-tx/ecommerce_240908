<?php

namespace Hcode\Model;

use \Hcode\DB\Sql;
use \Hcode\Model;
use Hcode\Model\Database;

class Category extends Model {
	public static function listAll()
	{ 
		$sql = new Sql();
	    return $sql->select("SELECT * FROM tb_categories ORDER BY descategory");
	}

	public function save()
	{
		$sql = new Sql();
		$results = $sql->select("CALL sp_categories_save(:idcategory, :descategory)", array(
				":idcategory"=>$this->getidcategory(),
				":descategory"=>$this->getdescategory()	
			));
		$this->setData($results[0]);
		Category::update_menu_categories();
	}

	public function get($idcategory){
		$sql = new Sql();
		$results = $sql->select("SELECT * FROM tb_categories WHERE idcategory = :idcategory", [
			':idcategory'=>$idcategory
		]);
		$this->setData($results[0]);
	}

	public function delete()
	{
	    $sql = new Sql();
	    $sql->query("DELETE FROM tb_categories WHERE idcategory = :idcategory", array(
			":idcategory"=>$this->getidcategory()
		));

		Category::update_menu_categories();
	}
	
	public static function listByIdCategory($idcategory)
	{
	    $sql = new Sql();
	    return $sql->select("SELECT * FROM tb_categories WHERE idcategory = :idcategory", [
	        ':idcategory'=>$idcategory
	    ]);
	}

	public function catupdate()
	{
		$sql = new Sql();		
		$results = $sql->select("CALL sp_categories_update(:idcategory, :descategory)", 
			array(
				":idcategory"=>$this->getidcategory(),
				":descategory"=>$this->getdescategory()
			));	
         $this->setData($results[0]);
	}

	public function update_menu_categories() 
	{
		$category = Category::listAll();
		$html = [];
		foreach ($category as $row) {
			array_push($html,'<li><a href="/ecommerce/category/'.$row['idcategory'].'">'.$row['descategory'].'</a></li>');
		}		
		file_put_contents('c:\xampp\htdocs\ecommerce\views\categories-menu.html', implode('',$html));		
	}

}

?>