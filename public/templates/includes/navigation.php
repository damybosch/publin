<div id="menuBar" class="<?php echo $menuBarPosition; ?>">
    <div id="menuBar__inner">
        <div class="magazineLogo">
            <img src="<?= $logo['url']; ?>" alt="">
        </div>
        <div class="magazineTitle">
            <?php the_title(); if(!empty($magazineSubtitle)){ echo ' - ' . $magazineSubtitle; }; ?>
        </div>
        <div class="magazinesButtons">
            <?php 
                
                foreach($menuBarButtons as $menuBarButton) {
                    if($menuBarButton == 'startpagina') { 
                        $html = '<div class="homeButton menuBarButton"><i class="fal fa-home"></i></div>';
                    }
                    if($menuBarButton == 'website') { 
                        $html = '<a href="'. $website .'" target="_blank" class="websiteButton menuBarButton"><i class="fal fa-external-link"></i></a>';
                    }
                    if($menuBarButton == 'menuicoon') { 
                        $html = '<div class="menuButton menuBarButton"><i class="fal fa-align-right"></i></div>';
                    }
                    echo $html;
                }
            
            ?>
        </div>
    </div>
</div>
<div id="navigation">
    <div id="navigation__inner">
        <div class="navigation__buttons <?php echo $navTemplate; ?>">
            <div id="nextPage" class="navButton"><i class="fal fa-angle-right"></i></div>
            <div id="prevPage" class="navButton"><i class="fal fa-angle-left"></i></div>
        </div>
    </div>
</div>

<div id="pagemenu" class="<?php echo $menuBarPosition; ?>">
<div id="pagemenuInner">
    <?php 
        $args = array(
        'post_type' => 'publin_magazinepages',
        'post_parent' => $page_id,
        'meta_key' => 'page_order',
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
        'depth'          => 5,
        'posts_per_page' => -1
        );

        $query = new WP_Query($args);
        ?>
    <div class="menuItems">
        <?php
        if ( $query->have_posts() ) {
            $pagecount = 0;
            while ( $query->have_posts() ) {
                $query->the_post(); 
                $pagecount++;
                $pageSubtitle = get_post_meta( get_the_id(), 'pmb_subTitle', true ) ;
                $showSubtitle = get_post_meta( $page_id, 'pmb_subtitleInMenu', true ) ;
                $showPageCounter = get_post_meta( $page_id, 'pmb_pageCount', true ) ;
                ?>
                <div class="menuItem" data-pagecount="<?php echo $pagecount; ?>">
                    <div class="menuItemInner">
                        
                        <?php
                        if($thumbnailInMenu) { ?>
                        <div class="menuItem__thumbnail" style="background-image: url('<?php echo get_the_post_thumbnail_url(); ?>');">
                        </div>
                        <?php } ?>
                        <div class="menuItem__content">
                        <?php if($showPageCounter) { ?>
                            <div class="menuItem__content--pagecounter">
                                <?php echo $pagecount; ?>
                            </div>
                            <?php } ?>
                            <div class="menuItem__content--title"><?php the_title(); ?> </div>
                            <?php if($showSubtitle) { ?>
                            <div class="menuItem__content--subtitle"><?php  echo $pageSubtitle; ?></div>
                            <?php } ?> 
                        </div>
                    </div>
                </div>
                
            <?php
            } // end while
        } // end if
    ?>
    </div>
    </div>
</div>