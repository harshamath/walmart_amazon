<?php 

error_reporting(E_ALL);
ini_set('display_errors', true);

$array1 = array(
'Faded Glory Men s Cargo Short'
);

$array2 = array(
'Faded Glory Mens Pull-On Shorts',
'Harley-Davidson Mens Faded Glory Boot',
'Aerosmith - Mens Faded Wings T-Shirt',
'Faded Glory Mens USA American Flag Board Shorts Swimwear',
'12 Pairs New Black/Gray Mens Work Hunting Boot Socks Shoe Size 6-12 Outdoor',
'NEW! Mens Work Hunting Boot Outdoor Red & Gray Socks Shoe Size 6-12 | 24 Pairs',
'Faded Lime Green Adult T-Shirt',
'Men s Belt',
'Faded Glory Canvas Men s Shoe Size USA 9, Washed Navy',
'Faded Glory Unisex Boot Socks, 4 Pairs Pack',
'XIAXIAN Men s Summer Fashion Breathable Grenadine Casual Shoes',
'Harley-Davidson Men s Faded Glory 8-Inch Motorycle Black Boots D91003',
'NCAA Men s Georgia Bulldogs Faded Glory Pullover Sandblasted Hooded Fleece',
'2 Pairs Mens Work Hunting Boot Outdoor Socks Shoe Size 6-12',
'2 Pairs New Black/Gray Mens Work Hunting Boot Outdoor Socks Shoe Size 6-12',
'NCAA Men s Lsu Tigers Faded Glory Pullover Sandblasted Hooded Fleece'
);
$size1 = sizeof($array1);
$size2 = sizeof($array2);
$product_match_status = array();
for($sz =0; $sz < $size1; $sz++){

	for($z =0; $z < $size2; $z++){
		//echo $array1[$sz].' '.'||'.' '.$array2[$z].' '.'->';

		$compare_status = compareStrings($array1[$sz], $array2[$z]);
		$product_match_status[$z] = array($array1[$sz], $array2[$z], $compare_status[0], $compare_status[1]);
		//echo $product_match_status[$z][0].'||';
		//echo $product_match_status[$z][1].' '.'</br>';
		//echo $product_match_status[$z][2].' ';
		//echo $product_match_status[$z][3].' '.'</br>';
	}
}	
	$ar1 = preg_replace("/[^A-Za-z0-9]/", ' ', $array1[0]);
	$ar1 = preg_replace('/\s+/', ' ', $ar1);
	echo $ar1.'</br>';
	$ar1 = explode(" ", $ar1);
	echo $ar1[4].'</br>';
	$word_count = count($ar1);
	echo 'Word Count ->'.$word_count.'</br>';
	$found_match = 0;
	for($psize=0; $psize < count($product_match_status); $psize++){
		echo $product_match_status[$psize][0].'||';
		echo $product_match_status[$psize][1].' '.'</br>';
		echo $product_match_status[$psize][2].' ';
		echo $product_match_status[$psize][3].' '.'</br>';
		if($product_match_status[$psize][2] == 0 && $product_match_status[$psize][3] == $word_count){
			$found_match = 1;
			echo "Match Found".'</br>';
			echo $product_match_status[$psize][0].'||';
			echo $product_match_status[$psize][1].' '.'</br>';
			break;
		}	
	}
	for($psize=0; $psize < count($product_match_status); $psize++){
		echo $product_match_status[$psize][0].'||';
		echo $product_match_status[$psize][1].' '.'</br>';
		echo $product_match_status[$psize][2].' ';
		echo $product_match_status[$psize][3].' '.'</br>';
		if($product_match_status[$psize][2] == 0 && $product_match_status[$psize][3] == $word_count-1){
			$found_match = 1;
			echo "Match Found".'</br>';
			echo $product_match_status[$psize][0].'||';
			echo $product_match_status[$psize][1].' '.'</br>';
			break;
		}	
	}
	for($psize=0; $psize < count($product_match_status); $psize++){
		echo $product_match_status[$psize][0].'||';
		echo $product_match_status[$psize][1].' '.'</br>';
		echo $product_match_status[$psize][2].' ';
		echo $product_match_status[$psize][3].' '.'</br>';
		if($product_match_status[$psize][2] == 0 && $product_match_status[$psize][3] == $word_count-2){
			$found_match = 1;
			echo "Match Found".'</br>';
			echo $product_match_status[$psize][0].'||';
			echo $product_match_status[$psize][1].' '.'</br>';
			break;
		}	
	}
	if($found_match == 0){
	for($psize=0; $psize < count($product_match_status); $psize++){
		echo $product_match_status[$psize][0].'||';
		echo $product_match_status[$psize][1].' '.'</br>';
		echo $product_match_status[$psize][2].' ';
		echo $product_match_status[$psize][3].' '.'</br>';
		if($product_match_status[$psize][2] == -1 && $product_match_status[$psize][3] == $word_count){
			$found_match = 1;
			echo "Match Found".'</br>';
			echo $product_match_status[$psize][0].'||';
			echo $product_match_status[$psize][1].' '.'</br>';
			break;
		}	
	}
	}
	if($found_match == 0){
	for($psize=0; $psize < count($product_match_status); $psize++){
		echo $product_match_status[$psize][0].'||';
		echo $product_match_status[$psize][1].' '.'</br>';
		echo $product_match_status[$psize][2].' ';
		echo $product_match_status[$psize][3].' '.'</br>';
		if($product_match_status[$psize][2] == 1 && $product_match_status[$psize][3] == $word_count-1){
			$found_match = 1;
			echo "Match Found".'</br>';
			echo $product_match_status[$psize][0].'||';
			echo $product_match_status[$psize][1].' '.'</br>';
			break;
		}	
	}
	}
	if($found_match == 0){
	for($psize=0; $psize < count($product_match_status); $psize++){
		echo $product_match_status[$psize][0].'||';
		echo $product_match_status[$psize][1].' '.'</br>';
		echo $product_match_status[$psize][2].' ';
		echo $product_match_status[$psize][3].' '.'</br>';
		if($product_match_status[$psize][2] == -1 && $product_match_status[$psize][3] == $word_count-1){
			$found_match = 1;
			echo "Match Found".'</br>';
			echo $product_match_status[$psize][0].'||';
			echo $product_match_status[$psize][1].' '.'</br>';
			break;
		}	
	}
	}
	if($found_match == 0){
	for($psize=0; $psize < count($product_match_status); $psize++){
		echo $product_match_status[$psize][0].'||';
		echo $product_match_status[$psize][1].' '.'</br>';
		echo $product_match_status[$psize][2].' ';
		echo $product_match_status[$psize][3].' '.'</br>';
		if($product_match_status[$psize][2] == 1 && $product_match_status[$psize][3] == $word_count-2){
			$found_match = 1;
			echo "Match Found".'</br>';
			echo $product_match_status[$psize][0].'||';
			echo $product_match_status[$psize][1].' '.'</br>';
			break;
		}	
	}
	}
	if($found_match == 0){
	for($psize=0; $psize < count($product_match_status); $psize++){
		echo $product_match_status[$psize][0].'||';
		echo $product_match_status[$psize][1].' '.'</br>';
		echo $product_match_status[$psize][2].' ';
		echo $product_match_status[$psize][3].' '.'</br>';
		if($product_match_status[$psize][2] == -1 && $product_match_status[$psize][3] == $word_count-2){
			$found_match = 1;
			echo "Match Found".'</br>';
			echo $product_match_status[$psize][0].'||';
			echo $product_match_status[$psize][1].' '.'</br>';
			break;
		}	
	}
	}
	if($found_match == 0){
		echo 'Match Not Found';
	}

