<html> 
<head>
  <title>Updating</title>
  <link rel="stylesheet" type="text/css" href="sample.css">
</head> 
<body>
	<?php 
	$arr = array(); 
	//take in all data in variables 
	$name = $_POST['product_name'];
	array_push($arr, $name); 
	$description = $_POST['product_description'];
	array_push($arr, $description); 
	$id = $_POST['product_id'];
	array_push($arr, $id); 
	$cost = $_POST['product_cost'];
	array_push($arr, $cost); 
	$qty = $_POST['product_quantity'];
	array_push($arr, $qty); 
	// check if data is valid
	//check something was entered
	foreach ($arr as $input)
	{
		if(empty($input) && $input !== '0' )
		{
			echo "You left a field blank. Please click "; 
			echo '<a href="updateInfo.html">here</a>';
			echo " to go back."; 
			exit(); 
		 }		
	}
	if (!ctype_alpha(str_replace(' ','',$name)) || !ctype_alpha(str_replace(' ','',$description)))
		{
			echo "You are only allowed to enter characters in the product name "; 
			echo "<br>"; 
			echo "and product description fields. Please click "; 
			echo '<a href="updateInfo.html">here</a>';
			echo " to go back."; 
			exit(); 
			
		}
	elseif($qty<0)
		{
			echo "Product quantity must be 0 or greater."; 
			echo "<br>"; 
			echo "Please click "; 
			echo '<a href="updateInfo.html">here</a>';
			echo " to go back."; 
			exit(); 
		}
	else //the input is valid
		{
			// write to text file productInfo.txt
			// trim not working, so 
			$data = implode(":", $arr); 
			$f_data = str_replace(' ','',$data); 
			$file = 'productInfo.txt'; 
			$fsize = filesize('productInfo.txt'); 
		}

			// if file is empty, write to txt file normally
	if ($fsize==0){ 

        $file = fopen($file, 'a') or die("File Cannot Be Accessed!");
      	fwrite($file, $f_data); 
     	fclose($file);
     	echo  "The product information has been added! ";
     }
     else //if file is not empty
     {
 		$s_file = file_get_contents('productInfo.txt');
        $s_arr = explode("\n",$s_file); 
     	$f_arr = explode("\n",$f_data); 
     	$all_arr = array_merge($s_arr, $f_arr); 
     	asort($all_arr,SORT_STRING); 
     	//print_r($all_arr);
     	$all_str =  implode("\n", $all_arr); 
     	$file = fopen('productInfo.txt', 'w') or die("File Cannot Be Accessed!");
     	//$write_data = "\n" . $f_data; 
      	
      	fwrite($file, $all_str); 
     	echo  "The product has been added!";
     	//generates table 
  		$string_data = file_get_contents('productInfo.txt'); 
  		$array_data = explode("\n", $string_data); 
  		asort($array_data,SORT_STRING); 

  		echo '<table border="1">';
 		 echo '<caption>Product Information Table</caption>'; 
  		foreach ($array_data as $key => $val) {
   		 echo "<tr>";
   		 echo "<td>"  . ++$key . "</td>\n<td>" . $val . "</td>";
            echo "</tr>";

		}
		  echo "</table>";
     }
	?>

</body>
</html>