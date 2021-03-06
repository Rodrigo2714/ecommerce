<?php 

use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Category;

$app->get('/admin/categories', function() {
	//echo "Passou Index 1 <br>";    
	User::verifyLogin();
	//echo "Passou Index 2 <br>";
	$categories = Category::listAll();
	//echo "Passou Index 3 <br>";
	$page = new PageAdmin();
	//echo "Passou Index 4 <br>";
	$page->setTpl("categories", [
		'categories'=>$categories
	]);
	//echo "Passou Index 5 <br>";
});

$app->get('/admin/categories/create', function() {
    
	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("categories-create");

});

$app->post('/admin/categories/create', function() {
    
	User::verifyLogin();

	$category = new Category();

	$category->setData($_POST);

	$category->save();

	header("Location: /admin/categories");
	exit;

});

$app->get('/admin/categories/:idcategory/delete', function($idcategory) {
    
	User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$category->delete();

	header("Location: /admin/categories");
	exit;

});

$app->get('/admin/categories/:idcategory', function($idcategory) {
    
	User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	//var_dump($category->getValues()); exit;

	$page = new PageAdmin();

	$page->setTpl("categories-update", [
		'category'=>$category->getValues()
	]);

});

$app->post('/admin/categories/:idcategory', function($idcategory) {
    
	User::verifyLogin();
    
	$category = new Category();

	$category->get((int)$idcategory);

	$category->setData($_POST);	

	$category->save();	

	header("Location: /admin/categories");
	exit;

});


$app->get('/categories/:idcategory', function($idcategory) {
   
	$category = new Category();

	$category->get((int)$idcategory);

	$page = new Page();

	$page->setTpl("category", [
		'category'=>$category->getValues(),
		'products'=>[]
	]);
});

?>