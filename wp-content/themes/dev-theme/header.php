<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="<?php bloginfo("charset"); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo get_bloginfo("name"); ?> | <?php echo get_bloginfo(
     "description"
 ); ?></title>
    <script type="text/javascript">
    window.onload = function() {

    // Get a reference to the element you want to fix
    var element = document.getElementById('header-nav');

    // Get the original position of the element
    var scrollPosition = window.scrollY || window.pageYOffset;
    var originalPosition = element.getBoundingClientRect().top + scrollPosition;



    // Add an event listener to track scroll position
    window.addEventListener('scroll', function() {
        // Get the current scroll position
        var scrollPosition = window.scrollY || window.pageYOffset;

        // Check if the element is at or above the top of the page
        if (scrollPosition >= originalPosition) {
            // Set the element's position to fixed
            element.style.position = 'fixed';
            element.style.top = '0';
            element.style.left = '0';
            element.style.width = '100%';
            element.style.background = '#333';
            element.style.margin = 'auto';
        } else {
            // Set the element's position back to its original spot
            element.style.position = 'static';
        }
    });

    }
    </script>
    <?php wp_head(); ?>

</head>

<body>
    <header>
        <img alt="" src="https://pearstopher.com/wp-content/uploads/2020/09/pear_cutout_125.png" />
         <h1 class="site-title"><?php echo get_bloginfo("name"); ?></h1>
         <p class="site-description"><?php echo get_bloginfo(
             "description"
         ); ?></p>
        <div id="nav-wrapper">
        <nav id="header-nav">
            <ul>
                <?php
                $menu_name = "primary-menu"; // Replace with the name of your menu
                $menu_items = get_menu_items_by_registered_slug($menu_name);

                if ($menu_items) {
                    foreach ($menu_items as $item) {
                        $title = $item->title; // Get the title of the menu item
                        $url = $item->url; // Get the URL of the menu item
                        $target = $item->target; // Get the target attribute (e.g., _blank for new tab)
                        $ID = $item->ID; // this is the menu id not the page id

                        // Only grab page IDs
                        if ("page" !== $item->object) {
                            continue;
                        }
                        $page_id = $item->object_id;

                        // Output the menu item
                        echo "<li><a href='#$page_id' target='$target'>$title</a></li>";
                    }
                } else {
                    echo "<li>Menu not found.</li>";
                }
                ?>

            </ul>
        </nav>
        </div>
    </header>
    <main>
