<?php

	$ul = $html->find('ul[class="paginator-list"]');
	$li = $ul[0]->children();
	$num = sizeof($li);
	$num_pages = $li[$num-1]->children(0)->innertext;
	$num_pages = (int)$num_pages;
	echo $num_pages.'</br>';
	$aurl = explode('?' , $url);
	for($pg = 2; $pg < $num_pages+1; $pg++){
		//echo 'page'."-$pg".'</br>';
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
	$phtml->load($presult);
	$pdivtitle = $phtml->find('h3[class="tile-heading"]');
	$pdivprice = $phtml->find('div[class="item-price-container"]');	
	echo sizeof($pdivtitle).'</br>';
	$products_displayed = sizeof($pdivtitle);
	$walmart_products = array();
	for($i=0; $i < $products_displayed; $i++){
		echo $pdivtitle[$i]->plaintext." ";
		$title = $pdivtitle[$i]->plaintext;
		$child = $pdivprice[$i]->children[0];
		$price = $child->plaintext;
		echo $price.'</br>';
		$walmart_products[$title] = $price;
	}
	echo "<h1>I am here after webpage</h1>".'</br>';
	}
	
		//echo $phtml.'</br>';	
?>		
