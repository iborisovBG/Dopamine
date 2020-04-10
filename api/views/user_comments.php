<?php
/*
*Author : I.Borisov 
*Date : 4/5/2020
*company : Dopamine LLC (Task interview)
*file: user_comments.php
*/
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/classes/News.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/controllers/UserComments.php';

//connection
$database = new DopamineDB();
$db = $database->connection();

//call the class and objects
$news = new UserComments($db);
$url = $_SERVER['REQUEST_URI'];
//get the news id

$url = parse_url($_SERVER['REQUEST_URI']);
$implode_url =  implode("/", $url);
$explode_url = explode("/", $implode_url);
foreach ($explode_url as $value) {
    if (is_numeric($value)) {
        $datas[] = $value;
    }
}
 $id = $datas[0];
 $user_id = $datas[1];
 $comment_id = $datas[2];

$news->id = isset($id) ? $id : die();
$news->user_id = isset($user_id) ? $user_id : die();
$news->comment_id = isset($comment_id) ? $comment_id : die();
//read it
$news->Comments();

if ($news->title != null) {
    //to be ready for json
    $news_arr = array(
        "comment_id" =>  $news->id,
        "news_title" => $news->title,
        "user" => $news->username,
        "comment" => $news->comment,

    );

    //ok
    http_response_code(200);

    //response json
    echo json_encode($news_arr);
} else {
    // not found 
    http_response_code(404);

    // this not exist
    echo json_encode(array(
        "success" => false,
        "error" => array(
            "message" => "Comment ID does not exist.",
            "details" => array(),
            "code" => 2
        )
    ));
}
