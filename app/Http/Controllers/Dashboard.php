<?php
namespace App\Http\Controllers;
use Auth;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\AuthController;

class Dashboard extends Controller{
private $filterfile = '/srv/parentwall/public/filter';
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
	public function whitelistAdd($domain){
		
		$whitelist = file_get_contents($this->filterfile);
		$domainarray = explode("\n", $whitelist);
		foreach($domainarray as $existingdomain)
		{
			if($domain == $existingdomain)
			{
				return false;
			}
		}
		$reswhitelist = fopen($this->filterfile,'a');
		fputs($reswhitelist,$domain."\n");
		fclose($reswhitelist);
		$this->proxyRestart();
		
	}
	public function whitelistRemove($domain){
		$newlist = array();
		$whitelist = file_get_contents($this->filterfile);
		$domainarray = explode("\n", $whitelist);
		foreach($domainarray as $existingdomain)
		{
			if($domain != $existingdomain && !empty($existingdomain))
			{
				$newlist[]=$existingdomain;
			}
		}
		$reswhitelist = fopen($this->filterfile,'w');
		foreach($newlist as $newdomain)	
		{
			fputs($reswhitelist,$newdomain."\n");
		}
		fclose($reswhitelist);
		$this->proxyRestart();
	}
	public function whitelistFind($hint=""){
		$matches=array();
		$whitelist = file_get_contents($this->filterfile);
		$domainarray = explode("\n", $whitelist);
		foreach($domainarray as $domain)
		{
			if(preg_match("/$hint/", $domain) && !empty($domain))
			{
				$matches[]=$domain;
			}
		}
		return array('matches'=>$matches);
	}
	public function whitelistAddAccessPack(){}
	public function whitelistRemoveAccessPack(){}
	public function svcctl($service,$action) {
		echo eval('$this->'.$service.$action.'();');
		return back()->withInput();
	}
	public function whtlst($action,$domain=""){
		echo eval('$data = $this->whitelist'.$action.'($domain);');
		return view('whitelist')->with($data);
		//return back()->withInput(array($this->filterfile));
	}
}
