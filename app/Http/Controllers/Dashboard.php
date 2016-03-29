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
				return $this->whitelistFind();
			}
		}
		$reswhitelist = fopen($this->filterfile,'a');
		fputs($reswhitelist,$domain."\n");
		fclose($reswhitelist);
		$this->proxyRestart();
		return $this->whitelistFind();
		
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
		sort($newlist);
		foreach($newlist as $newdomain)	
		{
			fputs($reswhitelist,$newdomain."\n");
		}
		fclose($reswhitelist);
		$this->proxyRestart();
		return $this->whitelistFind();
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
		$data = array('matches'=>$matches,'operation'=>'remove');
		return $data;
	}
	public function whitelistAddAccessPack(){}
	public function whitelistRemoveAccessPack(){}
	public function whitelistAddDomainReqForm($domain){
		$operation = "domainRequestForm";
		$user = Auth::user();
		$data = array('domain'=>$domain, 'user'=>$user, 'operation'=>$operation);
		return $data;
	}
	public function whitelistManage(){
		$operation = "manage";
		$links = array(
			'Remove'=>'/whtlst/find',
			'Approve'=>'/whtlst/approvelist'
		);
		$data = array('links'=>$links, 'operation'=>$operation);
		return $data;
	}
	public function whitelistApproveList(){
		$userlist = scandir('../storage/approvalrequests');
		foreach($userlist as $idx=>$user)
		{
			if($user=='.' || $user=='..')
			{
				unset($userlist[$idx]);
			}
		}
		$userlist = array_values($userlist);
		$data = array('operation'=>'approvelist','userlist'=>$userlist);
		return $data;
	}
	public function whitelistApproveUserList($user) {
		$domainlist = file('../storage/approvalrequests/'.$user);
		$data = array('operation'=>'approveuserlist','domainlist'=>$domainlist);
		return $data;
	}
	public function whitelistPreviewDomain($domain) {
		$operation = "previewdomain";
		$data = array('operation'=>$operation, 'domain'=>$domain);
		return $data;
	}
	public function whitelistAddDomainReqFormProc($domain){}
	public function svcctl($service,$action) {
		echo eval('$this->'.$service.$action.'();');
		return back()->withInput();
	}
	public function whtlst($action,$domain=""){
		echo eval('$data = $this->whitelist'.$action.'($domain);');
		return view('whitelist')->with($data);
	}
}
