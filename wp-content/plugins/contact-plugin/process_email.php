<?php
// Include WordPress core
define("WP_USE_THEMES", false);
require_once "../../../wp-load.php";

if (isset($_POST["email"])) {
    $email = $_POST["email"];

    // Perform any necessary processing with the email address

    // For example, send it to your external URL
    //$response = wp_remote_post("http://external-url.com/process-email", [
    //    "body" => ["email" => $email],
    //]);
    echo "Form submitted successfully.";

    if (!is_wp_error($response) && $response["response"]["code"] == 200) {
        echo $response["body"]; // Output response from external URL
    } else {
        echo "Error sending email.";
    }
}
