<?php 
if(get_post_type($page_id) == 'publin_magazines') {
$fontImport = get_post_meta( $page_id, 'pmb_font', true );
$fontFamily = get_post_meta( $page_id, 'pmb_fontFamily', true );
$menuBackground = get_post_meta( $page_id, 'pmb_menuBackground', true );
$menuTextColor = get_post_meta( $page_id, 'pmb_menuTextColor', true ); 
$menuBarBackground = get_post_meta( $page_id, 'pmb_menubarBackground', true );
$menuBarColor = get_post_meta( $page_id, 'pmb_menubarTextColor', true );
$navButtonBackground = get_post_meta( $page_id, 'pmb_navButtonBackground', true );
$navButtonColor = get_post_meta( $page_id, 'pmb_navButtonColor', true );
}
?>


body {
    font-family: <?php echo $fontFamily; ?> !important;
}

#pagemenu {
    background-color: <?php echo $menuBackground; ?>;
    color: <?php echo $menuTextColor; ?>;
}

#menuBar__inner, #menuBar__inner .magazinesButtons .menuBarButton {
    color: <?php echo $menuBarColor; ?>;
}

#menuBar {
    background-color: <?php echo $menuBarBackground; ?>;
}

#navigation #navigation__inner .navigation__buttons .navButton {
    background-color: <?php echo $navButtonBackground; ?>;
    color: <?php echo $navButtonColor; ?>;
}