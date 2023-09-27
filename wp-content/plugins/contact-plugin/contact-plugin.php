<?php
/*
Plugin Name: Pears' Contact Plugin
Description: Adds a shortcode contact field to my website
Version: 1.0
Author: Pearstopher
*/

function pears_contact_form_shortcode()
{
    ob_start();// Output the contact form HTML
    // Start output buffering
    ?>
    <form action="#" method="post" id="pears-contact-form">
        <label for="email">Email Address:</label>
        <input type="email" name="email" id="email" required>
        <input type="submit" value="Submit">
    </form>
    <?php return ob_get_clean(); // Return the buffered output
}
add_shortcode("pears_contact", "pears_contact_form_shortcode");

function enqueue_jquery()
{
    wp_enqueue_script("jquery");
}
add_action("wp_enqueue_scripts", "enqueue_jquery");

function enqueue_custom_script()
{
    $custom_script =
        '
        jQuery(document).ready(function ($) {
          $("#pears-contact-form").on("submit", function (e) {
            e.preventDefault();
            var email = $("#email").val();

            $.ajax({
              url: "' .
        plugin_dir_url(__FILE__) .
        'process_email.php", // Plugin PHP file
              type: "POST",
              data: { email: email },
              success: function (response) {
                alert("Your email has been sent to " + response);
              },
              error: function () {
                alert("An error occurred while processing your request.");
              },
            });
          });
        });
    ';

    wp_add_inline_script("jquery", $custom_script);
}

add_action("wp_enqueue_scripts", "enqueue_custom_script");
