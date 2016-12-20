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
	$sql = $link->prepare("SELECT * FROM users");	
	$sql->execute();
	$user_list = $sql->fetchAll(\PDO::FETCH_ASSOC);
?>

<html>
<head>
<title>GithubAPI</title>

<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
</head>
<body>
<form action="insert.php" method="post">
<label>Github Username:</label><br/>
<input type="text" name="username" placeholder="Username" /><br/><br/>

<label>Repository:</label><br/>
<input type="text" name="repository" placeholder="Repository" /><br/><br/>

<label>Studenten in project (scheiden met komma):</label><br/>
<input type="text" name="students" placeholder="Studenten" /><br/><br/>

<input type="submit" value="submit" />
</form>

<br>

<table>
  <tr>
    <th>Gebruikersnaam</th>
    <th>Repository</th>
    <th>Studenten in project</th>
    <th>Statistieken</th>
  </tr>


<?php

foreach($user_list as $user):

echo "<tr>";
echo "<td>".$user['user']."</td>";
echo "<td>".$user['repository']."</td>";
echo "<td>".$user['students']."</td>";
echo '<td><a href="parse.php?username='.$user["user"].'&repository='.$user["repository"].'">View weekly commits</a><br><br></td>';
echo '</tr>';

endforeach;
?>

</body>
</html>