<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<html>
<head><title>Asgn1</title>
<style>
th { text-align: left; }

table, th, td {
border: 2px solid Aqua;
border-collapse: collapse;
}

th, td {
padding: 0.2em;
}
</style>
</head>

<body>
<h1>Welcome to BroMo mountain</h1>



<p>Eventually enter your myPass ID here and then show how many runs they have done</p>

<table border="1">
<tr><th>Name</th><th>ID</th></tr>

<?php

$db_host   = '192.168.2.12';
$db_name   = 'contestants';
$db_user   = 'webuser';
$db_passwd = 'insecure_db_pw';

$pdo_dsn = "mysql:host=$db_host;dbname=$db_name";

$pdo = new PDO($pdo_dsn, $db_user, $db_passwd);

$q = $pdo->query("SELECT * FROM myPass");

while($row = $q->fetch()){
echo "<tr><td>".$row["id"]."</td><td>".$row["name"]."</td></tr>\n";
}

?>
</table>
</body>
</html>