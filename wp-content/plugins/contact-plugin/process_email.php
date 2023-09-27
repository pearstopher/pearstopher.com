<?php
// Include WordPress core
define("WP_USE_THEMES", false);
require_once "../../../wp-load.php";
if (isset($_POST["maths"])) {
    $maths = $_POST["maths"];

    // For example, send it to your external URL
    //$response = wp_remote_post("http://external-url.com/process-email", [
    //    "body" => ["email" => $email],
    //]);
    if ($maths == 69) {
        echo "My email address is pearstopher@gmail.com. Talk to you soon!";
    } else {
        echo "Are you sure about that?";
    }

    //     if (!is_wp_error($response) && $response["response"]["code"] == 200) {
    //         echo $response["body"]; // Output response from external URL
    //     } else {
    //         echo "Error sending email.";
    //     }
}
