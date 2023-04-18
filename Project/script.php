<html>
<!-- connexion a la base de donnees -->
<?php

session_start();
$name = $_SESSION["name"];
$password = $_SESSION["password"];
$host = $_SESSION["host"];

$bdd = new PDO('mysql:host='.$host.';dbname=;charset=utf8', $name, $password);



$bdd->query("DROP DATABASE IF EXISTS group34;");
$bdd->query("CREATE DATABASE IF NOT EXISTS group34;");
$bdd->query("USE group34;");	

$bdd->query("CREATE TABLE IF NOT EXISTS Institutions(
	nom VARCHAR(50) NOT NULL, 
	rue VARCHAR(50) NOT NULL, 
	numero VARCHAR(5) NOT NULL, 
	ville VARCHAR(50) NOT NULL, 
	pays VARCHAR(50) NOT NULL,
	PRIMARY KEY(nom)
)ENGINE=InnoDB;
");

$bdd->query("CREATE TABLE IF NOT EXISTS Auteurs(
	matricule INT NOT NULL,
	nom VARCHAR(50) NOT NULL, 
	prenom VARCHAR(50) NOT NULL, 
	debut_doctorat YEAR NOT NULL, 
	nom_institution VARCHAR(50) NOT NULL,
	PRIMARY KEY(matricule),
	FOREIGN KEY (nom_institution)
		REFERENCES Institutions(nom)
)ENGINE=InnoDB;
");

$bdd->query("CREATE TABLE IF NOT EXISTS Article(
	URL VARCHAR(2083) NOT NULL, 
	DOI BIGINT NOT NULL, 
	titre VARCHAR(200) NOT NULL, 
	date_publication VARCHAR(10) NOT NULL, 
	matricule_premier_auteur INT NOT NULL,
	PRIMARY KEY(URL),
	UNIQUE (DOI),
	FOREIGN KEY(matricule_premier_auteur)
		REFERENCES Auteurs(matricule)
)ENGINE=InnoDB;
");

