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
        while ($custom_posts->have_posts()) {
            $custom_posts->the_post();
            // Display custom post content
            echo "<div class='projects'>";
            the_title();
            the_content();
            echo "</div>";
        }
        wp_reset_postdata(); // Reset post data
    }
    return ob_get_clean(); // Return buffered output
}
add_shortcode("custom_posts", "custom_posts_shortcode");

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
}

add_action("save_post", "save_custom_meta_box");
