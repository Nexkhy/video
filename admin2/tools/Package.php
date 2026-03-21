<?php 

class Package {
	
	public function __construct() {
	}


	/* 
	Uploader un fichier sur un serveur
	*/
	public function uploaded($source, $destination) {
		return move_uploaded_file($source, $destination);
	}


	/* 
	Renommer un fichier
	*/
	public function rename($prefix, $separateur, $extension) {
		$str= $prefix . $separateur . date('dmYHis') . $extension;
		return $str;
	}


	/* 
	Convertir une chaine (JJ/MM/AAAA) en date
	*/
	public function convertToDate($str, $separateur) {
		$d= date(explode($separateur, $str)[2].$separateur.
                explode($separateur, $str)[1].$separateur.
                explode($separateur, $str)[0]);

		return $d;
	}


	/* 
	Conmparer deux dates
	*/
	public function compareDate($date1, $date2, $separateur) {
		$d1= date(explode($separateur, $date1)[2].$separateur.
                explode($separateur, $date1)[1].$separateur.
                explode($separateur, $date1)[0]);
		$d2= date(explode($separateur, $date2)[2].$separateur.
                explode($separateur, $date2)[1].$separateur.
                explode($separateur, $date2)[0]);

		$d1= strtotime($d1);
		$d2= strtotime($d2);

		if($d1 > $d2) {
			return 1;
		}
		else if($d1 < $d2) {
			return -1;
		}
		else {
			return 0;
		}
	}


	/*
	Ajouter un jour a une date
	*/
	public function addDayDate($str, $separateur) {
		$date= $this->convertToDate($str, $separateur);

		$d= date(
			'd' . $separateur . 'm' . $separateur . 'Y',
			strtotime($date . ' + 1 days')
			);

		return $d;
	}


	/*
	Prend en parametre deux tableaux $tab1 et $tab2 et
	charge $tab2 dans $tab1 et retourne $tab1
	*/
	public function chargerTableau($tab1, $tab2) {
		for ($i=0; $i< sizeof($tab2); $i++) { 
			array_push($tab1, $tab2[$i]);
		}

		return $tab1;
	}


	/*
	Prend en parametre un tableau et longueur à copier
	dans un autre tableau
	*/
	public function subrTableau($tab, $inf, $sup) {
		$data= array();

		for ($i= $inf; $i<= $sup; $i++) { 
			array_push($data, $tab[$i]);
		}

		return $data;
	}


	/*
	Distance entre deux points geographique
	*/
	public function distance_map($lat1, $lng1, $lat2, $lng2) {
    	$earth_radius = 6378137;   // Terre = sphère de 6378km de rayon
		$rlo1 = deg2rad($lng1);
		$rla1 = deg2rad($lat1);
		$rlo2 = deg2rad($lng2);
		$rla2 = deg2rad($lat2);
		$dlo = ($rlo2 - $rlo1) / 2;
		$dla = ($rla2 - $rla1) / 2;
		$a = (sin($dla) * sin($dla)) + cos($rla1) * cos($rla2) * (sin($dlo) * sin($dlo));
		$d = 2 * atan2(sqrt($a), sqrt(1 - $a));
		$d = $earth_radius * $d; // Resultat en Metres
		$d = $d/1000; //Conversion en Kilometres

		return $d;
    }


    /*
	Convertir un entier en lettre de l'alphabet
	*/
	public function convertToAlphabet($nb) {
    	$alphabet= "";

    	switch ($nb) {
		    case 1: $alphabet= "A"; break;
		    case 2: $alphabet= "B"; break;
		    case 3: $alphabet= "C"; break;
		    case 4: $alphabet= "D"; break;
		    case 5: $alphabet= "E"; break;
		    case 6: $alphabet= "F"; break;
		    case 7: $alphabet= "G"; break;
		    case 8: $alphabet= "H"; break;
		    case 9: $alphabet= "I"; break;
		    case 10: $alphabet= "J"; break;
		    case 11: $alphabet= "K"; break;
		    case 12: $alphabet= "L"; break;
		    case 13: $alphabet= "M"; break;
		    case 14: $alphabet= "N"; break;
		    case 15: $alphabet= "O"; break;
		    case 16: $alphabet= "P"; break;
		    case 17: $alphabet= "R"; break;
		    case 18: $alphabet= "S"; break;
		    case 19: $alphabet= "T"; break;
		    case 20: $alphabet= "U"; break;
		    case 21: $alphabet= "V"; break;
		    case 22: $alphabet= "W"; break;
		    case 23: $alphabet= "X"; break;
		    case 24: $alphabet= "Y"; break;
		    case 25: $alphabet= "Z"; break;
		    default: $alphabet= "Infini";
		}

		return $alphabet;
    }




    /*
	Ranger aléatoirement les élèments d'un tableau

	La solution s'appuie sur l'algorithme de Fisher-Yates. 
	L'idée est de trier le tableau dans un ordre aléatoire, 
	puis de tirer un à un ses éléments, en le parcourant 
	séquentiellement depuis le début.

	Le mélange de Fisher-Yates, aussi appelé mélange de Knuth, 
	est un algorithme pour générer une permutation aléatoire 
	d'un ensemble fini, c'est-à-dire pour mélanger un ensemble 
	d'objets.
	*/
	public function rangeArrayRandom($tab) {
    	$random= 0; $tmp;

    	if($tab != null && sizeof($tab) > 1) {
    		for($i= sizeof($tab)-1; $i > 0; $i--) {
    			$random= rand(0, $i);

    			$tmp= $tab[$random];
    			$tab[$random]= $tab[$i];
    			$tab[$i]= $tmp;
    		}
    	}

    	return $tab;
    }




    /* 
		En JavaScript
		atob() : Méthode permettant de décoder une chaîne de 
		donnée qui a été encodée en base64

		En PHP
		Il correspond à base64_decode(string):string 
		
		En JavaScript
		btoa() : Méthode permettant de créer une chaîne ASCII 
		en base64 à partir d'une « chaîne » de données binaires

		En PHP
		Il correspond à base64_encode(string):string en PHP
	*/

	// Encoder les données
	public function encodeData($data) {
	    return base64_encode($data);
	}

	// Decoder les données
	public function decodeData($data) {
	    return base64_decode($data);
	}





	/*
		Echapper les caractères spéciaux dans les champs envoyés par le client
		--------------
		ENT_COMPAT : Convertit les guillemets doubles, et ignore les guillemets simples.
		ENT_QUOTES : Convertit les guillemets doubles et les guillemets simples.
		ENT_NOQUOTES : Ignore les guillemets doubles et les guillemets simples.
	*/
	public function escapeField($field) {
		$data = htmlentities($field, ENT_NOQUOTES, 'UTF-8');
		$data = addslashes($data);

	    return $data;
	}
		

}

?>