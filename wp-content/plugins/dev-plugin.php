<?php
/*
Plugin Name: Projects Plugin
Description: Registers a custom post type for projects and adds a shortcode widget.
Version: 1.0
Author: Pearstopher
*/

function register_custom_post_type()
{
    $args = [
        "public" => true,
        "label" => "Custom Posts",
        "supports" => ["title", "editor", "custom-fields"], // Add any other supported features
    ];
    register_post_type("custom_post", $args);
}
add_action("init", "register_custom_post_type");

function custom_posts_shortcode($atts)
{
    $args = [
        "post_type" => "custom_post",
        "posts_per_page" => -1, // Retrieve all posts
    ];

    $custom_posts = new WP_Query($args);
    ob_start(); // Start output buffering

    if ($custom_posts->have_posts()) {
        while ($custom_posts->have_posts()) {
            $custom_posts->the_post();
            // Display custom post content
            the_title();
            the_content();
        }
        wp_reset_postdata(); // Reset post data
    }

    return ob_get_clean(); // Return buffered output
}
add_shortcode("custom_posts", "custom_posts_shortcode");

function add_custom_meta_box()
{
    add_meta_box(
        "custom-meta-box-id",
        "Custom Meta Box Title",
        "render_custom_meta_box",
        "post",
        "normal",
        "high"
    );
}

function render_custom_meta_box($post)
{
    // Add a nonce field
    wp_nonce_field("custom_meta_box_nonce", "custom_meta_box_nonce");

    // Render the content of the meta box
    $custom_field_value = get_post_meta($post->ID, "custom_field_name", true);
    echo '<input type="text" name="custom_field_name" value="' .
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
        !isset($_POST["custom_meta_box_nonce"]) ||
        !wp_verify_nonce(
            $_POST["custom_meta_box_nonce"],
            "custom_meta_box_nonce"
        )
    ) {
        return;
    }

    // Sanitize and save the meta box data
    $custom_field_value = sanitize_text_field($_POST["custom_field_name"]);
    update_post_meta($post_id, "custom_field_name", $custom_field_value);
}

add_action("save_post", "save_custom_meta_box");
