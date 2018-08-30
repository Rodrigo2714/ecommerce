<?php 

namespace Hcode;

use Rain\Tpl;

class Page {

	private $tpl;
	private $options = [];
	private $defaults = [
		"header"=>true,
		"footer"=>true,
		"data"=>[]
	];

	public function __construct($opts = array(), $tpl_dir = "/views/")
	{
		//echo "Passou Page 1 <br>";

		$this->options = array_merge($this->defaults, $opts);

		$config = array(
		    "base_url"      => null,
		    "tpl_dir"       => $_SERVER['DOCUMENT_ROOT'].$tpl_dir,
		    "cache_dir"     => $_SERVER['DOCUMENT_ROOT']."/views-cache/",
		    "debug"         => false
		);


		Tpl::configure( $config );

		$this->tpl = new Tpl();

		if ($this->options['data']) $this->setData($this->options['data']);

		if ($this->options['header'] === true) $this->tpl->draw("header", false);

	}

	public function __destruct()
	{
		//echo "Passou Page 2 <br>";
		if ($this->options['footer'] === true) $this->tpl->draw("footer", false);

	}

	private function setData($data = array())
	{
		//echo "Passou Page 3 <br>";
		foreach($data as $key => $val)
		{

			$this->tpl->assign($key, $val);

		}

	}

	public function setTpl($tplname, $data = array(), $returnHTML = false)
	{
		//echo "Passou Page 4 <br>";

		$this->setData($data);

		return $this->tpl->draw($tplname, $returnHTML);

	}

}

 ?>