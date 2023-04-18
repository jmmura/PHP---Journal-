<html>

<?php
session_start();
$name = $_SESSION["name"];
$password = $_SESSION["password"];
$host = $_SESSION["host"];

$bdd = new PDO('mysql:host='.$host.';dbname=group34;charset=utf8', $name, $password);
?>


  <form action="publications.php" method="post">
 <p>Veuillez entrer le numéro de matricule du chercheur :</p>
 <p><input type="number" name="chercheur" /></p>
 <p><input type="submit" value="OK"></p>
</form>

<?php


 if(isset($_POST['chercheur'])){
	$mat = $_POST['chercheur'];
	echo $mat; 

	$response = $bdd->query("SELECT * FROM Article WHERE matricule_premier_auteur ='$mat' ORDER BY date_publication DESC");
	
?>	
	<table>
	<tr>
       <th>Matricule</th>
       <th>Titre</th>
	   <th>Type</th>
       <th>Date</th>
	   <th>Matricule seconds auteurs</th>
   </tr>
   
 <?php
 
 while ($donnees = $response->fetch())
{
	$url = $donnees['URL'];
   echo '<tr>';
       echo'<td>'.$donnees['matricule_premier_auteur'].'</td>';
       echo'<td>'.$donnees['titre'].'</td>';
	   echo'<td>';
	   $type = $bdd->query("SELECT nom_revue FROM article_journal WHERE URL ='$url' ");
	   //$d = $type->fetch();
	   if ($type->fetch() == NULL)
		   echo 'conférence';
	   else
		   echo  'journal';
	   echo '</td>';
       echo'<td>'.$donnees['date_publication'].'</td>';
	   echo '<td>';
	   // On crée une boucle pour afficher tous les seconds auteurs
	   $sec_aut = $bdd->query("SELECT matricule_second_auteur FROM seconds_auteurs WHERE URL ='$url' ");
		while ($d_sec_aut = $sec_aut->fetch())
			echo $d_sec_aut['matricule_second_auteur']." ";
		echo '</td>';
   echo'</tr>';
}
echo'</table>';
	
 }

?>

</html>