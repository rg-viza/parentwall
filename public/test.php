<?php
require_once("../vendor/registered-domains/effectiveTLDs.inc.php");
require_once("../vendor/registered-domains/regDomain.inc.php");
function get_filtered_hostnames($html,$tldTree){
	$hosts = array();
	$objDOM = new DOMDocument();
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
		$hosts[$idx] = getRegisteredDomain($host,$tldTree);
	}
	
	$hosts = array_unique($hosts);
	$arrBlacklist = file("blacklists/master",FILE_IGNORE_NEW_LINES);
	$hostsClean = array_diff($hosts, $arrBlacklist);
	sort($hosts);
	$hosts = array_values($hosts);
	sort($hostsClean);
	$hostsClean = array_values($hostsClean);
	print_r($hosts);
	print_r($hostsClean);
}
$html = file_get_contents("http://www.cnn.com");
get_filtered_hostnames($html,$tldTree);
?>

