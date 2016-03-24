<?php
namespace App\Http\Controllers;
use Auth;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\AuthController;


class Dashboard extends Controller{
	public function firewallStatus(){
		exec("systemctl status iptables", $result);
		$statusline = $result[2];
		$check = strstr($statusline, "inactive");
		if(!empty($check)) {
			return false;
		}
		else
		{
			return true;
		}
	}
	public function firewallStart(){
		return exec("/usr/bin/sudo /usr/bin/systemctl start iptables");
	}
	public function firewallStop(){
		return exec("/usr/bin/sudo /usr/bin/systemctl stop iptables");
		//print_r($result);
	}
	public function firewallRestart(){
		return exec("/usr/bin/sudo /usr/bin/systemctl restart iptables");
	}
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
	public function proxyStart(){
		exec("/usr/bin/sudo /opt/sbin/tinyproxy");
	}
	public function proxyStop(){
		exec("/usr/bin/sudo /usr/bin/killall tinyproxy");
	}
	public function proxyRestart(){
		exec("/usr/bin/sudo /usr/bin/killall tinyproxy");
		exec("/usr/bin/sudo /opt/sbin/tinyproxy");	
	}
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
	public function svcctl($service,$action) {
		echo eval('$this->'.$service.$action.'();');
		return back()->withInput();
	}
}
