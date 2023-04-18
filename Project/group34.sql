DROP DATABASE IF EXISTS group34;
CREATE DATABASE IF NOT EXISTS group34;
USE group34;	

CREATE TABLE IF NOT EXISTS Institutions(
	nom VARCHAR(50) NOT NULL, 
	rue VARCHAR(50) NOT NULL, 
	numéro VARCHAR(5) NOT NULL, 
	ville VARCHAR(50) NOT NULL, 
	pays VARCHAR(50) NOT NULL,
	PRIMARY KEY(nom)
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Auteurs(
	matricule INT NOT NULL,
	nom VARCHAR(50) NOT NULL, 
	prénom VARCHAR(50) NOT NULL, 
	debut_doctorat YEAR NOT NULL, 
	nom_institution VARCHAR(50) NOT NULL,
	PRIMARY KEY(matricule),
	FOREIGN KEY (nom_institution)
		REFERENCES Institutions(nom)
)ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS Article(
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

CREATE TABLE IF NOT EXISTS Sujets_Article(
	URL VARCHAR(2083) NOT NULL, 
	sujet VARCHAR(50) NOT NULL,
	PRIMARY KEY(URL,sujet),
	FOREIGN KEY(URL)
		REFERENCES Article(URL)
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Seconds_Auteurs(
	URL VARCHAR(2083) NOT NULL, 
	matricule_second_auteur INT NOT NULL,
	PRIMARY KEY(URL, matricule_second_auteur),
	FOREIGN KEY(URL)
		REFERENCES Article(URL),
	FOREIGN KEY(matricule_second_auteur)
		REFERENCES Auteurs(matricule)
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Revue(
	nom VARCHAR(50) NOT NULL, 
	impact INT NOT NULL,
	PRIMARY KEY(nom)
)ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS Article_Journal (
	URL VARCHAR(2083) NOT NULL, 
	pg_début INT NOT NULL, 
	pg_fin INT NOT NULL, 
	nom_revue VARCHAR(50) NOT NULL, 
	n_journal INT NOT NULL,
	PRIMARY KEY(URL),
	FOREIGN KEY(URL)
		REFERENCES Article(URL),
	FOREIGN KEY(nom_revue)
		REFERENCES Revue(nom)
)ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS Conférence(
	nom VARCHAR(100) NOT NULL, 
	année YEAR NOT NULL,
	rue VARCHAR(50) NOT NULL, 
	numéro VARCHAR(5) NOT NULL, 
	ville VARCHAR(50) NOT NULL, 
	pays VARCHAR(50) NOT NULL,
	PRIMARY KEY(nom, année)
)ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS Article_Conférence(
	URL VARCHAR(2083) NOT NULL, 
	présentation VARCHAR(30) NOT NULL, 
	nom_conférence VARCHAR(100) NOT NULL, 
	année_conférence YEAR NOT NULL,
	PRIMARY KEY(URL),
	FOREIGN KEY(URL)
		REFERENCES Article(URL),
	FOREIGN KEY(nom_conférence, année_conférence)
		REFERENCES Conférence(nom, année)
)ENGINE=InnoDB;



CREATE TABLE IF NOT EXISTS Participation_Conférence(
	matricule INT NOT NULL, 
	nom_conférence VARCHAR(100) NOT NULL, 
	année_conférence YEAR NOT NULL, 
	tarif VARCHAR(20),
	PRIMARY KEY(matricule, nom_conférence, année_conférence),
	FOREIGN KEY(matricule)
		REFERENCES Auteurs(matricule),
	FOREIGN KEY(nom_conférence, année_conférence)
		REFERENCES Conférence(nom, année)
)ENGINE=InnoDB;


LOAD DATA LOCAL INFILE 'ressources/institutions.csv'
INTO TABLE group34.Institutions
FIELDS TERMINATED BY ';'
LINES TERMINATED BY '\n'
IGNORE 1 LINES;
	
LOAD DATA LOCAL INFILE 'ressources/auteurs.csv'
INTO TABLE group34.Auteurs
FIELDS TERMINATED BY ';'
LINES TERMINATED BY '\n'
IGNORE 1 LINES;

LOAD DATA LOCAL INFILE 'ressources/articles.csv'
INTO TABLE group34.Article
FIELDS TERMINATED BY ';'
LINES TERMINATED BY '\n'
IGNORE 1 LINES;

LOAD DATA LOCAL INFILE 'ressources/sujets_articles.csv'
INTO TABLE group34.Sujets_Article
FIELDS TERMINATED BY ';'
LINES TERMINATED BY '\n'
IGNORE 1 LINES;

LOAD DATA LOCAL INFILE 'ressources/seconds_auteurs.csv'
INTO TABLE group34.Seconds_Auteurs
FIELDS TERMINATED BY ';'
LINES TERMINATED BY '\n'
IGNORE 1 LINES;

LOAD DATA LOCAL INFILE 'ressources/revues.csv'
INTO TABLE group34.Revue
FIELDS TERMINATED BY ';'
LINES TERMINATED BY '\n'
IGNORE 1 LINES;

LOAD DATA LOCAL INFILE 'ressources/articles_journaux.csv'
INTO TABLE group34.Article_Journal
FIELDS TERMINATED BY ';'
LINES TERMINATED BY '\n'
IGNORE 1 LINES;

LOAD DATA LOCAL INFILE 'ressources/conferences.csv'
INTO TABLE group34.Conférence
FIELDS TERMINATED BY ';'
LINES TERMINATED BY '\n'
IGNORE 1 LINES;

LOAD DATA LOCAL INFILE 'ressources/articles_conferences.csv'
INTO TABLE Article_Conférence
FIELDS TERMINATED BY ';'
LINES TERMINATED BY '\n'
IGNORE 1 LINES;

LOAD DATA LOCAL INFILE 'ressources/participations_conferences.csv'
INTO TABLE Participation_Conférence
FIELDS TERMINATED BY ';'
LINES TERMINATED BY '\n'
IGNORE 1 LINES;

