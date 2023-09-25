<?php
function enqueue_custom_styles()
{
    wp_enqueue_style(
        "custom-style",
        get_template_directory_uri() . "/style.css"
    );
}
add_action("wp_enqueue_scripts", "enqueue_custom_styles");

function register_custom_menu()
{
    register_nav_menu("primary-menu", __("Primary Menu"));
}
add_action("after_setup_theme", "register_custom_menu");

function get_menu_items_by_registered_slug($menu_slug)
{
    $menu_items = [];

    if (
        ($locations = get_nav_menu_locations()) &&
        isset($locations[$menu_slug])
    ) {
        $menu = get_term($locations[$menu_slug]);

        $menu_items = wp_get_nav_menu_items($menu->term_id);
    }

    return $menu_items;
}

?>
