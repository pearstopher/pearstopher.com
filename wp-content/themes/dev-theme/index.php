<?php get_header(); ?>

<?php
$args = [
    "post_type" => "page", // Specify that you want to retrieve pages
    "posts_per_page" => -1, // Retrieve all pages
];

$pages_query = new WP_Query($args);

if ($pages_query->have_posts()) {
    while ($pages_query->have_posts()) {
        $pages_query->the_post();
        // Display the title and content of each page
        ?>
        <section id ="<?php the_ID(); ?>">
        <?php
        the_title("<h2>", "</h2>");
        the_content();
        ?>
        </section>
        <?php
    }

    wp_reset_postdata(); // Reset the post data
} else {
    echo "No pages found.";
}
?>

<?php get_footer(); ?>
