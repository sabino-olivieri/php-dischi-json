<?php 
    $disc_list = file_get_contents("dischi.json");

    $disc_list = json_decode($disc_list, true);

    if(isset($_POST["action"]) && $_POST["action"] === "toggle-favorite") {
        $index = $_POST["index"];

        if(isset($disc_list[$index]["favorite"])){
            $disc_list[$index]["favorite"] = !$disc_list[$index]["favorite"];
        } else  {
            $disc_list[$index]["favorite"] = true;
        }
        file_put_contents("dischi.json", json_encode($disc_list));
    }

    $api_resp = [
        "response" => $disc_list,
        "status" => "success"
    ];

    header("Content-Type: application/json");
    echo json_encode($api_resp);

?>