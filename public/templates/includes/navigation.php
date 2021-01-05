<div id="menuBar">
    <div id="menuBar__inner">
        <div class="magazineLogo">
            <img src="<?= $logo['url']; ?>" alt="">
        </div>
        <div class="magazineTitle">

        </div>
        <div class="magazinesButtons">
            <?php 

                foreach($menuBarButtons as $menuBarButton) {
                    if($menuBarButton == 'startpagina') { 
                        $html = '<div class="homeButton menuBarButton"><i class="fal fa-home"></i></div>';
                    }
                    if($menuBarButton == 'website') { 
                        $html = '<a href="'. $website .'" target="_blank" class="websiteButton menuBarButton"><i class="fal fa-sign-out"></i></a>';
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
        <div class="navigation__buttons">
            <div id="nextPage" class="navButton"><i class="fal fa-angle-right"></i></div>
            <div id="prevPage" class="navButton"><i class="fal fa-angle-left"></i></div>
        </div>
    </div>
</div>

<div id="pagemenu">
    <?php 
        $args = array(
        'post_type' => 'publin_magazinepages',
        'post_parent' => $page_id,
        'order' => 'ASC',
        'depth'          => 5,
        'posts_per_page' => -1
        );

        $query = new WP_Query($args);

        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post(); 
                //
                echo get_the_title();
                //
            } // end while
        } // end if
    ?>
</div>