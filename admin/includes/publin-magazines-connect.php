<?php
function add_post_meta_boxes() {
    // see https://developer.wordpress.org/reference/functions/add_meta_box for a full explanation of each property
    add_meta_box(
        "post_metadata_magazine_pages", // div id containing rendered fields
        "Pagina's", // section heading displayed as text
        "get_magazine_pages", // callback function to render fields
        "publin_magazines", // name of post type on which to render fields
        "normal", // location on the screen
        "low" // placement priority
    );

    add_meta_box(
        "pages_parent_id", // div id containing rendered fields
        "Page Parent", // section heading displayed as text
        "set_parent_magazine_id", // callback function to render fields
        "publin_magazinepages", // name of post type on which to render fields
        "normal", // location on the screen
        "low" // placement priority
    );

   
}
add_action( "admin_init", "add_post_meta_boxes" );

add_action( 'save_post', 'magazine_save_pages_order', 10, 2 );

function save_post_meta_boxes($data){
    global $post;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( get_post_status( $post->ID ) === 'auto-draft' ) {
        return;
    }
}
add_action( 'save_post', 'save_post_meta_boxes' );


// * Loop door de pagina's van de magazine
function get_magazine_pages(){
    global $post;
    $postID = get_the_ID();
    $args = [
        'post_parent'         => $postID,
        'post_type'           => 'publin_magazinepages',
        'meta_key' => 'page_order',
        'orderby' => 'meta_value_num',
        'order'               => 'ASC',
        'posts_per_page'       => -1,
        // Add additional arguments
    ];
    $q = new WP_Query( $args );
    $pages = get_posts( $args );
      
    $html = '<ul id="sortable">';
    $count = 0;
     if ( $q->have_posts() ) :
            foreach ( $pages as $page ) : setup_postdata( $page ); 
            $html .= '<li class="ui-state-default"><p>'.$page->post_title.'</p><p class="buttons"><a href="'.site_url().'/wp-admin/post.php?post='. $page->ID .'&action=edit" class="btn btn-edit"><i class="fas fa-magic"></i></a><a href="'.site_url().'/publin_magazinepages/'. $page->post_name .'/?fl_builder" class="btn btn-edit"><i class="fas fa-hammer"></i></a></p><input type="hidden" name="post_'.$page->ID.'" class="order" value="'.$count.'"></li>';
            endforeach; 
            wp_reset_postdata();
    endif;
    $html .= '<li class="addpage"><a href="'.site_url().'/wp-admin/post-new.php?post_type=publin_magazinepages&post_parent='.$postID.'"><i class="fas fa-plus"></i></a></li>';
    $html .= '</ul>';   

    // * Echo de HTML code met de lijst van pagina's
    echo $html;
}

// * Bij aanmaken van pagina vanuit magazine voeg magazine id toe als post_parent
function set_parent_magazine_id(){
    global $post;
    $custom = get_post_custom( $post->ID );
    $post_parent = 0;

    if(!empty($_GET['post_parent'])){
        $post_parent = $_GET['post_parent'];
    }else if(!empty($post->post_parent)){
        $post_parent = $post->post_parent;
    }
    
    echo '<input type="text" value="'.$post_parent.'" name="post_parent">';
    
    if(!empty($_GET['post_parent'])) {

        echo '<input type="hidden" value="'. $_GET['post_parent'] .'" name="post_parent">';
    }
  

}

function wpa_insert_post( $data , $postarr ){ 
    //do something with $data['post_parent']
    $data['post_parent'] = intval($postarr['post_parent']);

    return $data;
}
add_filter( 'wp_insert_post_data' , 'wpa_insert_post' , '99', 2 );

add_action( 'save_post', 'page_add_order_meta', 10, 2 );
// * VOEG META TOE VOOR ORDENEN VAN PAGINAS
function page_add_order_meta($id) {
    if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
        return $id;
    } // end if

    if('publin_magazinepages' == $_POST['post_type']) {
        if(!current_user_can('edit_page', $id)) {
            return $id;
        } // end if
    } else {
        if(!current_user_can('edit_page', $id)) {
            return $id;
        } // end if
    } // end if

    add_post_meta($id, 'page_order', 0);
}

add_action( 'save_post', 'magazine_save_pages_order', 10, 2 );
//  * SAVE CUSTOM VOLGORDE PAGINAS
function magazine_save_pages_order($id){
    if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
            return $id;
        } // end if
    
    if('magazines' == $_POST['post_type']) {
        if(!current_user_can('edit_page', $id)) {
            return $id;
        } // end if
    } else {
        if(!current_user_can('edit_page', $id)) {
            return $id;
        } // end if
    } // end if

    $args = [
        'post_parent'         => $post->ID,
        'post_type'           => 'publin_magazinepages',
        'order'               => 'ASC',
        'posts_per_page'       => -1,
        // Add additional arguments
    ];
    $q = new WP_Query( $args );

    $count = 0;
    
    if ( $q->have_posts() ) :
       while ( $q->have_posts() ) : $q->the_post();    
           $count++;
           $pageID = get_the_ID();
           $inputName = 'post_'.$pageID;

           if(!empty($_POST[$inputName])){
                add_post_meta($pageID, 'page_order', $_POST[$inputName]);
                update_post_meta($pageID, 'page_order', $_POST[$inputName]);
           }
        endwhile;
   endif;
   wp_reset_query();
}