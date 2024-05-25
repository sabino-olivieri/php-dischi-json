<?php
    require_once __DIR__ . "/functions.php";

    $disc_list = file_get_contents("../dischi.json");

    $disc_list = json_decode($disc_list, true);

    $disc_visible = $disc_list;

    if ((isset($_GET["filter"]) && $_GET["filter"] === "filter-favorite") ||
    (isset($_POST["filter"]) && $_POST["filter"] === "filter-favorite")) {
        $temp_list = [];

            foreach ($disc_visible as $key => $cur_disc) {
                
                if(isset($cur_disc["favorite"]) && $cur_disc["favorite"]) {
                    $temp_list[] = $cur_disc;
                }
                
            }

            $disc_visible = $temp_list;
        
    } elseif ((isset($_GET["filter"]) && $_GET["filter"] === "filter-unfavorite") ||
    (isset($_POST["filter"]) && $_POST["filter"] === "filter-unfavorite")) {
        $temp_list = [];

            foreach ($disc_visible as $key => $cur_disc) {
                
                if(!isset($cur_disc["favorite"])) {
                    $temp_list[] = $cur_disc;
                } elseif (isset($cur_disc["favorite"]) && !$cur_disc["favorite"]){
                    $temp_list[] = $cur_disc;
                }
                
            }

            $disc_visible = $temp_list;
        
    } elseif ((isset($_GET["filter"]) && $_GET["filter"] === "filter-all") ||
    (isset($_POST["filter"]) && $_POST["filter"] === "filter-all")) {
        $disc_visible = $disc_list;
    }

    $disc_visible = toggle_favorite($disc_visible);


    // if(isset($_POST["action"]) && $_POST["action"] === "toggle-favorite") {
    //     $index = $_POST["index"];
    //     if(!empty($disc_visible)) {
    //     if(isset($disc_visible[$index]["favorite"])){
    //         $disc_visible[$index]["favorite"] = !$disc_visible[$index]["favorite"];
    //     } else  {
    //         $disc_visible[$index]["favorite"] = true;
    //     }
    // }
    // }

    $api_resp = [
        "response" => $disc_visible,
        "status" => "success"
    ];

    //aggiorno disc_list prima di salvare
    foreach ($disc_list as $index => $cur_disc) {
        
        foreach ($disc_visible as $key => $cur_visible) {

            if($cur_disc["title"] === $cur_visible["title"] &&
            $cur_disc["author"] === $cur_visible["author"] &&
            $cur_disc["year"] === $cur_visible["year"]) {
                // var_dump($disc_list[$index]);
                // var_dump($disc_visible[$key]);
                $disc_list[$index] = $disc_visible[$key];

            }
        }
    }

    file_put_contents("../dischi.json", json_encode($disc_list));

    header("Content-Type: application/json");
    echo json_encode($api_resp);

?>