<?php
/*
*Author : I.Borisov 
*Date : 4/5/2020
*company : Dopamine LLC (Task interview)
*file: all_news.php
*/
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/classes/News.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/controllers/AllNews.php';

//createdatabase
$database = new DopamineDB();
$db = $database->connection();

//call the class and objects
$allnews = new AllNews($db);
//read all news
$stmt = $allnews->allnews($db);
$num = $stmt->rowCount();

//check if there is a found record
if ($num > 0) {

    // products array
    $news_arr = array();
    $news_arr["news-records"] = array();


    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $news_item = array(
            "id" => $id,
            "title" => $title,
            "date" => $date,
            "text" => html_entity_decode($text),
        );

        array_push($news_arr["news-records"], $news_item);
    }

    // ok
    http_response_code(200);

    //json output
    echo json_encode($news_arr);
} else {

    //not found
    http_response_code(404);

    // response not found
    echo json_encode(
        array("message" => "No News found.")
    );
}
