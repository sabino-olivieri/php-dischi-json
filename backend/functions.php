<?php
function toggle_favorite($disc_visible)
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

    return $disc_visible;
}
