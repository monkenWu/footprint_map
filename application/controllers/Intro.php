<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Intro extends MY_SqlFunction {

	//建構預載入需要執行的model
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->load->view("intro/intro_view");
	} 

}
