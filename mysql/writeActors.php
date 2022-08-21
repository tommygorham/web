<!DOCTYPE html>
<head>
    <title>Task1</title>
</head>
<body>
    <h1>Movies That Actors Starred In</h1>
    <?php
    $server = "localhost";
    $user = "root";
    $pw = "";
    $db = "sakila";

    // connection

  $connect = mysqli_connect($server, $user, $pw, $db);
    if( !$connect)
    {
        die("ERROR: Cannot connect to database $db on server $server
            using user name $user (".mysqli_connect_errno().
        ", ".mysqli_connect_error().")");
    }
    // queries

$q = "SELECT concat(a.last_name, ', ',a.first_name) as Actor, count(fa.actor_id) as Num_Films,GROUP_CONCAT(f.title) AS 'films'
FROM actor as a
INNER JOIN film_actor fa ON a.actor_id = fa.actor_id
INNER JOIN film AS f ON f.film_id = fa.film_id
GROUP BY fa.actor_id
ORDER BY a.last_name;";


$q1 = "SELECT concat(a.last_name, ', ',a.first_name) as Actor, count(fa.actor_id) as Num_Films,GROUP_CONCAT(f.title) AS 'films'
FROM actor as a
INNER JOIN film_actor fa ON a.actor_id = fa.actor_id
INNER JOIN film AS f ON f.film_id = fa.film_id
GROUP BY fa.actor_id
ORDER BY a.last_name;";

$qresult = mysqli_query($connect, $q);
$q1result = mysqli_query($connect, $q1);

// testing connection, pulled from chapter slides
if (!$q1result) {
    die("Could not successfully run query ($q1) from $db: " .
        mysqli_error($connect) );}
if (mysqli_num_rows($q1result) == 0) {
    print("No records found with query $q1");
}else{ 

   // write to text 

    $wFile = 'actors.txt';
    $wOpen = fopen($wFile, 'a') or die("File Cannot Be Accessed!");
    while ($temp_var = mysqli_fetch_assoc($qresult)){
    $line = mysqli_fetch_assoc($qresult); 
    foreach ($line as $index => $string) {
            fwrite($wOpen,$string.':');
    }
      $linebreak = "\n";
      fwrite($wOpen, $linebreak); 
}
   
// html table construction
$temp = true;
print("<table border = 1>");
    while ($row = mysqli_fetch_assoc($q1result)){
        if ($temp) { $temp = false;
            print("<tr>");
            foreach($row as $key=>$value) {
                print("<th>$key</th>");}
            }
        print("<tr>");
        foreach($row as $key=>$value) {
            print("<td>$value</td>");  }
    }
}
mysqli_close($connect);
?>
</body>
</html>