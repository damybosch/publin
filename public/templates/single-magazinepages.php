<?php get_header(); ?>

<div class="">
	<div class="">

		

		<div class="">
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					the_content();
				endwhile;
			endif;

			//$plugin_public->render_css();
			?>
		</div>


	</div>
</div>
<?php //include_once 'includes/navigation.php'; ?>
<?php get_footer(); ?>
