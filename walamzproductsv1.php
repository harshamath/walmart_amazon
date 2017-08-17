<?php

include('simple_html_dom.php');
require_once 'Classes/PHPExcel.php';
require_once 'Classes/PHPExcel/Writer/Excel2007.php';
require_once 'Classes/PHPExcel/IOFactory.php';
require_once 'functions.php';
require_once 'funcomparev1.php';

set_time_limit(0);
error_reporting(E_ALL ^ E_NOTICE);
$html = new simple_html_dom();
$phtml = new simple_html_dom();  
$spreadsheet = PHPExcel_IOFactory::load("Amazon_walmart_products.xlsx");
$spreadsheet->setActiveSheetIndex(0);
$worksheet = $spreadsheet->getActiveSheet();
$writer = new PHPExcel_Writer_Excel2007($spreadsheet);
$walmart_products = array();
$totalproducts = array();
for($nopage = 1; $nopage < 2; $nopage++){
$url = "http://www.walmart.com/browse/0/0/"."?page=$nopage"."&cat_id=0&facet=retailer:Walmart.com%7C%7Cspecial_offers:Clearance%7C%7Cspecial_offers:Rollback%7C%7Cspecial_offers:Special%20Buy";

echo $url.'</br>';
	$url = preg_replace('/\s+/', '', $url);
	$curl = curl_init(); 
	curl_setopt($curl,CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_COOKIESESSION, TRUE);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($curl,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
	curl_setopt($curl, CURLOPT_REFERER, 'http://www.walmart.com');
	curl_setopt($curl,CURLOPT_HEADER, false); 
	$result=curl_exec($curl);
	$html->load($result);
	$wurl = $html->find('a[class="js-product-title"]');
	$divtitle = $html->find('h3[class="tile-heading"]');
	$divp = $html->find('div[class="tile-price"]');
	$products_displayed = sizeof($divtitle);
	
	for($i=0; $i < $products_displayed; $i++){
		$title = ltrim($divtitle[$i]->plaintext, ' ');
		//echo $title;
		$divprice = $divp[$i]->find('span[class="price price-display"]');
		//$child = $divprice[$i]->children[0];
		$price = ltrim($divprice[0]->plaintext, ' ');
		//echo $price.' ';
		$stock = $divtitle[$i]->find('div[class="out-of-stock topic-out-of-stock"]');
		if(sizeof($stock) > 0)
			$stock_status = 'Out of stock';
		else
			$stock_status = 'In stock';
		$href = $wurl[$i]->href;	
		$walmart_product_url = 'http://www.walmart.com'.$href;	
		////echo $stock_status.'</br>';	
		$totalproducts[$i] = array($title, $price, $stock_status, $walmart_product_url);/*****************Walmart Product Array**************/
	}
	$walmart_products = array_merge($walmart_products, $totalproducts);
	//echo "<h1>I am here after webpage</h1>".'</br>';
	
}
$amazon = new simple_html_dom(); 
$amazon1 = new simple_html_dom();
$amazon2 = new simple_html_dom(); 
$amazon3 = new simple_html_dom();
$walsize = count($walmart_products);
echo $walsize.'</br>';
$amazon_products=array();
for($k=0;$k < $walsize; $k++){
	//echo $k.' '.'</br>';
    $walmart_prod = ltrim($walmart_products[$k][0], ' ');
	//echo $walmart_prod.'->'.'Product on walmart'.'</br>';
	$walmart_product = urlencode($walmart_prod);
	//echo $walmart_product;
	$aurl = "http://www.amazon.com/s/ref=nb_sb_noss?url=search-alias%3Daps&field-keywords=".$walmart_product;
	//$aurl = preg_replace('/\s+/', ' ', $aurl);
	//$aurl = preg_replace('/\s+/', '+', $aurl);
	//echo $aurl.'</br>';
	$curl = curl_init(); 
	curl_setopt($curl,CURLOPT_URL, $aurl);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_COOKIESESSION, TRUE);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($curl,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
	curl_setopt($curl, CURLOPT_REFERER, 'http://www.walmart.com');
	curl_setopt($curl,CURLOPT_HEADER, false); 
	$amz=curl_exec($curl);
	$amazon->load($amz);
	$h2 = $amazon->find('h2[class="a-size-medium a-color-null s-inline s-access-title a-text-normal"]');
	$productsz = sizeof($h2);
	if($productsz == 0){
		$h2 = $amazon->find('h2[class="a-size-base a-color-null s-inline s-access-title a-text-normal"]');
		$productsz = sizeof($h2);
	}
	//echo $productsz.' '.'products found on amazon'.'</br>';
	$amazon_products = array();
	for($prod=0; $prod < $productsz; $prod++){
		$amazon_products[$prod] = $h2[$prod]->plaintext;/*****Amazon Products listed for Walmart Product in Array******/
		//echo $amazon_products[$prod].'</br>';
	}
	/*****************************Comparision algorithm*******************************************/	
	$amazon_product = compare($walmart_prod, $amazon_products);
	if($amazon_product[0] != '0'){
		echo 'Match Found'.' '.$walmart_prod.'||'.$amazon_product.'</br>'.'</br>';/*********Product Matched**********/
/*****************************Find Product on Amazon******************************************/
		$product_search = urlencode($amazon_product);
		$amazonurl = "http://www.amazon.com/s/ref=nb_sb_noss?url=search-alias%3Daps&field-keywords=".$product_search;
		$curl = curl_init(); 
		curl_setopt($curl,CURLOPT_URL, $amazonurl);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_COOKIESESSION, TRUE);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($curl,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
		curl_setopt($curl, CURLOPT_REFERER, 'http://www.walmart.com');
		curl_setopt($curl,CURLOPT_HEADER, false); 
		$amz1=curl_exec($curl);
		$amazon1->load($amz1);
		$h2 = $amazon1->find('h2[class="a-size-medium a-color-null s-inline s-access-title a-text-normal"]');
		$productsz1 = sizeof($h2);
		if($productsz1 == 0){
			$h2 = $amazon1->find('h2[class="a-size-base a-color-null s-inline s-access-title a-text-normal"]');
			$productsz1 = sizeof($h2);
		}
		//echo $productsz1.' '.'products found on amazon'.'</br>';
		$amazon_products1 = array();
		for($prod1=0; $prod1 < $productsz1; $prod1++){
			$amazon_products1[$prod1] = $h2[$prod1]->plaintext;/****Amazon product array for matched product*****/
			////echo $amazon_products1[$prod1].'</br>';
		}
/*****************************Comparision algorithm*******************************************/
/*****************************Find Product on Amazon******************************************/	
		$amazon_product_match = amazon_compare($amazon_product, $amazon_products1);
		if($amazon_product_match[0] != '0'){
			//echo 'Match Found'.' '.$amazon_product.'||'.$amazon_product_match[0].'</br>'.'</br>';
			$index = (int)$amazon_product_match[1]; 
			//echo $index.'</br>';
			$productlist = $amazon1->find('li[class="s-result-item"]');
			$producta = $productlist[$index]->find('a');
/*****************************Scrap Amazon Product Attributes**********************************/
			$amazon_match_url = $producta[0]->href;/*******************Amazon Product URL******/
			preg_match("@/dp/(.*)/ref@", $amazon_match_url, $match);
			$asinurl = $match[1];/*************************************Asin********************/
			//echo $amazon_match_url.'</br>';
			$curl = curl_init(); 
			curl_setopt($curl,CURLOPT_URL, $amazon_match_url);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($curl, CURLOPT_COOKIESESSION, TRUE);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
			curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
			curl_setopt($curl,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
			curl_setopt($curl, CURLOPT_REFERER, 'http://www.amazon.com');
			curl_setopt($curl,CURLOPT_HEADER, false); 
			$amz2=curl_exec($curl);
			$amazon2->load($amz2);
			$pricespan = $amazon2->find('span[id="priceblock_ourprice"]');
			$amzprice = $pricespan[0]->plaintext;
			//echo $amzprice.'</br>';
			$stockdiv = $amazon2->find('div[id="availability"]');
			if(sizeof($stockdiv) !=0){
				$amzstockstatus = trim($stockdiv[0]->children(0)->plaintext);/************Stock Status************/
				$pricedd = $amazon2->find('span[id="priceblock_saleprice"]');
				if(sizeof($pricedd) > 0)
					$amzstockstatus = 'In Stock';
			}			
			//echo $amzstockstatus.'</br>';
			//$asinrank = $amazon2->find('div[class="content"]');
			////echo $asinrank[0];
			$details = $amazon2->find('div[id=detail-bullets]');
			$c = sizeof($details);
			//if($c == 0)
				//$details = $amazon2->find('div[id=detailBullets_feature_div]');
			if($c != 0){
				$content = $details[0]->find('div[class="content"]');
				$ul = $content[0]->find('ul');
				$li = $ul[0]->find('li');
				$licount = sizeof($ul[0]->children());
				//echo $licount.'</br>';
				
				for($pd = 0; $pd < $licount; $pd++){
					//echo (string)$li[$pd]->plaintext.'</br>';
					$wspd = (string)$li[$pd]->plaintext;
					//$wspde = (string)$li[0]->plaintext;
					//$wspd = ltrim($wspd);
					$wspd = preg_replace('/\s+/', '', $wspd);
					preg_match("@ProductDimensions:(.*)@" , (string)$wspd, $pdm);
					if($pdm[1] != NULL){
						$product_d = $pdm[1];
						echo $product_d.' ';
					}
					preg_match("@ShippingWeight:(.*)\(@" , (string)$wspd, $sw);
					if($sw[1] != NULL){
						$shipping_w = $sw[1];
						echo $shipping_w.'</br>';
					}
				}		
				$rankli = $ul[0]->find('li[id=SalesRank]');
				$arank = explode('#' , $rankli[0]->plaintext);
				$prank = explode(' ' , $arank[1]);
				$rank = $prank[0];
				$spanew = $amazon2->find('span[class="olp-padding-right"]');
				$spanhref = $spanew[0]->children[0]->href;
				echo $spanhref.'</br>';
				$sno = $spanew[0]->children[0]->plaintext;
				preg_match("@(.*)&nbsp;@", $sno, $supplier_num);
				$suppliers_num = $supplier_num[1];
				$nhref = 'http://www.amazon.com'.$spanhref;
				echo $nhref.'</br>';
				/*$sup = $spanew[0]->children[0]->plaintext;
				preg_match("@(.*)&nbsp;new@" , (string)$sup, $supnum);
				$suppliers = (int)$supnum[1];
				var_dump($nhref).'</br>';
				echo $suppliers.'</br>';*/
/********************************Offer Listing**************************************************************/
				$curl = curl_init(); 
				curl_setopt($curl,CURLOPT_URL, $nhref);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($curl, CURLOPT_COOKIESESSION, FALSE);
				curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
				curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
				curl_setopt($curl,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
				curl_setopt($curl, CURLOPT_REFERER, 'http://www.google.com');
				curl_setopt($curl,CURLOPT_HEADER, false); 
				$amz3=curl_exec($curl);
				$amazon3->load($amz3);
				//echo $amz3;
				$suppliers = $amazon3->find('div[class="a-row a-spacing-mini"]');
				$offers = $amazon3->find('span[class="a-size-large a-color-price olpOfferPrice a-text-bold"]');
				$seller_new = $amazon3->find('h3[class="a-spacing-small olpCondition"]');
				$seller_name = $amazon3->find('p[class="a-spacing-mini olpSellerName"]');
				//$seller_cname = $seller_name->children[0];
				//echo sizeof($offers).'</br>';
				//echo sizeof($seller_new).'</br>';
				//echo sizeof($seller_name).'</br>';
				$psuppliers = sizeof($offers);
				$amzurl = 'http://ecx.images-amazon.com/images/I/01dXM-J1oeL.gif';
				$arrnonfba = array();
				$arrfba = array();
				$nonfba = 0;
				$fbaindex = 0;
				$amazonsellery = 0;
				for($asup = 0; $asup < $psuppliers; $asup++){
					$noo = $seller_new[$asup]->plaintext;
					$noo = preg_replace('/\s+/', '', $noo);
					$seller_cname = $seller_name[$asup]->children[0];
					//echo $seller_cname;
					$ehref = $seller_cname->children[0];
					//echo $ehref->href.'</br>';
					//echo $noo.'</br>';
					if($noo == "New"){
						echo $offers[$asup]->plaintext.' ';
						echo $ehref->src.'</br>';
						$isseller = $ehref->src;
						$offerprice = $offers[$asup]->plaintext;
					
				if(strcmp($isseller,'http://ecx.images-amazon.com/images/I/01dXM-J1oeL.gif' ) == 0){
					$amazonsellery = 1;
				}
				echo $amazonseller.'</br>';
				//$fba = $suppliers[$asup]->find('a[class="a-popover-trigger a-declarative olpFbaPopoverTrigger"]');
				$fba = preg_match("@a-popover-trigger a-declarative olpFbaPopoverTrigger@", $suppliers[$asup]->innertext, $match);
				if($fba == 0){
					$isfba = No;
					$arrnonfba[$nonfba] = $offerprice;
					$nonfba++;
				}
				else{
					$isfba = Yes;
					$arrfba[$fbaindex] = $offerprice;
					$fbaindex++;
				}
				}
								
				}
				if($amazonsellery == 0)
					$amazonseller = 'No';
				else
					$amazonseller = 'Yes';
				echo "Amazon Seller ". $amazonseller.'</br>';
				echo $arrnonfba[0].'</br>';
				echo $arrfba[0].'</br>';	
				
				
/********************************Offer Listing**************************************************************/
				}	
			}
/*****************************Scrap Amazon Product Attributes**********************************/			
			
		
/*****************************Find Product on Amazon******************************************/
		}
		else{
			//echo 'Match Not Found'.'</br>'.'</br>';
			continue;
		}	
/*****************************Comparision algorithm*******************************************/	
/*****************************Write Excel*****************************************************/
			$row = $spreadsheet->getActiveSheet()->getHighestRow()+1;
			$worksheet->SetCellValueByColumnAndRow(0, $row, $walmart_products[$k][0]);
			$worksheet->SetCellValueByColumnAndRow(1, $row, $walmart_products[$k][3]);
			$worksheet->SetCellValueByColumnAndRow(2, $row, $walmart_products[$k][1]);
			$worksheet->SetCellValueByColumnAndRow(3, $row, $walmart_products[$k][2]);
			$worksheet->SetCellValueByColumnAndRow(4, $row, $amazon_product);
			$worksheet->SetCellValueByColumnAndRow(5, $row, $amazon_match_url);
			$worksheet->SetCellValueByColumnAndRow(6, $row, $amzprice);
			$worksheet->SetCellValueByColumnAndRow(7, $row, $amzstockstatus);
			$worksheet->SetCellValueByColumnAndRow(8, $row, $asinurl);
			$worksheet->SetCellValueByColumnAndRow(9, $row, $rank);
			$worksheet->SetCellValueByColumnAndRow(10, $row, $amazonseller);
			$worksheet->SetCellValueByColumnAndRow(11, $row, $shipping_w);
			$worksheet->SetCellValueByColumnAndRow(12, $row, $product_d);
			$worksheet->SetCellValueByColumnAndRow(13, $row, $arrfba[0]);
			$worksheet->SetCellValueByColumnAndRow(14, $row, $arrnonfba[0]);
			$worksheet->SetCellValueByColumnAndRow(15, $row, $suppliers_num);
			$rank = ' ';
			$shipping_w = ' ';
			$product_d = ' ';
			$arrnonfba[0] = ' ';
			$suppliers_num = ' ';
/*****************************Write Excel*****************************************************/
}	
			$writer->save('Amazon_walmart_products.xlsx');	
unset($amz);
unset($amz1);
unset($phtml);	
unset($html);
		
?>	