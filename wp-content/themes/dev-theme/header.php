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
                <li><a href="#about">About</a></li>
                <li><a href="#projects">Projects</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
    </header>
    <main>