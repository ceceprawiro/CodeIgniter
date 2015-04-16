<?php defined('BASEPATH') or die();

class Welcome extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    
	public function index()
	{
		$this->twig->display('welcome_message');
	}
}
