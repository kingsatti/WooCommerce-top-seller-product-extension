<?php
/**
 * Plugin Name: Qaisar Satti Top Seller
 * Plugin URI: https://store.qaisarsatti.com
 * Description: Get the top seller product collection.
 * Version: 1.0.0
 * Text Domain: Qaisar Satti Store
 * Author: Qaisar Satti
 * Author URI: https://store.qaisarsatti.com
 */
 if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) ) {
	function qaisarsatti_topseller_admin_notice() {
		$covid19_allowed_tags = array(
			'a' => array(
				'class' => array(),
				'href'  => array(),
				'rel'   => array(),
				'title' => array(),
			),
			'b' => array(),
			'div' => array(
				'class' => array(),
				'title' => array(),
				'style' => array(),
			),
			'p' => array(
				'class' => array(),
			),
			'strong' => array(),
		);
		// Deactivate the plugin
		deactivate_plugins(__FILE__);
		$covid19_woo_check = '<div id="message" class="error">
			<p><strong>Topseller plugin is inactive.</strong> The <a href="http://wordpress.org/extend/plugins/woocommerce/">WooCommerce plugin</a> must be active for this plugin to work. Please install &amp; activate WooCommerce »</p></div>';
		echo wp_kses( __( $covid19_woo_check, 'qaisarsatti-topseller' ), $covid19_allowed_tags);
	}
	add_action('admin_notices', 'qaisarsatti_topseller_admin_notice');
}


 function qaisarsatti_topseller($atts){	
	ob_start();
	$queryargs = array(
	    'post_type' => 'product',
	    'meta_key' => 'total_sales',
	    'orderby' => 'meta_value_num',
	    'order' => 'DESC',
	    'post_status' => 'publish',
	    'posts_per_page' => 10,
	);

	$query = new WP_Query( $queryargs );

	?>
		<div class="woocommerce">
			<h3><?php echo esc_html( __( 'Top Seller Products', 'qaisarsatti_topseller' ) ); ?></h3>
			<ul class="products columns-<?php echo esc_attr( wc_get_loop_prop( 'columns' ) ); ?>">
				<?php
					while ( $query->have_posts() ) {

				    	$query->the_post(); 

				    	$totalSales =   get_metadata( 'post', $query->post->ID, 'total_sales', true );

				    	if($totalSales){

				   			if($totalSales[0] > 0) {

								wc_get_template_part( 'content', 'product' );

							}

						}

					} 

				?> 
			</ul>
		</div>
	<?php
	return ob_get_clean();
}

add_shortcode('qaisarsatti-topseller', 'qaisarsatti_topseller');