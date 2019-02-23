<?php        

//print_r($structure[0]["values"]);
echo"<hr>";
if(@$search_string=$_REQUEST["search"]) {
	echo "<h3>Search=".$search_string."</h3>";
	//print_r($structure[0]["values"]);




	//echo"<hr>$search_string";

	//$filterArray = array_filter($data,$search_string);
	
	 $filterArray = array_filter($data, function ($var) use($search_string)  { 
	    //return (strpos($var, trim($search_string)) ==false);
//	    return preg_match("/\b$search_string\b/iu", $var);  //does not return greek results
		if (strpos($var, $search_string) !== false) {
		    return 'true';
		}
		return false;
	    //return preg_match("/\b$search_string\b/i", $var);
	    //return (strpos($var, trim($search_string)) ===false);
	}); 

	echo "<h3>".implode("<br>",$filterArray)."</h3>";

	echo"<hr>";
}
	//print_r($filterArray);
	$search_menu="";
	foreach ($structure[0]["values"] as  $key => $value) {

		if($value!="") $search_menu.="<a href=index.php?search=$value> $value</a>|";
	}

	echo "SEARCH: <h3>".$search_menu."</h3>";
//echo implode("<br>",$data);
?>