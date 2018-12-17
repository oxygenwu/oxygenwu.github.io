<?php
	include("mdp.php");
	$serveur="postgresql.info.unicaen.fr";
	$login="21513356";
	$base="21513356_bd";
	$connexion="host=$serveur dbname=$base user=$login password=$mdp";
	$id_connexion=pg_connect($connexion) or die('Connexion impossible :'.pg_last_error());
?>
