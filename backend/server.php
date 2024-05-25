<?php
    require_once __DIR__ . "/functions.php";

    $disc_list = file_get_contents("../dischi.json");

    $disc_list = json_decode($disc_list, true);

    $disc_visible = $disc_list;

    $disc_visible = show_filtered_array($disc_visible);

    $disc_visible = toggle_favorite($disc_visible, $disc_list);


    $api_resp = [
        "response" => $disc_visible,
        "status" => "success"
    ];


    header("Content-Type: application/json");
    echo json_encode($api_resp);

?>