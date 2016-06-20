<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element.
 *
 * @package WordPress
 * @subpackage Rs-Card
 * @since Rs-Card 1.0
 */
$rscard_options = get_option('rscard_options');
if($rscard_options['color-scheme']){
    $class_color = $rscard_options['color-scheme'];
}elseif($rscard_options['primary-color']){
    $class_color = str_ireplace("#","",$rscard_options['primary-color']);
    $class_color = 'color-'.$class_color;
}else{
    $class_color = 'color-e8676b';
}
if($rscard_options["skin-style"]=="dark-skin"){
    $class_skin = ' theme-skin-dark';
}else {
    $class_skin = ' light_skin';
}
$has_lang = false;
if (class_exists('SitePress')) {
	$has_lang = true;
}
$has_sidebar = $rscard_options['enable-side-menu'];
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> class="theme-<?php echo esc_attr($class_color);?><?php echo esc_attr($class_skin);?>">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

    <?php if( (! function_exists( 'has_site_icon' ) || ! has_site_icon()) && isset($rscard_options['favicon']['url']) && $rscard_options['favicon']['url'] != '' ):?>
        <link rel="icon" href="<?php echo esc_url($rscard_options['favicon']['url']);?>">
    <?php endif;?>
    <?php wp_head();?>
</head>

<body <?php body_class();?>>

<div class="mobile-nav">
    <button class="btn-mobile mobile-nav-close"><i class="rsicon rsicon-close"></i></button>
    <div id="mobile-nav" class="mobile-nav-inner">
        <?php get_template_part('inc/components/navigation'); ?>
    </div>
</div>

<?php if(!is_single() && $rscard_options['enable-side-menu']): get_sidebar(); endif; ?>

<div class="wrapper">
    <header class="header">
        <?php if($header_image = get_field('header_image')):?>
			<div class="head-bg" style="background-image: url('<?php echo esc_url($header_image);?>')"></div>
		<?php elseif ( isset($rscard_options['header-image']) && $rscard_options['header-image']['url'] != '' ):?>
            <div class="head-bg" style="background-image: url('<?php echo esc_url($rscard_options['header-image']['url']);?>')"></div>
        <?php endif; ?>				
        <div class="head-bar<?php if($has_lang):?> has-lang<?php endif;?><?php if($has_sidebar):?> has-sidebar<?php endif;?>">
            <div class="head-bar-inner">
                <div class="row">
                    <div class="col-lg-2 col-md-3 col-xs-6">
                        <?php if ((isset($rscard_options['logo-image']) || isset($rscard_options['logo-image-sticky'])) && ($rscard_options['logo-image']['url'] != '' || $rscard_options['logo-image-sticky']['url'] != '')):?>
							<?php if (isset($rscard_options['logo-image-sticky']) && $rscard_options['logo-image-sticky']['url'] != ''):
									$class = ' logo-has-second';
									$class_first = ' class= logo-first';									
								else:
									$class = '';
									$class_first = '';
								endif;
							?>
                            <a class="logo<?php echo esc_attr($class)?>" href="<?php echo esc_url( home_url( '/' ) ); ?>">
								<?php if (isset($rscard_options['logo-image']) && $rscard_options['logo-image']['url'] != ''):?>
									<img <?php echo esc_attr($class_first);?> src="<?php echo esc_url($rscard_options['logo-image']['url']);?>" alt="<?php echo esc_html(get_bloginfo('name'));?>"/>
								<?php endif;?>
								<?php if (isset($rscard_options['logo-image-sticky']) && $rscard_options['logo-image-sticky']['url'] != ''):?>
									<img class="logo-second" src="<?php echo esc_url($rscard_options['logo-image-sticky']['url']);?>" alt="<?php echo esc_html(get_bloginfo('name'));?>"/>
								<?php endif;?>
							</a>
                        <?php elseif($rscard_options['logo-text-first'] || $rscard_options['logo-text-second']):?>
                            <a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
								<?php
									if($rscard_options['logo-text-first']) echo '<span>'.esc_html($rscard_options['logo-text-first']).'</span>';
									if($rscard_options['logo-text-second']) echo esc_html($rscard_options['logo-text-second']);	
								?>
                            </a>
                        <?php else:?>
							<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php esc_html(bloginfo('name'))?></a></h1>
							<h2 class="site-descr"><?php esc_html(bloginfo('description'))?></h2>
						<?php endif;?>
                    </div>

                    <div class="col-lg-10 col-md-9 col-xs-6">
						<div class="head-cont clearfix">
							<button class="btn-mobile btn-mobile-nav"><?php esc_html_e('Menu','rs-card');?></button>														
							
							<?php if( $has_lang || $has_sidebar ){ ?>
							<div class="head-items">
								<?php if( $has_lang ){
									rs_card_languages_list();
								} ?>
								
								<?php if(!is_singular('post') && $has_sidebar):?>
									<button class="btn-sidebar btn-sidebar-open"><i class="rsicon rsicon-menu"></i></button>
								<?php endif;?>
							</div>
							<?php } ?>
																																								
							<div id="head-nav" class="head-nav">
								<?php get_template_part('inc/components/navigation');?>                           
							</div>																																	
						</div>
					</div>
                </div>
            </div>
        </div>
    </header>

    <div class="content">
        <div class="container">