<html>
<head>
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

<table>
  <tr>
    <th>Date</th>
    <th>Additions</th>
    <th>Deletions</th>
  </tr>

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

$count = $link->prepare("SELECT COUNT(id) AS counted FROM users");
$count->execute();
$count_final = $count->fetchAll(\PDO::FETCH_ASSOC);

$i = 0;
$o = 1;
$rows = $count_final[0]["counted"];

//if(!empty($_GET["username"] && $_GET["repository"])){
    $user = $_GET["username"];
    $repository = $_GET["repository"];
    $client_id_hash = ""; //Github Client ID Hash
    $client_secret_hash = ""; //Github Client Secret Hash

    echo '<a href="index.php">Back to dashboard</a>';

    while ($o <= $rows) {
        //$user_req = $link->prepare("SELECT user FROM users WHERE id = $o");
        //$user_req->execute();
        //$username = $user_req->fetchAll(\PDO::FETCH_ASSOC);

        //$repo_req = $link->prepare("SELECT repository FROM users WHERE id = $o");
        //$repo_req->execute();
        //$repository = $repo_req->fetchAll(\PDO::FETCH_ASSOC);

        //$url = "https://api.github.com/repos/".$username[0]['user']."/".$repository[0]['repository']."/stats/code_frequency";

        $url = "https://api.github.com/repos/".$user."/".$repository."/stats/code_frequency?client_id=".$client_id_hash."&client_secret=".$client_secret_hash."";

        //  Initiate curl
        $ch = curl_init();
        // Set the url
        curl_setopt($ch, CURLOPT_URL,$url);
        // Set useragent
        curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
        // Disable SSL verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if (curl_errno($ch)) { 
           print curl_error($ch); 
        } 
        // Execute
        $result=curl_exec($ch);
        // Closing
        curl_close($ch);

        // JSON dump
        //var_dump(json_decode($result, true));

        $arr = json_decode($result, true);
        //$user = $username[0]["user"];

        foreach ($arr as &$value) {
            $timestamp = explode(10,$value[0]);
            $additions = explode(10, $value[1]);
            $deletions = explode(10, $value[2]);
            $date_final = date('d-M-y', $timestamp[0]);

            echo "<tr>";
            echo "<td>".$date_final."</td>";
            echo "<td>Additions: ".$additions[0]."</td>";
            echo "<td>".$deletions[0]."</td>";
            echo "</tr>";


            //$user_check_and_insert_sql = $link->prepare("IF NOT EXISTS ( SELECT * FROM weekly WHERE week = $time)
            //	BEGIN
            //   INSERT INTO weekly (name, week) VALUES ($user, $time)
            //	END");

        	//$user_check_and_insert_sql->execute();

        	$i++;
        }
      $o++;
    }

//} else {
//    echo "Error, no data submitted";
//}

?>

</body>
</html>