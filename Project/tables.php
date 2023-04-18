<html>

<?php

ini_set('display_errors', 1);

session_start();
$name = $_SESSION["name"];
$password = $_SESSION["password"];
$host = $_SESSION["host"];

$bdd = new PDO('mysql:host='.$host.';dbname=group34;charset=utf8', $name, $password);

$result = $bdd->query("show tables");
while($table = $result ->fetch())
	echo($table[0]. "<BR>");


?>








<!--liste deroulante -->


<form method="post" action="tables.php">
<p>
<!-- une balise select ou input ne peut pas être imbriquee directement dans form -->
     <select name="table">
          <option value="Article">Articles</option>
          <option value="article_conference">Articles de conference</option>
          <option value="article_journal">Articles de journal</option>
          <option value="auteurs">Auteurs</option>
		  <option value="conference">Conferences</option>
          <option value="institutions">Institutions</option>
          <option value="participation_conference">Participation aux conferences</option>
          <option value="revue">Revues</option>
		  <option value="seconds_auteurs">Seconds auteurs</option>
		  <option value="sujets_article">Sujets d'article</option>
     </select>

     <input type="submit" value="Go" title="valider" />

</p>
</form>


<?php

if(isset($_POST['table'])){
$ma_table = $_POST['table'];

echo " Selectionnez les champs de ".$ma_table." :";
echo "<BR>";

echo "show columns FROM ".$ma_table.';';

$result = $bdd->query("show columns FROM ".$ma_table.';');

echo "<form action='#' method='post'>";
while($table = $result ->fetch())
	echo '<input type="checkbox" name="check_list[]" value='.$table[0].'><label>'.$table[0].'</label><br/>';
?>	
	<input type="submit" name="submit" value="Submit"/>
</form>
<?php

//$result->closeCursor(); // Termine le traitement de la requête

}


if(isset($_POST['submit'])){//to run PHP script on submit
	if(!empty($_POST['check_list'])){
		// Loop to store and display values of individual checked checkbox.
		foreach($_POST['check_list'] as $selected){
			echo $selected."</br>";
		}
	}
}

?>

</html>