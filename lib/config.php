<?php
	$sessionName = "Group9Project2";
	session_name($sessionName);
	session_start();
	$lastPage = null;
	if(!isset($_SESSION['time']))
		$_SESSION['time'] = time();

	// class config {
	// 	public $base_path;
	// 	public $base_url;
	// 	public $project_url = "/Project2";
	// 	// public $dev_name = "/~mmillard";
		
	// 	public function __construct() {
	// 		$this->base_path = $_SERVER['HTTP_HOST'];
	// 		$this->base_url = $this->base_path . $this->dev_name . $this->project_url;
	// 	}
	// }

	// $config = new config();

?>