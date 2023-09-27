<?php
/*
Plugin Name: Pears' Contact Plugin
Description: Adds a shortcode contact field to my website
Version: 1.0
Author: Pearstopher
*/

function pears_contact_form_shortcode()
{
    ob_start();// Start output buffering
    // Output the contact form HTML
    ?>
    <p>I'm currently looking for work, but I'd love to hear from you for any reason!
    <form action="#" method="post" id="pears-contact-form">
        <div class="input-wrapper">
        <label for="robot">I am a robot: </label>
        <input type="checkbox" checked="checked" name="robot" id="robot">
        </div>
        <div class="input-wrapper">
        <label for="maths">Please enter any whole number between 68 and 70: </label>
        <input type="number" name="maths" id="maths" size="2" required>
        </div>
        <div class="input-wrapper">
        <input type="submit" value="Submit">
        </div>
        <div class="input-wrapper">
        <div id="results"></div>
        </div>
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
            var maths = $("#maths").val();

            $.ajax({
              url: "' .
        plugin_dir_url(__FILE__) .
        'process_email.php", // Plugin PHP file
              type: "POST",
              data: { maths: maths },
              success: function (response) {
                $("#results").html(response);
              },
              error: function () {
                $("#results").html("A problem occurred. Sorry about that!");
              },
            });
          });
        });
    ';

    wp_add_inline_script("jquery", $custom_script);
}

add_action("wp_enqueue_scripts", "enqueue_custom_script");
