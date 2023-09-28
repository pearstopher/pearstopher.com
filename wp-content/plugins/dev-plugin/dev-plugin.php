<?php
/*
Plugin Name: Pears' Projects Plugin
Description: Registers a custom post type for projects and adds a shortcode widget.
Version: 1.0
Author: Pearstopher
*/

function register_custom_post_type()
{
    $args = [
        "public" => true,
        "label" => "Pears' Projects",
        "supports" => ["title", "editor"], // "custom-fields" lets you edit them manually
    ];
    register_post_type("pears_projects", $args);
}
add_action("init", "register_custom_post_type");

function custom_posts_shortcode($atts)
{
    $args = [
        "post_type" => "pears_projects",
        "posts_per_page" => -1, // Retrieve all posts
    ];

    $custom_posts = new WP_Query($args);
    ob_start(); // Start output buffering

    if ($custom_posts->have_posts()) {
        echo "<div id='project-container'>";
        while ($custom_posts->have_posts()) {
            $custom_posts->the_post();
            // Display custom post content
            echo "<div class='project-outer'>";
            echo "<div class='project'>";
            echo "<div class='spacer'></div>";

            echo "<div class='section-header'>";
            the_title("<h3>", "</h3>");
            echo "</div>";

            $img = get_post_meta(get_the_ID(), "custom_image_url", true);
            if ($img) {
                echo "<img src='" . $img . "' alt='' />";
            }

            echo "<div class='description'>";
            the_content();
            echo "</div>";

            echo "<div class='links'>";
            $url = get_post_meta(get_the_ID(), "project_url", true);
            if ($url) {
                echo "<span><a href='" .
                    $url .
                    "' target='_blank'>GitHub</a></span>";
            }
            $url = get_post_meta(get_the_ID(), "demo_url", true);
            if ($url) {
                echo "<span><a href='" .
                    $url .
                    "' target='_blank'>Live Demo</a></span>";
            }
            echo "</div>";
            echo "<div class='spacer'></div>";

            echo "</div>";
            echo "</div>";
        }
        echo "</div>";
        wp_reset_postdata(); // Reset post data
    }
    return ob_get_clean(); // Return buffered output
}
add_shortcode("pears_projects", "custom_posts_shortcode");

function add_custom_meta_box()
{
    add_meta_box(
        "project_url",
        "Project URL",
        "render_custom_meta_box",
        "pears_projects",
        "normal",
        "high"
    );
}

function render_custom_meta_box($post)
{
    // Add a nonce field
    wp_nonce_field(
        "pears_projects_meta_box_nonce",
        "pears_projects_meta_box_nonce"
    );

    // Render the content of the meta box
    $custom_field_value = get_post_meta($post->ID, "project_url", true);
    echo "<h4>Project URL</h4>";
    echo '<input type="text" name="project_url" value="' .
        esc_attr($custom_field_value) .
        '" />';

    $custom_field_value = get_post_meta($post->ID, "demo_url", true);
    echo "<h4>Demo URL</h4>";
    echo '<input type="text" name="demo_url" value="' .
        esc_attr($custom_field_value) .
        '" />';
}

add_action("add_meta_boxes", "add_custom_meta_box");

function save_custom_meta_box($post_id)
{
    // Check if this is an autosave
    if (defined("DOING_AUTOSAVE") && DOING_AUTOSAVE) {
        return;
    }

    // Check if the user has permission to edit
    if (!current_user_can("edit_post", $post_id)) {
        return;
    }

    // Check if the nonce field is set (for security)
    if (
        !isset($_POST["pears_projects_meta_box_nonce"]) ||
        !wp_verify_nonce(
            $_POST["pears_projects_meta_box_nonce"],
            "pears_projects_meta_box_nonce"
        )
    ) {
        return;
    }

    // Sanitize and save the meta box data
    $custom_field_value = sanitize_text_field($_POST["project_url"]);
    update_post_meta($post_id, "project_url", $custom_field_value);

    $custom_field_value = sanitize_text_field($_POST["demo_url"]);
    update_post_meta($post_id, "demo_url", $custom_field_value);
}

add_action("save_post", "save_custom_meta_box");

function add_custom_image_meta_box()
{
    add_meta_box(
        "custom-image-meta-box", // Unique ID for the meta box
        "Custom Image Upload", // Title of the meta box
        "render_custom_image_meta_box", // Callback function to render the meta box content
        "pears_projects", // Post type where the meta box will be displayed
        "normal", // Context (normal, advanced, side)
        "high" // Priority (high, core, default, low)
    );
}
add_action("add_meta_boxes", "add_custom_image_meta_box");

function render_custom_image_meta_box($post)
{
    wp_nonce_field(
        "custom_image_meta_box_nonce",
        "custom_image_meta_box_nonce"
    );

    $custom_image_url = get_post_meta($post->ID, "custom_image_url", true);

    echo '<label for="custom_image">Custom Image Upload</label>';
    echo '<input type="text" id="custom_image_url" name="custom_image_url" value="' .
        esc_attr($custom_image_url) .
        '" />';
    echo '<input type="button" class="button button-secondary" value="Upload Image" id="upload_custom_image_button" />';
}

function enqueue_custom_image_upload_script()
{
    wp_enqueue_media();
    wp_enqueue_script(
        "custom-image-upload-script",
        plugin_dir_url(__FILE__) . "custom-image-upload.js",
        ["jquery"],
        null,
        true
    );
}
add_action("admin_enqueue_scripts", "enqueue_custom_image_upload_script");

function save_custom_image_url($post_id)
{
    if (
        !isset($_POST["custom_image_meta_box_nonce"]) ||
        !wp_verify_nonce(
            $_POST["custom_image_meta_box_nonce"],
            "custom_image_meta_box_nonce"
        )
    ) {
        return;
    }

    if (defined("DOING_AUTOSAVE") && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can("edit_post", $post_id)) {
        return;
    }

    $custom_image_url = sanitize_text_field($_POST["custom_image_url"]);
    update_post_meta($post_id, "custom_image_url", $custom_image_url);
}
add_action("save_post", "save_custom_image_url");
