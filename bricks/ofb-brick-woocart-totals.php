<?php
if (!class_exists('OfbWidgetWooCartTotals')):

    class OfbWidgetWooCartTotals extends CbpWidget
    {

        public function __construct()
        {
            parent::__construct(
                    /* Base ID */'ofb_widget_woocart_totals',
                    /* Name */ 'Woo Cart Totals', array('description' => 'This is a WooCommerce Cart Totals brick.', 'icon'        => 'fa fa-money fa-3x'));
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
                        'type'               => 'ofb_widget_woocart_totals',
                        'css_class'          => '',
                        'custom_css_classes' => '',
                        'padding'            => '',
                            ), $atts));
			
            $css_class          = !empty($css_class) ? ' ' . $css_class : '';
            $custom_css_classes = !empty($custom_css_classes) ? ' ' . $custom_css_classes : '';
            $padding            = CbpWidgets::getCssClass($padding);
            ?>			
			
            <div class="<?php echo CbpWidgets::getDefaultWidgetCssClass(); ?> <?php echo $type; ?> <?php echo $padding; ?><?php echo $custom_css_classes; ?><?php echo $css_class; ?>">
            <?php echo do_shortcode('[ofb_woocommerce_cart_totals]'); ?>
            </div>

            <?php
        }
    }

CbpWidgets::registerWidget('OfbWidgetWooCartTotals');
	
endif;
