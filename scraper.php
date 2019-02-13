<?php
ini_set('max_execution_time', 30000); // increase the execution time

$servername = "localhost";
$username = "XXX";
$password = "XXX";
$dbname = "XXXX";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$xml=simplexml_load_file("fb-sitemap-6.xml") or die("Error: Cannot create object");

for ($j=0; $j <count($xml) ; $j+=500) {
  $main = '';
  $counter = $j;
  for ($i=$counter; $i <$counter+500 ; $i++) {
    $url =  $xml->url[$i]->loc[0];
    $url = substr($url,8);
    $main = $main . '("' . $url . '"),';
  }
  $main = substr($main,0,-1);
  $sql = "INSERT INTO scrapinglist (url) VALUES $main";

  if ($conn->query($sql) === TRUE) {
      echo "New record upto ". $j ." created successfully";
      echo "<br><br>";
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
      echo "<br><br>";
  }
$j = $counter;

}

$conn->close();
 ?>
