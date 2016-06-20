<?php	
	if($_POST['tax_query']){
		$args_ajax = array(
			'posts_per_page'   => $_POST['more_count'],
			'orderby'          => 'date',
			'order'            => 'DESC',
			'post_type'        => 'portfolio',
			'tax_query' => array(
				array(
					'taxonomy' => 'portfolio_categories',
					'field' => 'term_id',
					'terms' => $_POST['portfolio_cat'],
				)
			),
			'offset'           => $_POST['offset'],
			'post_status'      => 'publish',
			'suppress_filters' => true
		);
	}else{
		$args_ajax = array(
			'posts_per_page'   => $_POST['more_count'],
			'orderby'          => 'date',
			'order'            => 'DESC',
			'post_type'        => 'portfolio',
			'offset'           => $_POST['offset'],
			'post_status'      => 'publish',
			'suppress_filters' => true
		);				
	}	
    $posts_array = get_posts( $args_ajax );
    if($posts_array): $i= -1;
		$section_item_count = $_POST['section_item_count'];
        foreach($posts_array as $post):setup_postdata($post);
            $alt = rscard_the_attached_image_alt();
            $content = get_field('content');
            $outer_link = get_field('outer_link');
            $terms = get_the_terms( get_the_ID(), 'portfolio_categories' );
            $image_size = get_field('image_size');
            $term_slug = '';
            $term_name = '';
			if($terms){
				foreach($terms as $term_item){
					$term_slug .= $term_item->slug.' ';
					$term_name .= $term_item->name.' ';
				}
			}
            if($image_size== 'Big'){
                $size_class = 'size22';
                $image_size = 'rs-card-portfolio-big';
            }else{
                $size_class = 'size11';
                $image_size = 'rs-card-portfolio-small';
            }
?>
<div class="grid-item <?php echo esc_attr($size_class);?> <?php echo esc_attr($term_slug);?>">
    <div class="grid-box">
        <figure class="portfolio-figure">
            <?php
            if(has_post_thumbnail(get_the_ID())):
                $image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), $image_size, false);
                ?>
                <img src="<?php echo esc_url($image[0]);?>" alt="<?php echo esc_attr($alt);?>"/>
            <?php endif;?>
            <figcaption class="portfolio-caption">
                <div class="portfolio-caption-inner">
                    <h3 class="portfolio-title"><?php the_title();?></h3>
                    <h4 class="portfolio-cat"><?php echo esc_html($term_name);?></h4>
                    <?php if($content || $outer_link):?>
                        <div class="btn-group">
                            <?php if($outer_link):?>
                                <a class="btn-link" target="_blank" href="<?php echo esc_url($outer_link);?>"><i class="rsicon rsicon-link"></i></a>
                            <?php
                            endif;
                            if($content): $j=1;
                                foreach($content as $cont):
                                    if($j==1){
                                        $class = 'btn-zoom';
                                    }else{
                                        $class = 'hidden';
                                    }
                                    ?>
                                    <a class="portfolioFancybox <?php echo esc_attr($class);?>" data-fancybox-group="portfolioFancybox<?php echo intval($section_item_count),intval($i);?>" href="#portfolio<?php echo intval($section_item_count),intval($i);?>-inline<?php echo intval($j);?>"><?php if($j==1):?><i class="rsicon rsicon-eye"></i><?php endif;?></a>
                                    <?php $j++; endforeach;?>
                            <?php endif;?>
                        </div>
                    <?php endif;?>
                </div>
            </figcaption>
        </figure>
        <?php
        if($content): $j=1;
            foreach($content as $cont):
                if($cont['video_poster']):
                    $poster = $cont['video_poster'];
                else:
                    $poster = '';
                endif;
                ?>
                <div id="portfolio<?php echo intval($section_item_count),intval($i);?>-inline<?php echo intval($j);?>" class="fancybox-inline-box">
                    <?php if($cont['popup_header'] && $cont['popup_header'] == 'Image' && $cont['image']):?>
                        <div class="inline-embed" data-embed-type="image" data-embed-url="<?php echo esc_url($cont['image']['url']);?>"></div>
                    <?php elseif($cont['popup_header'] && $cont['popup_header'] == 'Video Upload' && ($cont['mp4_file'] || $cont['webm_file'] || $cont['ogv_file'])):?>                        
						<div class="inline-embed" data-embed-type="video">
							<video poster="<?php echo esc_url($poster);?>" controls="controls" preload="none">
								<?php if($cont['mp4_file']):?>
									<source type="video/mp4" src="<?php echo esc_url($cont['mp4_file']);?>" />
								<?php
								endif;
								if($cont['webm_file']):
									?>
									<source type="video/webm" src="<?php echo esc_url($cont['webm_file']);?>" />
								<?php
								endif;
								if($cont['ogv_file']):
									?>
									<source type="video/ogg" src="<?php echo esc_url($cont['ogv_file']);?>" />
								<?php endif;?>
							</video>
						</div>                       
                    <?php elseif($cont['popup_header'] && $cont['popup_header'] == 'Video Iframe' && $cont['iframe_url']):?>
                        <div class="inline-embed" data-embed-type="iframe" data-embed-url="<?php echo esc_url($cont['iframe_url']);?>"></div>
                    <?php endif;?>
                    <?php if($cont['title'] || $cont['description']):?>
                        <div class="inline-cont">
                            <?php if($cont['title']):?>
                                <h2 class="inline-title"><?php echo esc_html($cont['title']);?></h2>
                            <?php
                            endif;
                            if($cont['description']):
                                ?>
                                <div class="inline-text">
                                    <?php echo wp_kses_post($cont['description']);?>
                                </div>
                            <?php endif;?>
                        </div>
                    <?php endif;?>
                </div>
					
				<?php
                $j++;
            endforeach;
        endif;
        ?>
    </div>
</div>
<?php
    $i--;
        endforeach;
    endif;exit;
?>