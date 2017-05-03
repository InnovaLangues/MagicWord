<?php
namespace MagicWordBundle\Entity\Bigram;

class Square {
	private $_idCase;
	private $_val;
	private $_tabCasesLiees;

	public function __construct(){
		$this->_idCase = -1;
		$this->_val = '#';
		$this->_tabCasesLiees = array();
	}

	public function getId(){
		return $this->_idCase;
	}

	public function getVal(){
		return $this->_val;
	}

	public function getCasesLiees(){
		return $this->_tabCasesLiees;
	}

	public function setId($id){
		if ($id >=1 AND $id <=16){
			$this->_idCase = $id;
		}
	}

	public function setVal($c){
		if ($c >= 'a' && $c <='z'){
			$this->_val = $c;
		}
	}

	public function remp($id, $c){
		$this->setId($id);
		$this->setVal($c);
		//on remplit le tableau des cases liées
		switch($this->_idCase){
			case 1:
				$this->_tabCasesLiees = array(2,5,6);
				break;
			case 2:
				$this->_tabCasesLiees = array(1,3,5,6,7);
				break;
			case 3:
				$this->_tabCasesLiees = array(2,4,6,7,8);
				break;
			case 4:
				$this->_tabCasesLiees = array(3,7,8);
				break;
			case 5:
				$this->_tabCasesLiees = array(1,2,6,9,10);
				break;
			case 6:
				$this->_tabCasesLiees = array(1,2,3,5,7,9,10,11);
				break;
			case 7:
				$this->_tabCasesLiees = array(2,3,4,6,8,10,11,12);
				break;
			case 8:
				$this->_tabCasesLiees = array(3,4,7,11,12);
				break;
			case 9:
				$this->_tabCasesLiees = array(5,6,10,13,14);
				break;
			case 10:
				$this->_tabCasesLiees = array(5,6,7,9,11,13,14,15);
				break;
			case 11:
				$this->_tabCasesLiees = array(6,7,8,10,12,14,15,16);
				break;
			case 12:
				$this->_tabCasesLiees = array(7,8,11,15,16);
				break;
			case 13:
				$this->_tabCasesLiees = array(9,10,14);
				break;
			case 14:
				$this->_tabCasesLiees = array(9,10,11,13,15);
				break;
			case 15:
				$this->_tabCasesLiees = array(10,11,12,14,16);
				break;
			case 16:
				$this->_tabCasesLiees = array(11,12,15);
				break;
			default:
				$this->_tabCasesLiees = array(-1,-1,-1);
		}
	}

	public function isEmpty(){
		if ($this->_val != '#')
			return false;
		return true;
	}

}
