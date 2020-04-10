<?php

class NewsOne extends News
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

    function news_id()
    {

        $query = "SELECT
                id, title, text, date
            FROM
                " . $this->table_name . " 
            WHERE
                id = ?
            LIMIT
                0,1";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        if ($stmt->rowCount()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->title = $row['title'];
            $this->text = $row['text'];
            $this->date = $row['date'];
        } else {
        }
    }
}
