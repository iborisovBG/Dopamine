<?php

class Allnews extends News
{

	private $conn;
	private $table_name = "news";
	public $id;
	public $title;
	public $text;
	public $date;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	function allnews()
	{
		$query = "SELECT
                     id, title, text, date
                FROM
                    " . $this->table_name . " 
                ORDER BY
                    date DESC";
		$stmt = $this->conn->prepare($query);

		$stmt->execute();

		return $stmt;
	}
}
