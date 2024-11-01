<?php
if (!class_exists('OfbWidgetWooCartShipCalc')):

    class OfbWidgetWooCartShipCalc extends CbpWidget
    {

        public function __construct()
        {
            parent::__construct(
                    /* Base ID */'ofb_widget_woocart_shipcalc',
                    /* Name */ 'Woo Ship Calc', array('description' => 'This is a WooCommerce Shipping Calculator brick.', 'icon'        => 'fa fa-anchor fa-3x'));
        }

        public function registerFormElements($elements)
        {
            $elements = parent::registerFormElements($elements);

            return $elements;
        }

        public function form($instance)
        {
            parent::form($instance);
        }

        public function widget($atts, $content)
        {
            extract(shortcode_atts(array(
                        'type'               => 'ofb_widget_woocart_shipcalc',
                        'css_class'          => '',
                        'custom_css_classes' => '',
                        'padding'            => '',
                            ), $atts));
			
            $css_class          = !empty($css_class) ? ' ' . $css_class : '';
            $custom_css_classes = !empty($custom_css_classes) ? ' ' . $custom_css_classes : '';
            $padding            = CbpWidgets::getCssClass($padding);
            ?>			
			
            <div class="<?php echo CbpWidgets::getDefaultWidgetCssClass(); ?> <?php echo $type; ?> <?php echo $padding; ?><?php echo $custom_css_classes; ?><?php echo $css_class; ?>">
            <?php echo do_shortcode('[ofb_woocommerce_shipping_calc]'); ?>
            </div>

            <?php
        }
    }

CbpWidgets::registerWidget('OfbWidgetWooCartShipCalc');
	
endif;