$bdd->query("
CREATE TABLE IF NOT EXISTS Sujets_Article(
	URL VARCHAR(2083) NOT NULL, 
	sujet VARCHAR(50) NOT NULL,
	PRIMARY KEY(URL,sujet),
	FOREIGN KEY(URL)
		REFERENCES Article(URL)
)ENGINE=InnoDB;
");

$bdd->query("
CREATE TABLE IF NOT EXISTS Seconds_Auteurs(
	URL VARCHAR(2083) NOT NULL, 
	matricule_second_auteur INT NOT NULL,
	PRIMARY KEY(URL, matricule_second_auteur),
	FOREIGN KEY(URL)
		REFERENCES Article(URL),
	FOREIGN KEY(matricule_second_auteur)
		REFERENCES Auteurs(matricule)
)ENGINE=InnoDB;
");

$bdd->query("
CREATE TABLE IF NOT EXISTS Revue(
	nom VARCHAR(50) NOT NULL, 
	impact INT NOT NULL,
	PRIMARY KEY(nom)
)ENGINE=InnoDB;

");

$bdd->query("
CREATE TABLE IF NOT EXISTS Article_Journal (
	URL VARCHAR(2083) NOT NULL, 
	pg_debut INT NOT NULL, 
	pg_fin INT NOT NULL, 
	nom_revue VARCHAR(50) NOT NULL, 
	n_journal INT NOT NULL,
	PRIMARY KEY(URL),
	FOREIGN KEY(URL)
		REFERENCES Article(URL),
	FOREIGN KEY(nom_revue)
		REFERENCES Revue(nom)
)ENGINE=InnoDB;
");

$bdd->query("

CREATE TABLE IF NOT EXISTS Conference(
	nom VARCHAR(100) NOT NULL, 
	annee YEAR NOT NULL,
	rue VARCHAR(50) NOT NULL, 
	numero VARCHAR(5) NOT NULL, 
	ville VARCHAR(50) NOT NULL, 
	pays VARCHAR(50) NOT NULL,
	PRIMARY KEY(nom, annee)
)ENGINE=InnoDB;
");

$bdd->query("

CREATE TABLE IF NOT EXISTS Article_Conference(
	URL VARCHAR(2083) NOT NULL, 
	presentation VARCHAR(30) NOT NULL, 
	nom_conference VARCHAR(100) NOT NULL, 
	annee_conference YEAR NOT NULL,
	PRIMARY KEY(URL),
	FOREIGN KEY(URL)
		REFERENCES Article(URL),
	FOREIGN KEY(nom_conference, annee_conference)
		REFERENCES Conference(nom, annee)
)ENGINE=InnoDB;

");

$bdd->query("

CREATE TABLE IF NOT EXISTS Participation_Conference(
	matricule INT NOT NULL, 
	nom_conference VARCHAR(100) NOT NULL, 
	annee_conference YEAR NOT NULL, 
	tarif VARCHAR(20),
	PRIMARY KEY(matricule, nom_conference, annee_conference),
	FOREIGN KEY(matricule)
		REFERENCES Auteurs(matricule),
	FOREIGN KEY(nom_conference, annee_conference)
		REFERENCES Conference(nom, annee)
)ENGINE=InnoDB;
");

// On rempli ensuite la base de donnee avec les valeurs:


$filename = 'ressources/institutions.csv';
$file = fopen($filename, "r");
try{
$emapData = fgetcsv($file, 10000, ";");
         while (($emapData = fgetcsv($file, 10000, ";")) !== FALSE)
         {
            $sql = "INSERT into Institutions values(?,?,?,?,?)";
            $d = $bdd->prepare($sql);
			$d->execute($emapData);
         }
         fclose($file);
}catch(\PDOException $e ) {
    $bdd->rollBack();
    throw $e;
}


$filename = 'ressources/auteurs.csv';
$file = fopen($filename, "r");
try{
$emapData = fgetcsv($file, 10000, ",");
         while (($emapData = fgetcsv($file, 10000, ";")) !== FALSE)
         {
            $sql = "INSERT into Auteurs values(?,?,?,?,?)";
            $d = $bdd->prepare($sql);
			$d->execute($emapData);
         }
         fclose($file);
}catch(\PDOException $e ) {
    $bdd->rollBack();
    throw $e;
}

$filename = 'ressources/articles.csv';
$file = fopen($filename, "r");
try{
$emapData = fgetcsv($file, 10000, ",");
         while (($emapData = fgetcsv($file, 10000, ";")) !== FALSE)
         {
            $sql = "INSERT into Article values(?,?,?,?,?)";
            $d = $bdd->prepare($sql);
			$d->execute($emapData);
         }
         fclose($file);
}catch(\PDOException $e ) {
    $bdd->rollBack();
    throw $e;
}

$filename = 'ressources/sujets_articles.csv';
$file = fopen($filename, "r");
try{
$emapData = fgetcsv($file, 10000, ",");
         while (($emapData = fgetcsv($file, 10000, ";")) !== FALSE)
         {
            $sql = "INSERT into Sujets_Article values(?,?)";
            $d = $bdd->prepare($sql);
			$d->execute($emapData);
         }
         fclose($file);
}catch(\PDOException $e ) {
    $bdd->rollBack();
    throw $e;
}

$filename = 'ressources/seconds_auteurs.csv';
$file = fopen($filename, "r");
try{
$emapData = fgetcsv($file, 10000, ",");
         while (($emapData = fgetcsv($file, 10000, ";")) !== FALSE)
         {
            $sql = "INSERT into Seconds_Auteurs values(?,?)";
            $d = $bdd->prepare($sql);
			$d->execute($emapData);
         }
         fclose($file);
}catch(\PDOException $e ) {
    $bdd->rollBack();
    throw $e;
}

$filename = 'ressources/revues.csv';
$file = fopen($filename, "r");
try{
$emapData = fgetcsv($file, 10000, ",");
         while (($emapData = fgetcsv($file, 10000, ";")) !== FALSE)
         {
            $sql = "INSERT into Revue values(?,?)";
            $d = $bdd->prepare($sql);
			$d->execute($emapData);
         }
         fclose($file);
}catch(\PDOException $e ) {
    $bdd->rollBack();
    throw $e;
}

$filename = 'ressources/articles_journaux.csv';
$file = fopen($filename, "r");
try{
$emapData = fgetcsv($file, 10000, ",");
         while (($emapData = fgetcsv($file, 10000, ";")) !== FALSE)
         {
            $sql = "INSERT into Article_Journal values(?,?,?,?,?)";
            $d = $bdd->prepare($sql);
			$d->execute($emapData);
         }
         fclose($file);
}catch(\PDOException $e ) {
    $bdd->rollBack();
    throw $e;
}

$filename = 'ressources/conferences.csv';
$file = fopen($filename, "r");
try{
$emapData = fgetcsv($file, 10000, ",");
         while (($emapData = fgetcsv($file, 10000, ";")) !== FALSE)
         {
            $sql = "INSERT into Conference values(?,?,?,?,?,?)";
            $d = $bdd->prepare($sql);
			$d->execute($emapData);
         }
         fclose($file);
}catch(\PDOException $e ) {
    $bdd->rollBack();
    throw $e;
}

$filename = 'ressources/articles_conferences.csv';
$file = fopen($filename, "r");
try{
$emapData = fgetcsv($file, 10000, ",");
         while (($emapData = fgetcsv($file, 10000, ";")) !== FALSE)
         {
            $sql = "INSERT into Article_Conference values(?,?,?,?)";
            $d = $bdd->prepare($sql);
			$d->execute($emapData);
         }
         fclose($file);
}catch(\PDOException $e ) {
    $bdd->rollBack();
    throw $e;
}

$filename = 'ressources/participations_conferences.csv';
$file = fopen($filename, "r");
try{
$emapData = fgetcsv($file, 10000, ",");
         while (($emapData = fgetcsv($file, 10000, ";")) !== FALSE)
         {
            $sql = "INSERT into Participation_Conference values(?,?,?,?)";
            $d = $bdd->prepare($sql);
			$d->execute($emapData);
         }
         fclose($file);
}catch(\PDOException $e ) {
    $bdd->rollBack();
    throw $e;
}


echo "end";

header('Location: menu.php');


?>

</html>
