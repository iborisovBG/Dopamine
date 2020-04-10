<?php
/*
*Author : I.Borisov 
*Date : 4/5/2020
*company : Dopamine LLC (Task interview)
*file: create_news.php
*/
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/classes/News.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/controllers/CreateNews.php';
//make connection
$database = new DopamineDB();
$db = $database->connection();

$news = new CreateNews($db);


$data = json_decode(file_get_contents("php://input"));
//if empty data
if (
    !empty($data->title) &&
    !empty($data->date) &&
    !empty($data->text)
) {

    //set data
    $news->title = $data->title;
    $news->date = $data->date;
    $news->text = $data->text;


    if ($news->create_news()) {

        // set ok code
        http_response_code(201);

        //ok
        echo json_encode(array("id" => $news->id ,"message" => $data));

    }

    // response not ok
    else {

        //service unavailable
        http_response_code(503);

        //response
        echo json_encode(array("message" => "Unable to create news."));
    }
}

//response data
else {
    //bad sending
    http_response_code(400);

    //response not ok
    echo json_encode(array("message" => "Unable to create news. Data is incomplete."));
}
