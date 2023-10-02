<?php
// Include WordPress core
define("WP_USE_THEMES", false);
require_once "../../../wp-load.php";
if (isset($_POST["maths"])) {
    $maths = $_POST["maths"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    if ($maths == 69) {
        // send the request do discord
        $response = wp_remote_post(
            "https://discord.com/api/webhooks/1156650041692409928/_FwUMLeSNvL7gr-rUtrz6DnyS3L6OrrA0-xHfAZCaVKwmA-6Hzn6tJhLd4dC9eAUWq0Q?=",
            [
                "headers" => ["Content-Type" => "application/json"],
                "data_format" => "body",
                "body" => json_encode([
                    "username" => $email,
                    "content" => $message,
                ]),
            ]
        );
        if (!is_wp_error($response) && $response["response"]["code"] == 204) {
            // 200 successful
            // 201 created successfully
            // 204 successful, no content returned
            echo "Discord notification sent successfully. Your message and email address were received. ";
        } else {
            echo "Error: unable to send Discord notification. I'll look into that right away. In the meantime, my email is pearstopher@gmail.com.";

            //             echo "Error: " .
            //                 $response["response"]["message"] .
            //                 ", " .
            //                 $response["body"] .
            //                 ", " .
            //                 $response["response"]["code"];
        }
    } else {
        echo "Your math looks a little off to me.";
    }
}
