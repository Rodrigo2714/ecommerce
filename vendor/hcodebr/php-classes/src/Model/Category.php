<?php 

namespace Hcode\Model;

use \Hcode\Model;
use \Hcode\DB\Sql;
use \Hcode\Mailer;

class Category extends Model {

	public static function listAll()
	{
		//echo "Passou Category 1 <br>";
		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_categories ORDER BY descategory");

	}

	public function save()
	{
		//echo "Passou Category 2 <br>";
		$sql = new Sql();

		$results = $sql->select("CALL sp_categories_save(:idcategory, :descategory)", array(
			":idcategory"=>$this->getidcategory(),			
			":descategory"=>$this->getdescategory()
		));
		
		$this->setData($results[0]);

		Category::updateFile();
	}

	public function get($idcategory)
	{
		//echo "Passou Category 3 <br>";
		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_categories WHERE idcategory = :idcategory",[":idcategory"=>$idcategory
		]);
		
		$this->setData($results[0]);

	}

	public function delete()
	{
		//echo "Passou Category 4 <br>";
		$sql = new Sql();

		$sql->query("DELETE FROM tb_categories WHERE idcategory = :idcategory",[":idcategory"=>$this->getidcategory()
		]);
		
		Category::updateFile();

	}

	public static function updateFile()
	{

		$categories = Category::listAll();

		$html = [];

		foreach ($categories as $row) {
			array_push($html, '<li><a href="/categories/' . $row['idcategory'] . '">' . $row['descategory'] . '</a></li>');
		}

		file_put_contents($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "categories-menu.html", implode('', $html));

	}
}

?>