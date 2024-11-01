<?php
if (!class_exists('OfbWidgetWCProductLoop')):

    class OfbWidgetWCProductLoop extends CbpWidget
    {

        public function __construct()
        {
            parent::__construct(
                    /* Base ID */'ofb_widget_wc_product_loop',
                    /* Name */ 'Product Loop', array('description' => 'This is a WooCommerce Product Loop brick.', 'icon'        => 'fa fa-retweet fa-3x'));
        }

        public function registerFormElements($elements)
        {
            $elements                = parent::registerFormElements($elements);
            $elements['template_id'] = '';
            $elements['limit']       = '';

            return $elements;
        }

        public function form($instance)
        {
            parent::form($instance);

            CbpWidgetFormElements::selectTemplate(array(
                'name'              => $this->getIdString('template_id'),
                'value'             => $instance['template_id'],
                'description_title' => $this->translate('Select Template'),
            ));
        }

        public function widget($atts, $content)
        {
            extract(shortcode_atts(array(
                        'type'               => 'ofb_widget_wc_product_loop',
                        'template_id'        => '',
                        'limit'              => '',
                        'css_class'          => '',
                        'custom_css_classes' => '',
                        'padding'            => '',
                            ), $atts));

            $css_class          = !empty($css_class) ? ' ' . $css_class : '';
            $custom_css_classes = !empty($custom_css_classes) ? ' ' . $custom_css_classes : '';
            $padding            = CbpWidgets::getCssClass($padding);
            
            $templatePost = get_post($template_id);
            
            ?>
            <div class="<?php echo CbpWidgets::getDefaultWidgetCssClass(); ?> <?php echo $type; ?> <?php echo $padding; ?><?php echo $custom_css_classes; ?><?php echo $css_class; ?>">
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <?php echo do_shortcode($templatePost->post_content); ?>
                    <?php endwhile; ?>
                <?php endif; ?>
                <?php wp_reset_query(); ?>
                <div class="ofb-pagination">
                    <?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
                </div>
            </div>
            <?php
        }
        
    }
CbpWidgets::registerWidget('OfbWidgetWCProductLoop');
endif;