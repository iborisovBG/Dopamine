<?php
class UserComments extends News
{

    private $conn;
    private $table_news = "news";
    private $table_comments = "comments";
    public $id;
    public $news_id;
    public $user_id;


    public function __construct($db)
    {
        $this->conn = $db;
    }

    function Comments()
    {

        $query = "SELECT
        *
      FROM
          " . $this->table_comments . "," . $this->table_news . " WHERE comments.id=$this->comment_id
          AND comments.user_id=$this->user_id AND comments.news_id=$this->id AND news.id=$this->id";

          //print $query;
$stmt = $this->conn->prepare($query);

$stmt->execute();

    
        if ($stmt->rowCount()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->title = $row['title'];
            $this->comment = $row['comment'];
            $this->username = $row['username'];
        } else {
        }
    }
}
