<!DOCTYPE html>
<html>
<body>

 <?php 
$name = $_POST["name"]; 
$password = $_POST["password"];
$host;
if(ISSET($_POST["local"]))
    $host = "localhost";
else
    $host = "ms800.montefiore.ulg.ac.be";
try
{
    $bdd = new PDO('mysql:host='.$host.';dbname=;charset=utf8', $name, $password);
}catch(\PDOException $e){
    echo "Wrong login ";
    echo "<a href='../index.html'>GO BACK</a>";
    exit();
}

session_start();
$_SESSION["name"] = $name;
$_SESSION["password"] = $password;
$_SESSION["host"] = $host;
header('Location: ../script.php');
	

?>

</body>
</html>
