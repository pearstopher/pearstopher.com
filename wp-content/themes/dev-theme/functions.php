<?php
function enqueue_custom_styles()
{
    wp_enqueue_style(
        "custom-style",
        get_template_directory_uri() . "/styles.css"
    );
}
add_action("wp_enqueue_scripts", "enqueue_custom_styles");
?>
