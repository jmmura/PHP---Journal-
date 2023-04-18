<html>

<?php

session_start();
$name = $_SESSION["name"];
$password = $_SESSION["password"];
$host = $_SESSION["host"];

$bdd = new PDO('mysql:host='.$host.';dbname=group34;charset=utf8', $name, $password);

$sql = "SELECT sujet FROM sujets_article \n"

    . "INNER JOIN \n"

    . "    (SELECT url from article_conference\n"

    . "     INNER JOIN \n"

    . "        (SELECT annee, nom \n"

    . "        from (SELECT * from conference where conference.annee >= 2012) as T \n"

    . "        INNER JOIN participation_conference on (    participation_conference.annee_conference = annee \n"

    . "                                                and participation_conference.nom_conference = nom) \n"

    . "        group by nom, annee \n"

    . "        order by count(*) DESC \n"

    . "         LIMIT 5\n"

    . "        ) AS T\n"

    . "          on (    T.annee = article_conference.annee_conference\n"

    . "              and T.nom = article_conference.nom_conference)\n"

    . "    ) AS T \n"

    . "      on T.url = sujets_article.url\n"

    . "GROUP BY sujet \n"

    . "ORDER BY COUNT(*) DESC";

$res = $bdd->query($sql);
while($row = $res->fetch())
    echo "<p>".$row[0]."</p>";

?>
</html>