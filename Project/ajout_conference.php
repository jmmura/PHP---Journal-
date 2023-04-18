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

<form action="ajout_conference.php" method="post">
	 <p>Veuillez entrer le titre du nouvel article : <input type="text" name="titre" /></p>
	 <p>URL : <input type ="text" name="url" /></p>
	 <p>DOI : <input type ="number" name="doi" /></p>
	 <p>Date de publication : <input type ="text" name="date" /></p>
	 <p>Le matricule de l'auteur de l'article : <input type="number" name="matricule" /></p>
		 <p>type de présentation : <input type ="text" name="presentation" /></p>
		 <p>nom de la conférence : <input type ="text" name="nom_conf" /></p>
		 <p>année de la conférence : <input type ="year" name="annee_conf" /></p>
	 <p><input type="submit" name='continuer2' value="OK"></p>
	</form>

	<?php
	if (isset($_POST['continuer2'])){
		$titre = $_POST['titre'];
		$url = $_POST['url'];
		$doi = $_POST['doi'];
		$date = $_POST['date'];
		$mat = $_POST['matricule'];
		$presentation = $_POST['presentation'];
		$nom_conf = $_POST['nom_conf'];
		$annee_conf = $_POST['annee_conf'];
		
		$sql ="INSERT into Article values(\"".$url."\", \"".$doi."\", \"".$titre."\", \"".$date."\", \"".$mat."\")";
		echo $sql;
		if (! $bdd->query($sql))
			echo "<span style='color:red;'> L'article que vous tentez d'ajouter se trouve déjà dans la base de donnée</span>";

		$sql ="INSERT into Article_Conférence values(\"".$url."\", \"".$presentation."\", \"".$nom_conf."\", \"".$annee_conf."\")";
		echo $sql;
		if (! $bdd->query($sql))
			echo "<span style='color:red;'> La conférence n'est pas valide</span>";
	}
	?>

</html>