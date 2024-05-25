<?php
/**
 * Description fa il toggle dei preferiti
 * @param array $disc_visible array su cui fare il toggle
 * @param array $disc_list array da inviare per il salvataggio dei cambiamenti
 * @returns array modificato
 */
function toggle_favorite($disc_visible, $disc_list)
{
    if (isset($_POST["action"]) && $_POST["action"] === "toggle-favorite") {
        $index = $_POST["index"];
        if (!empty($disc_visible)) {
            if (isset($disc_visible[$index]["favorite"])) {
                $disc_visible[$index]["favorite"] = !$disc_visible[$index]["favorite"];
            } else {
                $disc_visible[$index]["favorite"] = true;
            }
        }
    }
    save_changes($disc_list, $disc_visible);
    return $disc_visible;
}


/**
 * Description salva i cambiamenti avvenuti nella funzione toggle_favorite
 * @param array $disc_list array non filtrato
 * @param array $disc_visible array filtrato e modificato
 */
function save_changes ($disc_list, $disc_visible) {
    foreach ($disc_list as $index => $cur_disc) {
        
        foreach ($disc_visible as $key => $cur_visible) {

            if($cur_disc["title"] === $cur_visible["title"] &&
            $cur_disc["author"] === $cur_visible["author"] &&
            $cur_disc["year"] === $cur_visible["year"]) {
                $disc_list[$index] = $disc_visible[$key];

            }
        }
    }

    file_put_contents("../dischi.json", json_encode($disc_list, JSON_PRETTY_PRINT));
}

/**
 * Description restituisce array filtrato
 * @param array $disc_visible array da filtrare
 * @returns array filtrato
 */
function show_filtered_array($disc_visible) {


    if ((isset($_GET["filter"]) && $_GET["filter"] === "filter-favorite") ||
    (isset($_POST["filter"]) && $_POST["filter"] === "filter-favorite")) {

        $favorite = true;
        $disc_visible = get_filtered_array($disc_visible, $favorite);
        
    } elseif ((isset($_GET["filter"]) && $_GET["filter"] === "filter-unfavorite") ||
    (isset($_POST["filter"]) && $_POST["filter"] === "filter-unfavorite")) {

        $favorite = false;
        $disc_visible = get_filtered_array($disc_visible, $favorite);

        
    }

    return $disc_visible;
} 

/**
 * Description restituisce array dei preferiti e non in base al valore di $favorite
 * @param array $disc_visible array da filtrare
 * @param boolean $favorite flag se true mostra i preferiti altrimenti i non preferiti
 * @returns array filtrato
 */
function get_filtered_array ($disc_visible, $favorite) {

    $temp_list = [];
    
    foreach ($disc_visible as $key => $cur_disc) {
                
        if(isset($cur_disc["favorite"]) && $cur_disc["favorite"] === $favorite) {
            $temp_list[] = $cur_disc;
        }
        
    }

    return $temp_list;
}

function add_disc($disc_list) {
    var_dump($disc_list);
    $disc_list[] = [
        "title" => $_POST["title"],
        "author" => $_POST["author"],
        "year" => intval($_POST["year"]),
        "poster" => $_POST["poster"],
        "genre" => $_POST["genre"],
    ];

    file_put_contents("../dischi.json", json_encode($disc_list, JSON_PRETTY_PRINT));
}