<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
class Home extends Controller{
	public function index(){
		$dashboard = new Dashboard();
		$tinyproxyStatus  = $dashboard->tinyproxyStatus();
		$internetStatus  = $dashboard->internetStatus();
		$data = array(
			'tinyproxyStatus' => $tinyproxyStatus,
			'internetStatus' => $internetStatus,
		);
		return view('welcome')->with($data);
	}
}
