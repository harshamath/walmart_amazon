<?php

function read_file($filename){
    $buffer = array();
	$lines = file($filename);
	foreach($lines as $line_num => $line)
	{
		$buffer[] = $line;
	}
    return $buffer;
}

?>