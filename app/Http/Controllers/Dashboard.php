<?php
namespace App\Http\Controllers;
use Auth;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\AuthController;
//echo realpath('.');exit;
require_once('../vendor/registereddomains/regDomain.inc.php');
class Dashboard extends Controller{
	private $filterfile = '/srv/parentwall/public/filter';
	function strip_host($hostname){
		$tldTree = config('tldtree.tldtree');
		$domain = getRegisteredDomain($hostname,$tldTree);	
		return $domain;
	}
	function get_filtered_hostnames($html){
		$hosts = array();
		$objDOM = new \DOMDocument();
		@$objDOM->loadHTML($html);
		$anchors = $objDOM->getElementsByTagName('a');
		foreach($anchors as $anchor)
		{
			$href = $anchor->getAttribute('href');
			$url = parse_url($href);
			if(!empty($url['host'])){
				$hosts[]=$url['host'];
			}
			
		}
		$imgs = $objDOM->getElementsByTagName('img');
		foreach($imgs as $img)
		{
			$href = $img->getAttribute('src');
			$url = parse_url($href);
			if(!empty($url['host'])){
				$hosts[]=$url['host'];
			}
		}
		$scripts = $objDOM->getElementsByTagName('script');
		foreach($scripts as $script)
		{
			$href = $script->getAttribute('src');
			$url = parse_url($href);
			if(!empty($url['host'])){
				$hosts[]=$url['host'];
			}
		}
		$links = $objDOM->getElementsByTagName('link');
		foreach($links as $link)
		{
			$href = $link->getAttribute('href');
			$url = parse_url($href);
			if(!empty($url['host'])){
				$hosts[]=$url['host'];
			}
		}
		
		foreach($hosts as $idx=>$host)
		{
			$hosts[$idx] = $this->strip_host($host);
		}
		
		$hosts = array_unique($hosts);
		$arrBlacklist = file("blacklists/master",FILE_IGNORE_NEW_LINES);
		$hostsClean = array_diff($hosts, $arrBlacklist);
		sort($hostsClean);
		$hostsClean = array_values($hostsClean);
		return $hostsClean;
	}
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
	public function proxyStatus(){
		exec("pgrep squid", $pids);
		if(empty($pids)) {
			return false;
		}
		else
		{
			return true;
		}
	}
	public function proxyStart(){
		exec("/usr/bin/sudo /usr/bin/squid");
	}
	public function proxyStop(){
		exec("/usr/bin/sudo /usr/bin/squid -k shutdown");
	}
	public function proxyRestart(){
		exec("/usr/bin/sudo /usr/bin/squid -k reconfigure");
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
		$domainarray = array_unique($domainarray);
		foreach($domainarray as $existingdomain)
		{
			if($domain == $existingdomain)
			{
				return $this->whitelistFind();
			}
		}
		$reswhitelist = fopen($this->filterfile,'a');
		fputs($reswhitelist,".".$domain."\n");
		fclose($reswhitelist);
		$this->proxyRestart();
		return $this->whitelistFind();
		
	}
	public function whitelistRemove($domain){
		$newlist = array();
		$whitelist = file_get_contents($this->filterfile);
		$domainarray = explode("\n", $whitelist);
		$domainarray = array_unique($domainarray);
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
		return $this->whitelistFind();
	}
	public function whitelistFind($hint=""){
		$matches=array();
		$whitelist = file_get_contents($this->filterfile);
		$domainarray = explode("\n", $whitelist);
		$domainarray = array_unique($domainarray);
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
	public function whitelistApproveSite(Request $request)
	{
		foreach($request->input('domains') as $idx=>$domain)
		{
			$this->whitelistAdd($domain);
			$data['domainsadded'][]=$domain;
		}
		$data['operation']='approveresult';
		$this->proxyRestart();
		return $data;
	}
	public function whitelistPreviewDomain($domain,$protocol) {
		$operation = "previewdomain";
		$html = file_get_contents($protocol.'://'.$domain);
		$filteredhostnames = $this->get_filtered_hostnames($html);
		$filteredhostnames[] = $this->strip_host($domain);
		$data = array('operation'=>$operation, 'domain'=>$domain, 'filteredhostnames'=>$filteredhostnames);
		return $data;
	}
	public function whitelistAddDomainReqFormProc($domain){}
	public function svcctl($service,$action) {
		echo eval('$this->'.$service.$action.'();');
		return back()->withInput();
	}
	public function whtlst($action,$domain="",$protocol=""){
		if(empty($protocol))
		{
			echo eval('$data = $this->whitelist'.$action.'($domain);');
		}
		else
		{
			echo eval('$data = $this->whitelist'.$action.'($domain,$protocol);');
		}
		return view('whitelist')->with($data);
	}
}
