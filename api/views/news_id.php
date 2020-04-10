<?php
/*
*Author : I.Borisov 
*Date : 4/5/2020
*company : Dopamine LLC (Task interview)
*file: news_id.php
*/
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/classes/News.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/controllers/NewsID.php';

//connection
$database = new DopamineDB();
$db = $database->connection();

//call the class and objects
$news = new NewsOne($db);
$url = $_SERVER['REQUEST_URI'];
//get the news id
$url_arr = explode('/', $url);
$id = intval(end($url_arr));

$news->id = isset($id) ? $id : die();

//read it
$news->news_id();

if ($news->title != null) {
    //to be ready for json
    $news_arr = array(
        "id" =>  $news->id,
        "title" => $news->title,
        "date" => $news->date,
        "text" => $news->text,

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
            "message" => "News ID does not exist.",
            "details" => array(),
            "code" => 2
        )
    ));
}
