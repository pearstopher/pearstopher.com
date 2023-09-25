<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="<?php bloginfo("charset"); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo get_bloginfo("name"); ?> | <?php echo get_bloginfo(
     "description"
 ); ?></title>
    <?php wp_head(); ?>

</head>

<body>
    <header>
        <img alt="" src="https://pearstopher.com/wp-content/uploads/2020/09/pear_cutout_125.png" />
         <h1 class="site-title"><?php echo get_bloginfo("name"); ?></h1>
         <p class="site-description"><?php echo get_bloginfo(
             "description"
         ); ?></p>

        <nav>
            <ul>
                <?php
                $menu_name = "primary-menu"; // Replace with the name of your menu
                $menu_items = get_menu_items_by_registered_slug($menu_name);

                if ($menu_items) {
                    foreach ($menu_items as $item) {
                        $title = $item->title; // Get the title of the menu item
                        $url = $item->url; // Get the URL of the menu item
                        $target = $item->target; // Get the target attribute (e.g., _blank for new tab)
                        $ID = $item->ID; // Get the target attribute (e.g., _blank for new tab)

                        // Output the menu item
                        echo "<li><a href='#$ID' target='$target'>$title</a></li>";
                    }
                } else {
                    echo "<li>Menu not found.</li>";
                }
                ?>

            </ul>
        </nav>
    </header>
    <main>
