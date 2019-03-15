<?php

namespace App\Controllers;

use PDO;

class ApiController extends Controller{
	
	protected $first_name;
	protected $last_name;
	public $msg;

	public function readPeople($request,$response){
		$query = "SELECT * FROM people"; 
		$stmt = $this->file_db->prepare($query);
		$stmt->execute();
		$this->msg = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
		return $response->withJson($this->msg);
	}

	public function createHuman($request,$response){
		if ($this->validateData($request)){
			if (!$this->checkHumanExist($request)){
				$this->msg = "Dodano człowieka do bazy ".$this->last_name." ".$this->first_name."!";

				$query = "INSERT INTO people (nazwisko,imie) VALUES (:nazwisko,:imie)"; 
				$stmt = $this->file_db->prepare($query);
				$stmt->bindValue(':nazwisko', $this->last_name);
				$stmt->bindValue(':imie', $this->first_name);
				$stmt->execute();
				$stmt->closeCursor();
			} else {
				$this->msg = "Człowiek ".$this->last_name." ".$this->first_name." już istnieje w bazie!";
			}
		} 
		return $response->withJson($this->msg);
	}
	
	public function readHuman($request,$response){
		$this->checkHumanExist($request);
		return $response->withJson($this->msg);

	}

	public function deleteHuman($request,$response){
		if ($this->validateData($request)){
			if ($this->checkHumanExist($request)){
				$query = "DELETE FROM people WHERE nazwisko = :nazwisko AND imie = :imie"; 
				$stmt = $this->file_db->prepare($query);
				$stmt->bindValue(':nazwisko', $this->last_name);
				$stmt->bindValue(':imie', $this->first_name);
				$stmt->execute();
				$stmt->closeCursor();
				$this->msg = "Usunięto człowieka ".$this->last_name." ".$this->first_name;
			}
			return $response->withJson($this->msg);
		}
		
	}
		
	private function checkHumanExist($request){
		if ($this->validateData($request)){
			$query = "SELECT * FROM people WHERE nazwisko = :nazwisko AND imie = :imie"; 
			$stmt = $this->file_db->prepare($query);
			$stmt->bindValue(':nazwisko', $this->last_name);
			$stmt->bindValue(':imie', $this->first_name);
			$stmt->execute();
			$exist_human = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$exist_human = count($exist_human);
			$stmt->closeCursor();

			if ($exist_human == 0){
				$this->msg = "Nie znaleziono w bazie człowieka ".$this->last_name." ".$this->first_name;
				return false;
			} 
			$this->msg = "Znaleziono w bazie człowieka ".$this->last_name." ".$this->first_name;
			return true;
		}
		return false;
	}
	
	private function formatData($data){
		
		return ucfirst(strtolower(trim($data)));
	}
	
	private function validateData($request){
		$data = $request->getParams();
		if (isset($data['nazwisko']) && isset($data['imie'])){
			$this->last_name = $this->formatData($data['nazwisko']);
			$this->first_name = $this->formatData($data['imie']);
			
			if (!empty($this->last_name) && !empty($this->first_name)){
				return true;
			}
			$this->msg = "Wszystkie pola muszą być uzupełnione!";
			return false;
		}
		$this->msg = "Nie przesłano wszystkich wymaganych pól. 'Nazwisko', 'Imie'!";
		return false;
		
	}
	
}