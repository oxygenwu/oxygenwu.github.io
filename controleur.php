<?php
	include("pgsql.php");
	
	$css = "archiWeb.css";
	$titre = "Architecture web - exemple";
	$squelette = "archiWeb.html";
	$tableau="<div id='resultats'>\n\t<p><span>annee</span><span>nom</span><span>prenom</span><span>pay</span></p>\n";
	$parite="impair";
	$table='ballondeor';
	$requete="select annee from $table"; 
	$liste="<select name='annee'>";
	$resultat = pg_query ($requete) or die('&eacute;chec requ&ecirc;te :' . pg_last_error()); 
	while($tuple=pg_fetch_array($resultat, null,PGSQL_ASSOC))
	{
		$liste=$liste."<option>$tuple[annee]</option>";
	};
	$liste=$liste."</select>";

	if (isset($_POST['action'])) {
	  $action=$_POST['action'];
	} else {
	  $action="accueil";
	}

	switch ($action) {
	
		case "filtrage":
			$requete="SELECT * FROM $table WHERE annee='$_POST[annee]' ORDER BY annee";
		break;

		case "insertion":
			$requete="INSERT INTO $table ( annee,nom, prenom,pay) VALUES($_POST[annee],'$_POST[nom]','$_POST[prenom]','$_POST[pay]')";
			pg_query ($requete) or die('&eacute;chec requ&ecirc;te :' . pg_last_error()); 
			echo "<p class='comment'>insertion réussie</p>";
			$requete="SELECT * FROM $table ORDER BY annee";
		break;

		case 'accueil':
			$requete="SELECT * FROM $table ORDER BY annee";
		break;
	 
		default:
			$tableau="page non trouvée";
		break;

	}
	$resultat = pg_query ($requete) or die('&eacute;chec requ&ecirc;te :' . pg_last_error()); 
	while($tuple=pg_fetch_array($resultat, null,PGSQL_ASSOC))
	{
		$tableau=$tableau."\t<p class=$parite><span>$tuple[annee]</span><span>$tuple[nom]</span><span>$tuple[prenom]</span><span>$tuple[pay]</span></p>\n";
		($parite=="impair")?$parite="pair":$parite="impair";
	};
	$tableau=$tableau."</div>\n";
			
	ob_start();
		require_once($squelette);
		$html = ob_get_contents();
	ob_end_clean();

	echo $html;
?>
