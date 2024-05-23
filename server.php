<?php 
    $disc_list = file_get_contents("dischi.json");

    $disc_list = json_decode($disc_list, true);

    $api_resp = [
        "response" => $disc_list,
        "status" => "success"
    ];

    header("Content-Type: application/json");
    echo json_encode($api_resp);

?>