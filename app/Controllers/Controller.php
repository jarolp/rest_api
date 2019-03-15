<?php

namespace App\Controllers;

use PDO;

class Controller {
	protected $file_db;
	
	public function __construct(){
		$this->file_db = new PDO('sqlite:sqliteDB/people.sqlite3');
		$this->file_db->setAttribute(PDO::ATTR_ERRMODE, 
								PDO::ERRMODE_EXCEPTION);
	 
		$this->file_db->exec("CREATE TABLE IF NOT EXISTS people (
		nazwisko TEXT, 
		imie TEXT)");
	}
}