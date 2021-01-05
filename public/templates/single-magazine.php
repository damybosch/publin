<?php 

wp_enqueue_script('publin-js');

    $page_id = get_the_ID();

    query_posts( array(
        'post_type' => 'publin_magazinepages',
        'post_parent' => $page_id,
        'order' => 'ASC',
        'depth'          => 5,
        'posts_per_page' => -1
    ) );
    
    // $navBtnIconPrev = get_post_meta( $page_id, 'navigation_btn_icon_prev', true );
    // $navBtnIconNext = get_post_meta( $page_id, 'navigation_btn_icon_next', true );

    // $logo = get_post_meta( $page_id, 'magazine_logo', true ) ; 
    //  $nav_position = get_post_meta( $page_id, 'navMenu_position', true ) ; 
    //  $menu_template = get_post_meta( $page_id, 'magazine_nav_menu_temp', true ) ; 
    //  $menu_options = get_post_meta( $page_id, 'magazine_nav_menu_options', true ) ; 

     function my_global_builder_posts( $post_ids ) {
         while( have_posts()) : the_post();
         global $post;
        $post_ids[] = $post->ID;

        endwhile;
        return $post_ids;
    }

    add_filter( 'fl_builder_global_posts', 'my_global_builder_posts' );
?>

<?php get_header(); ?>

<div class="fl-content ">
		<div id="pages" class="">
            <div id="pagesInner" class="owl-carousel">
        
                <?php


                $count = 0;
                if ( have_posts() ) :
                    while ( have_posts() ) :
                        the_post();



                    $count++;
                    global $post;
                    $post_slug = $post->post_name;
                ?>



                        <div class="item" data-hash="<?php echo $post_slug; ?>">
                            <div class="page magazine_page_<?php echo $post_slug; ?> count<?php echo $count; ?>" data-count="<?php echo $count; ?>" data-pagename="<?php echo $post_slug; ?>" >
                                <div id="result" class="pageContent">
                                <div class="loadingPage notLoading"></div>
                                </div>
                            </div>
                        </div>

                <?php
                    endwhile;
                endif;
                
                wp_reset_query();
                wp_reset_postdata();
                ?>
            </div> 
        </div>
</div>

<div class="pageLoading"></div>

<?php
//echo $nav_template;?>

<div id="prevPage">Vorige pagina</div><div id="nextPage">Volgende pagina</div>
<?php //include plugin_dir_path( __FILE__ ) . 'includes/navigation.php'; ?>


<?php get_footer(); ?>