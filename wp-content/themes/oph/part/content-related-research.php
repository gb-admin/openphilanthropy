<?php

/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package OPH
 */

$related = $related;

$related_link = get_permalink($related->ID);
$related_title = $related->post_title;

$related_linkExternally = get_field('externally_link', $related->ID);

if ($related_linkExternally) {
    $related_link = get_field('external_url', $related->ID);
}

// This code causes page not to load when no focus area is set for the post. These vars are never used though, only declared. 
//$research_focus_area = get_the_terms( $related->ID, 'focus-area' )[0];
//$first_parent_term = get_term_top_most_parent($research_focus_area,'focus-area');

$related_eyebrow_copy = '';
$related_eyebrow_link_url = '';

$research_content_type = get_the_terms($related->ID, 'content-type')[0];
$related_eyebrow_copy = $research_content_type->name;

if ($research_content_type && $research_content_type->slug) {
    $related_eyebrow_link_url = get_home_url(null, '/research/?content-type=', 'https') . $research_content_type->slug;
}

if (has_excerpt($related->ID)) {
    $related_excerpt_source = get_the_excerpt($related->ID);
} else {
    $related_excerpt_source = get_post_field('post_content', $related->ID);
}

$related_excerpt = array(
    'append' => '...',
    'limit' => 28,
    'limitby' => 'word',
    'source' => $related_excerpt_source
);

$related_description = excerpt($related_excerpt);

$title = get_field('custom_title', $related->ID) ? get_field('custom_title', $related->ID) : $related_title;
$description = get_field('custom_description', $related->ID) ? get_field('custom_description', $related->ID) : '<p>' . $related_description . '</p>';
$link = get_field('custom_link', $related->ID) ? get_field('custom_link', $related->ID) : $related_link;
$eyebrow_copy = get_field('custom_title', $related->ID) ? get_field('custom_eyebrow_copy', $related->ID) : $related_eyebrow_copy;
$eyebrow_link = get_field('custom_eyebrow_link', $related->ID) ? get_field('custom_eyebrow_link', $related->ID) : $related_eyebrow_link_url;
?>

<li>
    <h5>
        <a href="<?php echo $eyebrow_link; ?>"><?php echo $eyebrow_copy; ?></a>
    </h5>

    <h3>
        <a href="<?php echo esc_url($link); ?>"><?= $title ?></a>
    </h3>

    <div class="single-related-posts__description">
        <?php echo $description; ?>
    </div>

    <div class="single-related-posts__link">
        <a href="<?php echo esc_url($link); ?>">
            Read more <svg viewBox="0 0 25 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M15.352 1l7.395 7.5-7.395 7.5M1 8.397l21.748.103" stroke="#6e7ca0" stroke-width="2" />
            </svg>
        </a>
    </div>
</li>