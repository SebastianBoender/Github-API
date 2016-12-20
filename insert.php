<?php

try {
  $dbhost = "127.0.0.1";
  $dbname = "";
  $dbusername = "";
  $dbpassword = "";

  $link = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbusername,$dbpassword);
} catch (PDOException $e) {
  print $e->getMessage();
}

//if(!empty($_POST["username"] && $_POST["repository"])){
if (isset($_POST["username"]) && !empty($_POST["username"])) {
	$user = $_POST["username"];
	$repository = $_POST["repository"];
  $studenten = $_POST["students"];

	$sql = $link->prepare("INSERT INTO users(user, repository, students) VALUES(:user, :repository, :students)");
	
	$sql->execute(array(
              ':user' => $user,
              ':repository' => $repository,
              ':students' => $studenten
            ));

echo '<meta http-equiv="refresh" content="0; url=http://mymonthlydeal.com/">';

} else {
  echo "Error, no data submitted";
}
//} else {
//	echo "Error, no data submitted";
//}

?>