function compareStrings($s1, $s2) {

    if (strlen($s1)==0 || strlen($s2)==0) {
        return 0;
    }
	$s1 = preg_replace("/[^A-Za-z0-9]/", ' ', $s1);
    $s2 = preg_replace("/[^A-Za-z0-9]/", ' ', $s2);
	while (strpos($s1, "  ")!==false) {
        $s1 = str_replace("  ", " ", $s1);
    }
    while (strpos($s2, "  ")!==false) {
        $s2 = str_replace("  ", " ", $s2);
    }
	//echo $s1.'</br>';
	//echo $s2.'</br>';
    $ar1 = explode(" ",$s1);
    $ar2 = explode(" ",$s2);
  //  $array1 = array_flip($ar1);
  //  $array2 = array_flip($ar2);
    $l1 = count($ar1);
    $l2 = count($ar2);

 
    $compare=0;
	$hundred=0;
	$pcompare = array();
	for($lar1=0; $lar1<count($ar1); $lar1++){
			$ar1[$lar1] = strtolower($ar1[$lar1]);
	}
	for($lar2=0; $lar2<count($ar2); $lar2++){
			$ar2[$lar2] = strtolower($ar2[$lar2]);
	}
	//echo count($ar1).'</br>';
	$compare_status = array();
    for ($i=0; $i < count($ar1); $i++) {
		for ($j=0;$j<count($ar2);$j++){
			similar_text($ar1[$i],$ar2[$j],$wpercent);
			//echo $ar1[$i].' '.$ar2[$j].' '.$wpercent.'</br>';
			if($j == 0)
				$pcompare[$i] = $wpercent;
			if($wpercent > $pcompare[$i]) {
				$pcompare[$i]=$wpercent;
			}
			if($wpercent > 80){
				$hundred++;
				break;
			}
		}
		//echo $pcompare[$i].' ';	
    }
	if($l1 == $l2)
		$numwords = 0;
	if($l1 < $l2)
		$numwords = -1;
	if($l1 > $l2)
		$numwords = 1;
	//echo $hundred;
	$compare_status[0] = $numwords;
	$compare_status[1] = $hundred;
	return $compare_status;
}

?>