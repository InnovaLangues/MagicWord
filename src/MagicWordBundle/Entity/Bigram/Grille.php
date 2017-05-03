<?php

namespace MagicWordBundle\Entity\Bigram;

use MagicWordBundle\Entity\Bigram\Square as Square;

class Grille {
	private $_idGrille;
	private $_tabCases;
	private static $_nbGrilles = 0;

	public function __construct(){
		self::$_nbGrilles++;
		$this->_tabCases = array();
		//initialisation des cases
		for ($i = 0;$i <16; $i++) {
			$this->_tabCases[$i] = new Square();
		}
		$this->_idGrille = self::$_nbGrilles;
	}

	public function getIdGrille(){
		return $this->_idGrille;
	}

	public function getTabCases(){
		return $this->_tabCases;
	}

	private function loadBigrammesPoids($bigrams) {
		$tabBigrammes = array();
		if (is_file($bigrams)){ //on teste si le fichier existe
			$fic = fopen($bigrams, "r");
			$i = 0;
			$ligne = fgets($fic);
			while (!feof($fic)) { //on vérifie qu'on ne soit pas à la fin de fichier
				$tab = explode("\t", $ligne);
				if ($tab[1] > 0){
					//si le nombre d'occurences du bigramme est supérieur à 0
					//il apparaît dans le tableau un nombre égal à son poids ($tab[3])
					for ($j = 0; $j < $tab[3]; $j++) {
						$tabBigrammes[$i] = $tab[0];
						$i++;
					}
				}
				$ligne = fgets($fic);
			}
			fclose($fic);
		} else {
			print "Erreur ! Le fichier demandé n'existe pas.\n";
		}
		return $tabBigrammes;
	}

	//la fonction de chargement du tableau des bigrammes change pour prendre en compte la pondération
	public function generGrillePonderation($bigrams){

		$tabBigrammes = $this->loadBigrammesPoids($bigrams);
		if ($tabBigrammes == null) {
			print("Le tableau des bigrammes est vide.");
			exit();
		}

		$nbCasesRemplies = 0;

		//initialisation du tableau des cases vides
		$tabCasesVides= array();
		for ($j = 0 ; $j<16;$j++){
			$tabCasesVides[$j] = $j;
		}

		while ($nbCasesRemplies <16) {
			//choix aléatoire d'une case
			$id = array_rand($this->_tabCases, 1);

			//choix aléatoire d'un bigrammme
			$b = array_rand($tabBigrammes, 1);

			if ($this->_tabCases[$id]->isEmpty()) {

				//la case prend la valeur du premier caractère du bigramme
				$this->_tabCases[$id]->remp($id+1, substr($tabBigrammes[$b],0,1));

				$nbCasesRemplies++;

				//on enlève la case du tableau des cases vides
				$indice = array_search($id, $tabCasesVides);
				array_splice($tabCasesVides, $indice, 1);

				//remplir une case liée

				$tabCasesLiees = $this->_tabCases[$id]->getCasesLiees();
				$cpt = count($tabCasesLiees);

				$numCaseBis;
				$trouve = false;

				do{
					//~ on tire aléatoirement une case liée
					$m = array_rand($tabCasesLiees, 1);
					$numCaseBis = $tabCasesLiees[$m]-1; // -1 parce que les cases sont numérotées de 1 à 16

					//~ recherche de la case dans le tableau des cases vides
					if (array_search($numCaseBis, $tabCasesVides) == false){
					//~ if ($this->_tabCases[$numCaseBis]->isEmpty() == false){
						// si on ne trouve pas la case dans le tableau des cases vides, on la supprime du tableau des cases liées
						array_splice($tabCasesLiees, $m, 1);
					}else {
						$trouve = true;
					}
					$cpt--;
				} while (!$trouve && $cpt > 0);

				if($trouve){

					//~ si on a trouvé une case liée vide, elle prend la valeur du second caractère du bigramme
					$this->_tabCases[$numCaseBis]->remp($numCaseBis+1, substr($tabBigrammes[$b],1,1));

					//~ on supprime la case du tableau des cases vides
					$ind = array_search($numCaseBis, $tabCasesVides);
					array_splice($tabCasesVides, $ind, 1);

					$nbCasesRemplies++;
				}

			}
		}
	}

}
