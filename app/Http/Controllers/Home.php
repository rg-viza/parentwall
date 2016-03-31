<?php
namespace App\Http\Controllers;
use Auth;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\AuthController;
class Home extends Controller{
        public function __construct() {
		 $this->middleware('auth');
	}
	public function index(){
		$dashboard = new Dashboard();
		$firewallStatus  = $dashboard->firewallStatus();
		$proxyStatus  = $dashboard->proxyStatus();
		$internetStatus  = $dashboard->internetStatus();
		$isLoggedIn  = Auth::check();
		$data = array(
			'firewallStatus' => $firewallStatus,
			'proxyStatus' => $proxyStatus,
			'internetStatus' => $internetStatus,
			'isLoggedIn' => $isLoggedIn
		);
		return view('welcome')->with($data);
	}
}
