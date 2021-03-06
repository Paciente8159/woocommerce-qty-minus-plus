<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/Paciente8159
 * @since             1.0.0
 * @package           JCEM_Woocommerce_Qty_Minus_Plus
 *
 * @wordpress-plugin
 * Plugin Name:       JCEM Woocommerce Quantity Minus-Plus Controls
 * Plugin URI:        https://github.com/Paciente8159
 * Description:       Adds minus and plus controls to the quantity input off Woocommerce products add to cart.
 * Version:           1.0.0
 * Author:            Joao Martins
 * Author URI:        https://github.com/Paciente8159
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       woocommerce-qty-minus-plus
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */

add_action('woocommerce_before_quantity_input_field', function () {
    $content = "-";
    $content = apply_filters('jcem_wc_qty_minus_button', $content);
    $step = 1;
    $step = apply_filters('jcem_wc_qty_step', $step);
    $classes = "";
    $classes = apply_filters('jcem_wc_qty_classes', $classes);
?>
    <button class="qty-button qty-minus <?php echo $classes; ?>" data-inc="<?php echo $step; ?>"><?php echo $content; ?></button>
<?php
});

add_action('woocommerce_after_quantity_input_field', function () {
    $content = "+";
    $content = apply_filters('jcem_wc_qty_plus_button', $content);
    $step = 1;
    $step = apply_filters('jcem_wc_qty_step', $step);
    $classes = "";
    $classes = apply_filters('jcem_wc_qty_classes', $classes);
?>
    <button class="qty-button qty-plus <?php echo $classes; ?>" data-inc="<?php echo $step; ?>"><?php echo $content; ?></button>
<?php
});

add_filter('woocommerce_loop_add_to_cart_link', function ($link_html, $product, $args) {
    $content = "";
    if (function_exists('woocommerce_quantity_input')) {
        if ($product->is_in_stock()) {
            $content = woocommerce_quantity_input(
                array(
                    'min_value'   => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product),
                    'max_value'   => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
                    'input_value' => $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
                ),
                $product,
                false
            );
        }
    }

    $content .= $link_html;
    $content = apply_filters('jcem_wc_product_loop_qty_controls', $content, $link_html, $product, $args);

    return $content;
}, 10, 3);

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('woocommerce-qty-minus-plus', plugin_dir_url(__FILE__) . 'assets/css/woocommerce-qty-minus-plus.css', array());
    wp_enqueue_script('woocommerce-qty-minus-plus', plugin_dir_url(__FILE__) . 'assets/js/woocommerce-qty-minus-plus.js', array(), true, true);
});
