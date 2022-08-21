<?php
//takes input from user
  // test which type of hash code
   $hash = $_POST["hash"];
   $hashtype = "null";
   if (preg_match("/\b([a-f0-9]{40})\b/", $hash)){
       $hashtype = "sha1";}
   elseif (preg_match("/\b([a-f0-9]{56})\b/", $hash)){
       $hashtype = "sha224";}
   elseif (preg_match("/\b([a-f0-9]{64})\b/", $hash)){
       $hashtype = "sha256";} 

   if ($hashtype !== "null"){ 
      // opens appropriate file to search
       $file = fopen($hashtype."_list.txt","r");
        $arr = array(); 
        // loads info from text file
        while(! feof($file)) { 
           $result = fgets($file); 
           // for easy checking
           $line = substr($result, 0, strlen($result)-1); 
           // end of file
           if(strlen($line) === 0){ 
               break; 
             }

           $file_arr = explode (":", $line); 
           //to use hash value as key 
           $arr[$file_arr[1]] = $file_arr[0]; 
       }fclose($file); 
       if (array_key_exists($hash, $arr)){ 
        print("Hash value that was searched for: ". $hash); 
        echo "<br>"; 
        $string_gen = $arr[$hash];
        print("String that generated this hash value: ".$string_gen);  
      }
      else 
      {
        echo "the value could not be found in the server’s records.";

      }
    }
?>

<!DOCTYPE html>
<html>
<head>
   <title>SHA</title>
</head>
<body>
  <br>
  <br>
    <p>
      <form action = "sha.php" method = "post" > 
        <p> SHA Hash Value:
      <input type="text" name="hash">
       </p>
       <input type="Submit" value="Search Again">
    </form>
  </p>
</body>
</html>   