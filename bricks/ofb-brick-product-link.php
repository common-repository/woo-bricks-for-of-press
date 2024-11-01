<?php
if (!class_exists('ofbWidgetLinkToProduct')):

    class ofbWidgetLinkToProduct extends CbpWidget
    {				
        public function __construct()
        {
            parent::__construct(
                    /* Base ID */'ofb-link-to-product',
                    /* Name */ 'Link to Product', array('description' => 'This is a Link to Product brick.', 'icon'        => 'fa fa-link fa-3x'));
        }

        public function registerFormElements($elements)
        {
            $elements['product_id']            = null;
            $elements['title']              = '';
            $elements['title_size']         = 'h3';
			$elements['open_link_new_tab']  = '0';
            $elements['link_text']            = '';

            return parent::registerFormElements($elements);
        }

        public function form($instance)
        {
            parent::form($instance);		
					
			// Query the CPT		
			$productlist = get_posts(array('post_type' => 'product', 'posts_per_page' => -1,'orderby' => 'title','order' => 'ASC'));
			
			// Create empty array to pass to the options argument of Form Element which contains just the post's ID and Title		
			$products = array();
			
			// Loop through all $productlist array elements and copy data to $products array
			foreach ( $productlist as $product ) {
				$products[$product->ID] = get_the_title( $product->ID );;
			}
			
            CbpWidgetFormElements::select(array(
                'options'           => $products,
                'name'              => $this->getIdString('product_id'),
                'value'             => $instance['product_id'],
                'description_title' => 'Select Product',
            ));
			
            CbpWidgetFormElements::text(array(
                'name'              => $this->getIdString('link_text'),
                'value'             => $instance['link_text'],
                'description_title' => 'Custom Link Text',
				'description_body'  => 'If this is not set, then default "Page Title" will be used.',
            ));			
            CbpWidgetFormElements::select(array(
                'options' => array(
                    '1'                 => $this->translate('Yes'),
                    '0'                 => $this->translate('No')
                ),
                'name'              => $this->getIdString('open_link_new_tab'),
                'value'             => $instance['open_link_new_tab'],
                'description_title' => $this->translate('Open in a New Tab?'),
            ));
            CbpWidgetFormElements::text(array(
                'name'              => $this->getIdString('title'),
                'value'             => $instance['title'],
                'description_title' => 'Link Title',                
            ));
            CbpWidgetFormElements::select(array(
                'options' => array(
                    'h1'                => $this->translate('H1'),
                    'h2'                => $this->translate('H2'),
                    'h3'                => $this->translate('H3'),
                    'h4'                => $this->translate('H4'),
                    'h5'                => $this->translate('H5'),
                    'h6'                => $this->translate('H6'),
                ),
                'name'              => $this->getIdString('title_size'),
                'value'             => $instance['title_size'],
                'description_title' => $this->translate('Title Size'),
            ));
        }

        public function sanitize(&$attribute)
        {
            switch ($attribute['name']) {
                case CBP_APP_PREFIX . 'title':
                case CBP_APP_PREFIX . 'link_text':
                    $attribute['value'] = sanitize_text_field($attribute['value']);
                    break;
            }

            return parent::sanitize($attribute);
        }

        public function widget($atts, $content)
        {
            extract(shortcode_atts(array(
                        'type'                 => 'ofb-link-to-product',
                        'css_class'            => '',
                        'custom_css_classes'   => '',
                        'product_id'              => 1,
                        'title'                => '',
                        'title_size'           => 'h3',
                        'link_text'            => '',
						'open_link_new_tab'   => '0',
                        'padding'              => '',
                            ), $atts));

            global $post;
            $page               = get_post($product_id);
            $css_class          = !empty($css_class) ? ' ' . $css_class : '';
            $custom_css_classes = !empty($custom_css_classes) ? ' ' . $custom_css_classes : '';
            $padding            = CbpWidgets::getCssClass($padding);
			$new_tab_target = 'target="_blank"';
            ?>
            <div class="<?php echo CbpWidgets::getDefaultWidgetCssClass(); ?> <?php echo $type; ?><?php echo $custom_css_classes; ?><?php echo $css_class; ?> <?php echo $padding; ?>">
			
				<?php if (!empty($title)) : ?>
                <<?php echo $title_size; ?>><?php echo $title ?></<?php echo $title_size; ?>>				
				<?php endif ?>

                <div class="<?php echo $this->getPrefix(); ?>-widget-page-link">
                    <a class="cbp_widget_link" <?php if ((int) $open_link_new_tab): echo $new_tab_target; ?> <?php endif; ?> href="<?php echo get_permalink($page->ID); ?>"><?php echo!empty($link_text) ? $link_text : $page->post_title; ?></a>
                </div>
            </div>

            <?php
        }
    }  

CbpWidgets::registerWidget('ofbWidgetLinkToProduct');	
    
endif;
