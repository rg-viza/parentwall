<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
class Dashboard extends Controller{
	public function tinyproxyStatus(){
		exec("pgrep tinyproxy", $pids);
		if(empty($pids)) {
			return false;
		}
		else
		{
			return true;
		}
	}
	public function tinyproxyStart(){}
	public function tinyproxyStop(){}
	public function tinyproxyRestart(){}
	public function internetStatus(){
		exec("ping -c 1 www.google.com", $response);
		if(empty($response)) {
			return false;
		}
		else
		{
			return true;
		}
	}
	public function internetStart(){}
	public function internetStop(){}
	public function internetRestart(){}
}
