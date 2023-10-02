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
    <form action="#" method="post" id="pears-contact-form">
        <div class="input-wrapper">
        <label for="email">Just put your email address here: </label>
        <input type="email" name="email" id="email" required>
        </div>
        <div>
        <label for="message" class="sr-only">Your Message:</label>
        <textarea id="message" name="message" class="input-wrapper" rows="4" cols="50" maxlength="1900">Write your message here...</textarea>
        </div>
        <div class="input-wrapper">
        <label for="maths">Type any integer between 68 and 70 to prove you're human: </label>
        <input type="number" name="maths" id="maths" size="2" required>
        </div>
        <div class="input-wrapper">
        <label for="robot">Click here if you like checkboxes: </label>
        <input type="checkbox" name="checkbox" id="checkbox">
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
            $("#results").parent().show();

            var maths = $("#maths").val();
            var email = $("#email").val();
            var message = $("#message").val();

            $.ajax({
              url: "' .
        plugin_dir_url(__FILE__) .
        'process_email.php", // Plugin PHP file
              type: "POST",
              data: { maths: maths, email: email, message: message },
              success: function (response) {
                $("#results").addClass("good");
                $("#results").html(response);

              },
              error: function () {
                $("#results").html("A problem occurred. Sorry about that!");
                $("#results").addClass("bad");
              },
            });
          });

          $("#message").focus(function() {
              if ($(this).val() === "Write your message here...") {
                  $(this).val("");
              }
              $(this).addClass("active");
          });

          $("#message").blur(function() {
              if ($(this).val() === "") {
                  $(this).val("Write your message here...");
                  $(this).removeClass("active");
              }
          });

          $("#results").parent().hide();


        });

        let counter = 1;
        jQuery(document).on("change", "#checkbox, .additional-checkbox", function() {
              if (this.checked) {
                  jQuery("#checkbox").parent().append("<div><label for=\"checkbox-" + counter + "\">Click here if you like checkboxes: </label><input type=\"checkbox\" name=\"checkbox-" + counter + "\" class=\"additional-checkbox\" /></div>");
                  counter += 1;
              }
        });
    ';

    wp_add_inline_script("jquery", $custom_script);
}

add_action("wp_enqueue_scripts", "enqueue_custom_script");
