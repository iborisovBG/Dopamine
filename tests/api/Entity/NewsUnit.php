<?php
/*
*Author : I.Borisov 
*Date : 4/5/2020
*company : Dopamine LLC (Task interview)
*file: read_news.php
*/
class NewsUnit
{
    private $conn;
    private $table_name = "news";
    private $users_table = "users";
    private $comments_table = "comments";
    public $id;
    public $title;
    public $text;
    public $date;

    public function __construct($db)
    {
        $this->conn = $db;
    }


    function user_privilegies()
    {

        $query = "SELECT * FROM " . $this->users_table . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }


    function comments()
    {

        $query = "SELECT
            *
        FROM
            " . $this->comments_table . " 
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


$hello = new NewsUnit;

?>