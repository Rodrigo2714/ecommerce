<?php 

namespace Hcode;

class PageAdmin extends Page {

	public function __construct($opts = array(), $tpl_dir = "/views/admin/")
	{
		//echo "Passou PageAdmin 1 <br>";
		
		parent::__construct($opts, $tpl_dir);

	}

}

?>