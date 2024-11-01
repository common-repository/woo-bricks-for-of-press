<?php

/**
 * Plugin Name: Woo Bricks For OF Press
 * Plugin URI:  http://odysseyforge.com
 * Description: Enables the OF Press theme to use Drag and Drop Layout for WooCommerce Pages
 * Version:     1.0
 * Author:      Odyssey Forge
 * Author URI:  http://odysseyforge.com
 */

/**
 * Custom WooCommerce Shortcodes
*/

// Single Product Summary
function ofb_wc_product_summary(){
		while ( have_posts() ) : the_post();
			wc_get_template_part( 'content', 'single-product' );
		endwhile; // end of the loop.
}
add_shortcode('ofb_woocommerce_product_summary', 'ofb_wc_product_summary');

// Product Single Excerpt
function ofb_wc_product_single_excerpt() 
{	
	woocommerce_template_single_excerpt();
}

add_shortcode('ofb_woocommerce_product_single_excerpt', 'ofb_wc_product_single_excerpt');

// Product Loop Price
function ofb_wc_product_loop_price() {	
	woocommerce_template_single_price();
}

add_shortcode('ofb_woocommerce_product_loop_price', 'ofb_wc_product_loop_price');

// Product Loop Add To Cart Button
function ofb_wc_product_loop_cart() 
{	
	woocommerce_template_loop_add_to_cart();
}
add_shortcode('ofb_woocommerce_product_loop_cart', 'ofb_wc_product_loop_cart');

// Cart Totals Shortcode

function ofb_wc_cart_totals(  ){
 woocommerce_cart_totals();
}
add_shortcode('ofb_woocommerce_cart_totals', 'ofb_wc_cart_totals');

// Cart Shipping Calc Shortcode
function ofb_wc_ship_calc(  ){
 woocommerce_shipping_calculator();
}
add_shortcode('ofb_woocommerce_shipping_calc', 'ofb_wc_ship_calc');

// Custom WC Functions / Hooks / Filters
function get_product_id_by_sku( $sku ) {

  global $wpdb;



  $product_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", $sku ) );

  if ( $product_id ) return $product_id;

}

/**
 * Brick Functions and Registration
*/

add_action('register_cbp_widget', 'bricklayer_brick_woo_register_widget');
add_action('cbp_action_tabs', 'ofb_register_bricklayer_woo');
add_filter('cbp_filter_widget_settings', 'ofb_woo_filter_brick_settings', 10, 2);
add_filter('cbp_filter_disallow', 'ofb_woo_disallow_to_widget_panel');

function bricklayer_brick_woo_register_widget()
{
/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    // Product Bricks
    require_once 'bricks/ofb-brick-product-loop.php';
	require_once 'bricks/ofb-brick-product-loop-price.php';
	require_once 'bricks/ofb-brick-product-loop-cart.php';
	require_once 'bricks/ofb-brick-product-excerpt.php';	
	require_once 'bricks/ofb-brick-product-summary.php';
	require_once 'bricks/ofb-brick-product-link.php';
    // Cart Bricks
    require_once 'bricks/ofb-brick-woocart.php';
	require_once 'bricks/ofb-brick-woocart-totals.php';
	require_once 'bricks/ofb-brick-woocart-shipcalc.php';
}

}

function ofb_woo_disallow_to_widget_panel($disallowedWidgets)
{
    $disallowedWidgets[] = ''; //'ofb_advtabs_sub_item';

    return $disallowedWidgets;
}

function ofb_register_bricklayer_woo()
{
/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    CbpWidgets::registerTab(array(
        'id'       => 'ofb_tab_woocommerce',
        'type'     => 'widgets',
        'title'    => 'WooCommerce',
        'priority' => 150,
        'html'     => '',
    ));
}
    CbpWidgets::unregisterTab('cbp_tab_help');
}

function ofb_woo_filter_brick_settings($settings, $widgetType)
{
    if 	(($widgetType == 'ofb_widget_wc_product_loop') ||
		 ($widgetType == 'ofb_widget_product_loop_price') ||
		 ($widgetType == 'ofb_widget_product_loop_cart') ||
		 ($widgetType == 'ofb_widget_product_summary') ||
		 ($widgetType == 'ofb-link-to-product') ||		 
		 ($widgetType == 'ofb_widget_product_excerpt') ||		 
		 ($widgetType == 'ofb_widget_woocart') ||
		 ($widgetType == 'ofb_widget_woocart_totals') ||
		 ($widgetType == 'ofb_widget_woocart_shipcalc')		 
		 )

	{
        $settings['display']['backend']['tab'] = 'ofb_tab_woocommerce';
    }

    return $settings;
}
