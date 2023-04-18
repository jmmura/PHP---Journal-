<html>

<?php
// include 'verify_cookie.php';
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=group34;charset=utf8', 'root', '');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
?>

<h2> Ajouter un article dans la base de donnée</h2>

  <form action="ajout_articles.php" method="post">
 <p> Cochez le type d'article à ajouter:</p>
 <input type="radio" name="type" value ="conference"> Conférence <br/>
 <input type="radio" name="type" value ="journal"> Journal <br/>
 <p><input type="submit" name='continuer' value="OK"></p>
</form>

<?php
$conference = FALSE;
$journal =false;

if(isset($_POST['continuer'])){
	if($_POST['type'] == 'conference')
		header('Location: ajout_conference.php');
	else 
		$journal = true;
}
?>


</html>