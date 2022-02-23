<?php
/**
 * Post rendering content according to caller of get_template_part
 * 
 * 
 *                                NOTE TO SELF: THIS IS THE POST ARCHIVE (David Stockdale)
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">

		<?php
		the_title(
			sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
			'</a></h2>'
		);
		?>

<!-- 		<?php if ( 'post' === get_post_type() ) : ?>

			<div class="entry-meta">
				<?php understrap_posted_on(); ?>
			</div>

		<?php endif; ?> -->

	</header><!-- .entry-header -->

<!-- 	<?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?> -->

	<div class="entry-content">

		<div class="d-flex flex-row"> 
	
		
		<!-- 	CHANGED TO THUMBNAIL SIZE -->
<!-- 	NEED TO GET THUMBNAIL TO LEFT OF ENTRY-CONTENT -->
	<?php echo get_the_post_thumbnail( $post->ID, 'thumbnail' ); ?>
		<div class="excerpt flex-grow-1">
		<?php the_excerpt(); ?>
		</div>
		<?php
		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
				'after'  => '</div>',
			)
		);
		?>
		
	</div>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'understrap' ) );
			if ( $categories_list && understrap_categorized_blog() ) {
				/* translators: %s: Categories of current post */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %s', 'understrap' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}
		}
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'understrap' ) );
			if ( $tags_list ) {
				/* translators: %s: Tags of current post */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %s', 'understrap' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		?>

	</footer><!-- .entry-footer -->
<p>Posted on <?php echo get_the_date(); ?></p>
</article><!-- #post-## -->
