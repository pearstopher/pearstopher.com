<?php get_header(); ?>

<?php
$args = [
    "post_type" => "page", // Specify that you want to retrieve pages
    "posts_per_page" => -1, // Retrieve all pages
    "orderby" => "ID",
    "order" => "asc",
];

$pages_query = new WP_Query($args);

if ($pages_query->have_posts()) {
    while ($pages_query->have_posts()) {
        $pages_query->the_post();
        // Display the title and content of each page
        ?>
        <section id ="section-<?php the_ID(); ?>">
        <a class="anchor" id="<?php the_ID(); ?>"></a>
        <div class="section-header">
        <?php the_title("<h2>", "</h2>"); ?>
        </div>
        <div class="section-content">
        <?php the_content("<p>", "</p>"); ?>
        </div>
        </section>
        <?php
    }

    wp_reset_postdata(); // Reset the post data
} else {
    echo "No pages found.";
}
?>

<?php get_footer(); ?>
