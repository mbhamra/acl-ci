<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends My_Controller {

	public function __construct(){
		parent::__construct();
		
	}
	public function index()
	{
        echo __CLASS__ . ' - ' . __FUNCTION__ . '<br />';
	}

	public function add(){
		echo __CLASS__ . ' - ' . __FUNCTION__ . '<br />';
	}

	public function edit()
	{
		echo __CLASS__ . ' - ' . __FUNCTION__ . '<br />';
	}

	public function show()
	{
		echo __CLASS__ . ' - ' . __FUNCTION__ . '<br />';
	}
}
