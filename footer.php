<?php
/**
 * The template for displaying the footer
 *
 * @package WordPress
 * @subpackage Rs-Card
 * @since Rs-Card 1.0
 */
?>


</div>
</div>

<footer class="footer">
    <div class="footer-social">
        <?php
            $rscard_options = get_option('rscard_options');
            if($rscard_options['display-footer-socials']):
                get_template_part('inc/components/social');
            endif;
        ?>
    </div>
</footer>
</div>

<a href="#" class="btn-scroll-top"><i class="rsicon rsicon-arrow-up"></i></a>
<div id="overlay"></div>
<div id="preloader">
	<div class="preload-icon"><span></span><span></span></div>
	<div class="preload-text"><?php esc_html__('Loading...','rs-card') ?></div>
</div>
<?php wp_footer();?>
</body>
</html>
