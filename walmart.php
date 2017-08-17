<?php

include('simple_html_dom.php');
require_once 'Classes/PHPExcel.php';
require_once 'Classes/PHPExcel/Writer/Excel2007.php';
require_once 'Classes/PHPExcel/IOFactory.php';
require_once 'functions.php';

set_time_limit(0);
error_reporting(E_ALL ^ E_NOTICE);

$clearence_file = 'clearence.txt';
$clearence_urls = read_file($clearence_file);

foreach ($clearence_urls as $clearence_url){
		walmart($clearence_url);
}	

function walmart($url){
	$curl = curl_init(); 
	curl_setopt($curl,CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_COOKIESESSION, TRUE);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
	curl_setopt($curl, CURLINFO_HEADER_OUT, true);
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($curl,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
	curl_setopt($curl, CURLOPT_REFERER, 'http://www.walmart.com');
	curl_setopt($curl,CURLOPT_HEADER, false); 
	$result=curl_exec($curl);
	curl_close($curl);
	$html = new simple_html_dom(); 
	$html->load($result);
	$num = $html->find('div[class="result-summary-container"]');
	echo .'$num[0]</br>';
	preg_match("@Showing 40 of (.*) results@", $num[0], $total);
	echo $total[1].'</br>';
	$total_products = (int)$total[1];
	if($total_products%40 != 0)
		$loop = (int)($total_products/40)+1;
	else
		$loop = (int)($total_products/40);
	echo $loop.'</br>';
	preg_match("@Showing (.*) of (.*) results@", $num[0], $subset);
	echo $subset[1].'</br>';
	$products_displayed = (int)$subset[1];
	for($i=0; $i < $products_displayed; $i++){
		$divtitle = $html->find('h3[class="tile-heading"]');
		//echo $divtitle[$i]->plaintext." ";
		$divprice = $html->find('div[class="item-price-container"]');
		$child = $divprice[$i]->children[0];
		$price = $child->plaintext;
		//echo $price.'</br>';
	}
	$ul = $html->find('ul[class="paginator-list"]');
	$li = $ul[0]->children();
	$num_pages = sizeof($li);
	$aurl = explode('?' , $url);
	echo $aurl[0].'</br>';
	echo $result;
/****************************page scrap*************************************/
	for($pg = 2; $pg < $num_pages; $pg++){
		$purl = $aurl[0]."?page=$pg&".$aurl[1];
		echo $purl.'</br>';
	$curl = curl_init(); 
	curl_setopt($curl,CURLOPT_URL, $purl);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_COOKIESESSION, TRUE);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
	curl_setopt($curl, CURLINFO_HEADER_OUT, true);
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($curl,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
	curl_setopt($curl, CURLOPT_REFERER, 'http://www.walmart.com');
	curl_setopt($curl,CURLOPT_HEADER, false); 
	$presult=curl_exec($curl);
	curl_close($curl);
	$phtml = new simple_html_dom(); 
	$phtml->load($presult);
	$num = $phtml->find('div[class="result-summary-container"]');
	echo $num[0].'</br>';
	preg_match("@Showing (.*) of (.*) results@", $num[0], $total);
	echo $total[2].'</br>';
	$total_products = (int)$total[2];
	if($total_products%40 != 0)
		$loop = (int)($total_products/40)+1;
	else
		$loop = (int)($total_products/40);
	echo $loop.'</br>';
	preg_match("@Showing (.*) of (.*) results@", $num[0], $subset);
	echo $subset[1].'</br>';
	$products_displayed = (int)$subset[1];
	for($i=0; $i < $products_displayed; $i++){
		$divtitle = $phtml->find('h3[class="tile-heading"]');
		//echo $divtitle[$i]->plaintext." ";
		$divprice = $phtml->find('div[class="item-price-container"]');
		$child = $divprice[$i]->children[0];
		$price = $child->plaintext;
		//echo $price.'</br>';
	}
	echo $presult;
	unset($phtml);
	}
/*****************************page scrap*************************************/
		
	unset($html);
	return;
}
echo "Done";
?>