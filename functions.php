<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementorChild
 */

/**
 * Load child theme css and optional scripts
 *
 * @return void
 */
function hello_elementor_child_enqueue_scripts() {
	wp_enqueue_style(
		'hello-elementor-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[
			'hello-elementor-theme-style',
		],
		'1.0.0'
	);
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_enqueue_scripts', 20 );

/**
 * remove page title
 */
add_filter( 'hello_elementor_page_title', '__return_false' );

/**
 * remove home from woocommerce breadcrumb 
 */

add_filter('woocommerce_breadcrumb_defaults', function( $defaults ) {
    unset($defaults['home']); //removes home link.
    return $defaults; //returns rest of links
});

/**
 * change the breadcrumb separator
 */
add_filter( 'woocommerce_breadcrumb_defaults', 'wcc_change_breadcrumb_delimiter' );
function wcc_change_breadcrumb_delimiter( $defaults ) {
	// Change the breadcrumb delimeter from '/' to '>'
	$defaults['delimiter'] = '<span class="sep">&gt;</span>';
	return $defaults;
}

/**
 * request a Quote button shortcode
 */
function render_quote_button( $atts ) {
	$html_render  = '<div class="yith-ywraq-add-to-quote add-to-quote-' . get_the_ID() . '">';
	$html_render .= '<div class="yith-ywraq-add-button show" style="display:block">';
	$html_render .= '<a href="#" class="add-request-quote-button button"';
	$html_render .= 'data-product_id="' . get_the_ID() . '"'; 
	$html_render .= 'data-wp_nonce="' . wp_create_nonce( 'add-request-quote-' . get_the_ID() ) . '">';
	$html_render .= 'ขอใบเสนอราคา</a>';
	$html_render .= '<img src="/wp-content/plugins/yith-woocommerce-request-a-quote/assets/images/wpspin_light.gif" class="ajax-loading" alt="loading" width="16" height="16" style="visibility:hidden" />';
	$html_render .= '</div></div><div class="clear"></div>';

	return $html_render;
}
add_shortcode( 'adv_quote_button', 'render_quote_button' );

/**
 * browse the list label
 */
function adv_browse_list_label() {
	return 'ดูรายการทั้งหมด';
}
add_filter( 'ywraq_product_added_view_browse_list', 'adv_browse_list_label' );

/**
 * product already in the list label
 */
function adv_product_already_in_the_list_label() {
	return 'มีสินค้าในรายการอยู่แล้ว';
}
add_filter( 'ywraq_product_in_list', 'adv_product_already_in_the_list_label' );
add_filter( 'yith_ywraq_product_already_in_list_message', 'adv_product_already_in_the_list_label' );

/**
 * product added label
 */
function adv_product_added() {
	return 'เพิ่มสินค้าเรียบร้อย';
}
add_filter( 'yith_ywraq_product_added_to_list_message', 'adv_product_added' );

/**
 * custom product query
 */
function adv_custom_product_order_homepage( $query ) {
	// Here we set the query to fetch posts with
	// ordered by homepage order
	$query->set( 'orderby', 'meta_value' );
	$query->set( 'meta_key', 'homepage_order' );
}
add_action( 'elementor/query/hp_fusion_splicer', 'adv_custom_product_order_homepage' );
add_action( 'elementor/query/hp_testing_inspection', 'adv_custom_product_order_homepage' );
add_action( 'elementor/query/hp_fiber_blowing', 'adv_custom_product_order_homepage' );

/**
 * @snippet       Remove Additional Information Tab @ WooCommerce Single Product Page
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @testedwith    WooCommerce 3.8
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */
function bbloomer_remove_product_tabs( $tabs ) {
    unset( $tabs['additional_information'] ); 
    return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'bbloomer_remove_product_tabs', 9999 );

/**
* @snippet       Display FREE if Price Zero or Empty - WooCommerce Single Product
* @how-to        Get CustomizeWoo.com FREE
* @author        Rodolfo Melogli
* @testedwith    WooCommerce 3.8
* @donate $9     https://businessbloomer.com/bloomer-armada/
*/
  
function bbloomer_price_free_zero_empty( $price, $product ){
	if ( '' === $product->get_price() || 0 == $product->get_price() ) {
		$price = '';
	}
	return $price;
}
add_filter( 'woocommerce_get_price_html', 'bbloomer_price_free_zero_empty', 9999, 2 );