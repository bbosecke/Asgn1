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

<p><a href="http://192.168.2.13/admin.php">Go to admin</a></p>

<p>To register, please enter your ID and your name, and if you prefer to ski or snowboard and press submit</p>

<form action="index.php" method="post">
<p>
<label for="id">ID:</label>
<input type="text" name="idNum" id="id">
</p>
<p>
<label for="name">Name:</label>
<input type="text" name="named" id="name">
</p>
<p>
<label for="sport">Skiing or Snowboarding:</label>
<input type="text" name="sports" id="sport">
</p>
<input type="submit" value="Submit">
</form>

<?php

$db_host   = '192.168.2.12';
$db_name   = 'contestants';
$db_user   = 'webuser';
$db_passwd = 'insecure_db_pw';

$pdo_dsn = "mysql:host=$db_host;dbname=$db_name";

$pdo = new PDO($pdo_dsn, $db_user, $db_passwd);

$q = $pdo->query("SELECT * FROM myPass");


?>


<?php
$link = mysqli_connect($db_host, $db_user, $db_passwd, $db_name);

// Check connection
if($link === false){
die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Escape user inputs for security
$idNum = mysqli_real_escape_string($link, $_REQUEST['idNum']);
$named = mysqli_real_escape_string($link, $_REQUEST['named']);
$sports = mysqli_real_escape_string($link, $_REQUEST['sports']);


// Attempt insert query execution
$sql = "INSERT INTO myPass (id,name,runs,preferredSport) VALUES ('$idNum','$named', '0', '$sports')";
if(mysqli_query($link, $sql)){
echo "Records added successfully.";
} else{
echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}


// Close connection
mysqli_close($link);





?>
</table>
</body>
</html>