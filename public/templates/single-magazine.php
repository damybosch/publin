<?php 

$page_id = get_the_ID();
$logo = get_post_meta( $page_id, 'pmb_company-logo', true ) ;
$website = get_post_meta( $page_id, 'pmb_website', true ) ;
$thumbnailInMenu = get_post_meta( $page_id, 'pmb_thumbnailInMenu', true ) ;
$menuBarButtons = get_post_meta( $page_id, 'pmb_menubarbuttons', false ) ;
$magazineSubtitle = get_post_meta( $page_id, 'pmb_subTitle', true ) ;
$navTemplate = get_post_meta( $page_id, 'pmb_navigationTemplate', true ) ;
$menuBarPosition = get_post_meta( $page_id, 'pms_template', true ) ;

//wp_enqueue_script('publin-js');


    query_posts( array(
        'post_type' => 'publin_magazinepages',
        'post_parent' => $page_id,
        'meta_key' => 'page_order',
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
        'depth'          => 5,
        'posts_per_page' => -1
    ) );
    

    

    //print_r($menuBarButtons);
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
                <div class="page magazine_page_<?php echo $post_slug; ?> count<?php echo $count; ?>"
                    data-count="<?php echo $count; ?>" data-pagename="<?php echo $post_slug; ?>">
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

<?php include plugin_dir_path( __FILE__ ) . 'includes/navigation.php'; ?>


<?php get_footer(); ?>