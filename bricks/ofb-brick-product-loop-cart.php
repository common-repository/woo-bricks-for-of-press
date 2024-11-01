<?php
if (!class_exists('OfbWidgetWCProductLoopCart')):

    class OfbWidgetWCProductLoopCart extends CbpWidget
    {

        public function __construct()
        {
            parent::__construct(
                    /* Base ID */'ofb_widget_product_loop_cart',
                    /* Name */ 'Loop Add To Cart', array('description' => 'This is a WooCommerce Loop Add To Cart brick.', 'icon'        => 'fa fa-plus-circle fa-3x'));
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
                        'type'               => 'ofb_widget_product_loop_cart',
                        'css_class'          => '',
                        'custom_css_classes' => '',
                        'padding'            => '',
                            ), $atts));
			
            $css_class          = !empty($css_class) ? ' ' . $css_class : '';
            $custom_css_classes = !empty($custom_css_classes) ? ' ' . $custom_css_classes : '';
            $padding            = CbpWidgets::getCssClass($padding);
            ?>			
			
            <div class="<?php echo CbpWidgets::getDefaultWidgetCssClass(); ?> <?php echo $type; ?> <?php echo $padding; ?><?php echo $custom_css_classes; ?><?php echo $css_class; ?>">
            <?php echo do_shortcode('[ofb_woocommerce_product_loop_cart]'); ?>
            </div>

            <?php
        }
    }

CbpWidgets::registerWidget('OfbWidgetWCProductLoopCart');
	
endif;