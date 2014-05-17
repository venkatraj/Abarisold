<?php
/**
  ReduxFramework Sample Config File
  For full documentation, please visit: https://github.com/ReduxFramework/ReduxFramework/wiki
 * */

if (!class_exists("Redux_Framework_sample_config")) {

    class Redux_Framework_sample_config {

        public $args = array();
        public $sections = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {
            // This is needed. Bah WordPress bugs.  ;)
            if ( strpos( Redux_Helpers::cleanFilePath( __FILE__ ), Redux_Helpers::cleanFilePath( get_template_directory() ) ) !== false) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);    
            }
        }

        public function initSettings() {

            if ( !class_exists("ReduxFramework" ) ) {
                return;
            }       
            
            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            //add_action( 'redux/plugin/hooks', array( $this, 'remove_demo' ) );
            // Function to test the compiler hook and demo CSS output.
            //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 2); 
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
            // Dynamically add a section. Can be also used to modify sections/fields
            add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        /**

          This is a test function that will let you see when the compiler hook occurs.
          It only runs if a field	set with compiler=>true is changed.

         * */
        function compiler_action($options, $css) {
            //echo "<h1>The compiler hook has run!";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

            /*
              // Demo of how to use the dynamic CSS and write your own static CSS file
              $filename = dirname(__FILE__) . '/style' . '.css';
              global $wp_filesystem;
              if( empty( $wp_filesystem ) ) {
              require_once( ABSPATH .'/wp-admin/includes/file.php' );
              WP_Filesystem();
              }

              if( $wp_filesystem ) {
              $wp_filesystem->put_contents(
              $filename,
              $css,
              FS_CHMOD_FILE // predefined mode settings for WP files
              );
              }
             */
        }

        /**

          Custom function for filtering the sections array. Good for child themes to override or add to the sections.
          Simply include this function in the child themes functions.php file.

          NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
          so you must use get_template_directory_uri() if you want to use any of the built in icons

         * */
        function dynamic_section($sections) {
            //$sections = array();
            $sections[] = array(
                'title' => __('Section via hook', 'redux-framework-demo'),
                'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'redux-framework-demo'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }

        /**

          Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

         * */
        function change_arguments($args) {
            //$args['dev_mode'] = true;

            return $args;
        }

        /**

          Filter hook for filtering the default value of any given field. Very useful in development mode.

         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = "Testing filter hook!";

            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::get_instance(), 'plugin_meta_demo_mode_link'), null, 2);
            }

            // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
            remove_action('admin_notices', array(ReduxFrameworkPlugin::get_instance(), 'admin_notices'));
        }

        public function setSections() {

            /**
              Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns = array();

            if (is_dir($sample_patterns_path)) :

                if ($sample_patterns_dir = opendir($sample_patterns_path)) :
                    $sample_patterns = array();

                    while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {

                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name = explode(".", $sample_patterns_file);
                            $name = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[] = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
                        }
                    }
                endif;
            endif;

            ob_start();

            $ct = wp_get_theme();
            $this->theme = $ct;
            $item_name = $this->theme->get('Name');
            $tags = $this->theme->Tags;
            $screenshot = $this->theme->get_screenshot();
            $class = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'redux-framework-demo'), $this->theme->display('Name'));
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
            <?php endif; ?>

                <h4>
            <?php echo $this->theme->display('Name'); ?>
                </h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'redux-framework-demo'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'redux-framework-demo'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . __('Tags', 'redux-framework-demo') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
                <?php
                if ($this->theme->parent()) {
                    printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.') . '</p>', __('http://codex.wordpress.org/Child_Themes', 'redux-framework-demo'), $this->theme->parent()->display('Name'));
                }
                ?>

                </div>

            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            $sampleHTML = '';
            if (file_exists(dirname(__FILE__) . '/info-html.html')) {
                /** @global WP_Filesystem_Direct $wp_filesystem  */
                global $wp_filesystem;
                if (empty($wp_filesystem)) {
                    require_once(ABSPATH . '/wp-admin/includes/file.php');
                    WP_Filesystem();
                }
                $sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
            }




            // ACTUAL DECLARATION OF SECTIONS

            $this->sections[] = array(
                'title' => __('General Settings', 'abaris'),
                'desc' => __('General Settings of Theme to change look and feel through out the site', 'abaris'),
                'icon' => 'el-icon-cogs',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields' => array(  
                    array(
                        'id'=>'breadcrumb',
                        'type' => 'switch', 
                        'title' => __('Enable Breadcrumb Navigation', 'abaris'),
                        'subtitle'=> __('Check to display breadcrumb navigation.', 'abaris'),
                        'default' => 1,
                        'on' => 'Enable',
                        'off' => 'Disable',
                        ),      

                    array(
                        'id'=>'breadcrumb-char',
                        'type' => 'select',
                        'title' => __('Breadcrumb Character', 'abaris'),
                        'subtitle'=> __('Check to display breadcrumb navigation.', 'abaris'),
                        'options' => array( '1' => ' &raquo; ', '2' => ' / ', '3' => ' > ' ),
                        'default' => '1'
                        ),

                    array(
                        'id'=>'pagenavi',
                        'type' => 'switch', 
                        'title' => __('Enable Numeric Page Navigation', 'abaris'),
                        'subtitle'=> __('Check to display numeric page navigation, instead of Previous Posts / Next Posts links.', 'abaris'),
                        'default'       => 1,
                        'on' => 'Enable',
                        'off' => 'Disable',
                        ),      

                    array(
                        'id'=>'layout',
                        'type' => 'image_select',
                        'compiler'=>true,
                        'title' => __('Main Layout', 'abaris' ), 
                        'subtitle' => __('Select main content and sidebar alignment.', 'abaris' ),
                        'options' => array(
                                '2' => array('alt' => 'Right Sidebar', 'img' => ReduxFramework::$_url.'assets/img/2cl.png'),
                                '3' => array('alt' => 'Left Sidebar', 'img' => ReduxFramework::$_url.'assets/img/2cr.png'),
                            ),
                        'default' => '3'
                        ),

                    array(
                        'id'=>'custom-js',
                        'type' => 'textarea',
                        'title' => __('Custom Javascript', 'abaris'), 
                        'subtitle' => __('Quickly add some Javascript to your theme by adding it to this block.', 'abaris'),
                        'validate' => 'js',
                        'desc' => 'Validate that it\'s javascript!',
                        ),      
               array(
                        'id'=>'custom-css',
                        'type' => 'ace_editor',
                        'title' => __('Custom CSS', 'abaris'), 
                        'subtitle' => __('Quickly add some CSS to your theme by adding it to this block.', 'abaris'),
                        'mode' => 'css',
                  'theme' => 'monokai',
                        'desc' => 'Possible modes can be found at <a href="http://ace.c9.io" target="_blank">http://ace.c9.io/</a>.',
                        )
                )
            );


            $this->sections[] = array(
                'title' => __('Header', 'abaris'),
                'desc' => __('Theme options related to header section', 'abaris'),
                'icon' => 'el-icon-arrow-up',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields' => array(  

                    array(
                        'id'=>'site-title',
                        'type' => 'switch', 
                        'title' => __('Logo as site title', 'abaris'),
                        'subtitle'=> __('Enable to load custom logo as site title in header.', 'abaris'),
                        "default"       => 0,
                        'on' => 'Enable',
                        'off' => 'Disable',
                        ),

                    array(
                        'id'=>'custom-logo',
                        'type' => 'media', 
                        'url'=> true,
                        'title' => __('Custom Logo', 'abaris'),
                        'compiler' => 'true',
                        //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                        'desc'=> __('Upload logo to use as site title', 'abaris'),
                        'subtitle' => __('Upload any media using the WordPress native uploader', 'abaris'),
                        'default'=>array('url'=>'http://s.wordpress.org/style/images/codeispoetry.png'),
                        ),

                    array(
                        'id'=>'site-description',
                        'type' => 'switch', 
                        'title' => __('Site Description', 'abaris'),
                        'subtitle'=> __('Enable to show site description in header.', 'abaris'),
                        "default"       => 1,
                        'on' => 'Enable',
                        'off' => 'Disable',
                        ),

                    array(
                        'id'=>'favicon',
                        'type' => 'media', 
                        'preview'=> false,
                        'title' => __('Custom Favicon (ICO)', 'abaris'),
                        'desc' => __('You can upload an ico image that will represent your website\'s favicon (16px X 16px)', 'abaris'),
                        ),

                    array(
                        'id'=>'ipad-icon-retina',
                        'type' => 'media', 
                        'preview'=> false,
                        'title' => __('Apple iPad Retina Icon Upload (144px X 144px)', 'abaris'),
                        'desc'=> __('For third-generation iPad with high-resolution Retina display', 'abaris'),
                        ),

                    array(
                        'id'=>'iphone-icon-retina',
                        'type' => 'media', 
                        'preview'=> false,
                        'title' => __('Apple iPhone Retina Icon Upload (114px X 114px)', 'abaris'),
                        'desc'=> __('For iPhone with high-resolution Retina display', 'abaris'),
                        ),

                    array(
                        'id'=>'ipad-icon',
                        'type' => 'media', 
                        'preview'=> false,
                        'title' => __('Apple iPad Icon Upload (72px X 72px)', 'abaris'),
                        'desc'=> __('For first- and second-generation iPad', 'abaris'),
                        ),

                    array(
                        'id'=>'iphone-icon',
                        'type' => 'media', 
                        'preview'=> false,
                        'title' => __('Apple iPhone Icon Upload (57px X 57px)', 'abaris'),
                        'desc'=> __('For non-Retina iPhone, iPod Touch, and Android 2.1+ devices', 'abaris'),
                        ),          
                    )
            );


            $this->sections[] = array(
                'title' => __('Footer', 'abaris'),
                'desc' => __('Theme options related to footer area of theme', 'abaris'),
                'icon' => 'el-icon-arrow-down',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields' => array(  

                    array(
                        'id'=>'footer-widgets',
                        'type' => 'switch', 
                        'title' => __('Enable Footer Widget Area', 'abaris'),
                        'subtitle'=> __('Check to enable 4 Column Footer widget Area', 'abaris'),
                        "default"       => 0,
                        'on' => 'Enable',
                        'off' => 'Disable',
                        ),

                    array(
                        'id'=>'footer-text',
                        'type' => 'textarea',
                        'title' => __('Footer Copyright Text', 'abaris'), 
                        'subtitle' => __('Footer copyright text. HTML Allowed', 'abaris'),
                        'desc' => __('This field is even HTML validated!', 'abaris'),
                        'default' => __( 'Powered by <a href="http://wordpress.org/" target="_blank">WordPress</a>. Theme by <a href="http://www.webulous.in/">Webulous</a>.', 'abaris' ),
                        'validate' => 'html',
                        ),

                    )
                );

                $this->sections[] = array(
                    'title' => __('Home', 'abaris'),
                    'desc' => __('Theme options related to home page', 'abaris'),
                    'icon' => 'el-icon-home',
                    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                    'fields' => array(  

                        array(
                            'id'=>'slides',
                            'type' => 'slides',
                            'title' => __('Flex Slider Options', 'abaris' ),
                            'subtitle'=> __('Unlimited slides with drag and drop sortings.', 'abaris' ),
                            'show' => array( 'title' => true, 'description' => true, 'url' => true ),
                        ),

                        array(
                        'id'=>'service-icon-1',
                        'type' => 'select',
                        'data' => 'elusive-icons',
                        'title' => __('1. Service Icon', 'abaris' ), 
                        'subtitle' => __('Select icon that represents your service', 'abaris' ),
                        ),
                        array(
                            'id'=>'service-description-1',
                            'type' => 'textarea',
                            'title' => __('1. Service Description', 'abaris' ), 
                            'subtitle' => __('Custom HTML, Just like a text box widget.', 'abaris' ),
                            'desc' => __('This field is even HTML validated!', 'abaris' ),
                            'validate' => 'html',
                        ),

                        array(
                            'id'=>'service-icon-2',
                            'type' => 'select',
                            'data' => 'elusive-icons',
                            'title' => __('2. Service Icon', 'abaris' ), 
                            'subtitle' => __('Select icon that represents your service', 'abaris' ),
                        ),
                        array(
                            'id'=>'service-description-2',
                            'type' => 'textarea',
                            'title' => __('2. Service Description', 'abaris' ), 
                            'subtitle' => __('Custom HTML, Just like a text box widget.', 'abaris' ),
                            'desc' => __('This field is even HTML validated!', 'abaris' ),
                            'validate' => 'html',
                        ),

                        array(
                            'id'=>'service-icon-3',
                            'type' => 'select',
                            'data' => 'elusive-icons',
                            'title' => __('3. Service Icon', 'abaris' ), 
                            'subtitle' => __('Select icon that represents your service', 'abaris' ),
                        ),
                        array(
                            'id'=>'service-description-3',
                            'type' => 'textarea',
                            'title' => __('3. Service Description', 'abaris' ), 
                            'subtitle' => __('Custom HTML, Just like a text box widget.', 'abaris' ),
                            'desc' => __('This field is even HTML validated!', 'abaris' ),
                            'validate' => 'html',
                        ),

                        array(
                            'id'=>'features',
                            'type' => 'textarea',
                            'title' => __('Why Us? (or) Featrues', 'abaris' ), 
                            'subtitle' => __('A list is best, like "Why Us?", "Features".', 'abaris' ),
                            'validate' => 'html',
                        ),  


                        array(
                            'id'=>'skill-heading',
                            'type' => 'text',
                            'title' => __('Skills Heading', 'abaris' ), 
                            'subtitle' => __('Enter heading of the skills list', 'abaris' ),
                        ),  

                        array(
                            'id'=>'skill-1',
                            'type' => 'text',
                            'title' => __('1. Skill Name', 'abaris' ), 
                            'subtitle' => __('Enter name of the skill', 'abaris' ),
                        ),      
                        array(
                            'id'=>'percentage-1',
                            'type' => 'spinner',
                            'title' => __('1. Skill Percentage', 'abaris' ), 
                            'desc' => __('Enter 0 to 100', 'abaris' ),
                            'min' => '0',
                            'max' => '100',
                            'step' => '5',
                        ),

                        array(
                            'id'=>'skill-icon-1',
                            'type' => 'select',
                            'data' => 'elusive-icons',
                            'title' => __('1. Skill Icon', 'abaris' ), 
                            'subtitle' => __('Select icon that represents this skill', 'abaris' ),
                        ),

                        array(
                            'id'=>'skill-2',
                            'type' => 'text',
                            'title' => __('2. Skill Name', 'abaris' ), 
                            'subtitle' => __('Enter name of the skill', 'abaris' ),
                        ),      

                        array(
                            'id'=>'percentage-2',
                            'type' => 'spinner',
                            'title' => __('2. Skill Percentage', 'abaris' ), 
                            'desc' => __('Enter 0 to 100', 'abaris' ),
                            'min' => '0',
                            'max' => '100',
                            'step' => '5',
                        ),

                        array(
                            'id'=>'skill-icon-2',
                            'type' => 'select',
                            'data' => 'elusive-icons',
                            'title' => __('2. Skill Icon', 'abaris' ), 
                            'subtitle' => __('Select icon that represents this skill', 'abaris' ),
                        ),

                        array(
                            'id'=>'skill-3',
                            'type' => 'text',
                            'title' => __('3. Skill Name', 'abaris' ), 
                            'subtitle' => __('Enter name of the skill', 'abaris' ),
                        ),

                        array(
                            'id'=>'percentage-3',
                            'type' => 'spinner',
                            'title' => __('3. Skill Percentage', 'abaris' ), 
                            'desc' => __('Enter 0 to 100', 'abaris' ),
                            'min' => '0',
                            'max' => '100',
                            'step' => '5',
                        ),

                        array(
                            'id'=>'skill-icon-3',
                            'type' => 'select',
                            'data' => 'elusive-icons',
                            'title' => __('3. Skill Icon', 'abaris' ), 
                            'subtitle' => __('Select icon that represents this skill', 'abaris' ),
                        ),

                        array(
                            'id'=>'skill-4',
                            'type' => 'text',
                            'title' => __('4. Skill Name', 'abaris' ), 
                            'subtitle' => __('Enter name of the skill', 'abaris' ),
                            ),

                        array(
                            'id'=>'percentage-4',
                            'type' => 'spinner',
                            'title' => __('4. Skill Percentage', 'abaris' ), 
                            'desc' => __('Enter 0 to 100', 'abaris' ),
                            'min' => '0',
                            'max' => '100',
                            'step' => '5',
                        ),

                        array(
                            'id'=>'skill-icon-4',
                            'type' => 'select',
                            'data' => 'elusive-icons',
                            'title' => __('4. Skill Icon', 'abaris' ), 
                            'subtitle' => __('Select icon that represents this skill', 'abaris' ),
                        ),

                        array(
                            'id'=>'skill-5',
                            'type' => 'text',
                            'title' => __('5. Skill Name', 'abaris' ), 
                            'subtitle' => __('Enter name of the skill', 'abaris' ),
                        ),

                        array(
                            'id'=>'percentage-5',
                            'type' => 'spinner',
                            'title' => __('5. Skill Percentage', 'abaris' ), 
                            'desc' => __('Enter 0 to 100', 'abaris' ),
                            'min' => '0',
                            'max' => '100',
                            'step' => '5',
                        ),

                        array(
                            'id'=>'skill-icon-5',
                            'type' => 'select',
                            'data' => 'elusive-icons',
                            'title' => __('5. Skill Icon', 'abaris' ), 
                            'subtitle' => __('Select icon that represents this skill', 'abaris' ),
                        ),

                        array(
                            "id" => "homepage_blocks",
                            "type" => "sorter",
                            "title" => "Homepage Layout Manager",
                            "desc" => "Organize how you want the layout to appear on the homepage",
                            "compiler"=>'true',
                            'options' => array(
                                "enabled" => array(
                                    "placebo" => "placebo", //REQUIRED!
                                    'default' => "Default content"
                                ),
                                "disabled" => array(
                                    "placebo" => "placebo", //REQUIRED!
                                    "slider" => "Slider",
                                    "services" => "Services",
                                    "features" => "Why Us and Skills",
                                    'recent_posts' => 'Recent Posts',
                                ),
                            ),
                        ),  
                    )
                );


                $this->sections[] = array(
                    'title' => __('Blog', 'abaris'),
                    'desc' => __('Blog options for site', 'abaris'),
                    'icon' => 'el-icon-file',
                    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                    'fields' => array(  

                        array(
                            'id'=>'featured-image',
                            'type' => 'switch', 
                            'title' => __('Featured Image', 'abaris'),
                            'subtitle'=> __('Check to show featured image', 'abaris'),
                            "default"       => 0,
                            'on' => 'Show',
                            'off' => 'Hide',
                            ),

                        array(
                            'id'=>'single-featured-image',
                            'type' => 'switch', 
                            'title' => __('Single Post Featured Image', 'abaris'),
                            'subtitle'=> __('Check to show featured image on single post', 'abaris'),
                            "default"       => 0,
                            'on' => 'Show',
                            'off' => 'Hide',
                            ),
                    )
                );

        }

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id' => 'redux-opts-1',
                'title' => __('Theme Information 1', 'redux-framework-demo'),
                'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo')
            );

            $this->args['help_tabs'][] = array(
                'id' => 'redux-opts-2',
                'title' => __('Theme Information 2', 'redux-framework-demo'),
                'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo')
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'redux-framework-demo');
        }

        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name' => 'abaris', // This is where your data is stored in the database and also becomes your global variable name.
                'display_name' => $theme->get('Name'), // Name that appears at the top of your panel
                'display_version' => $theme->get('Version'), // Version that appears at the top of your panel
                'menu_type' => 'menu', //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu' => true, // Show the sections below the admin menu item or not
                'menu_title' => __('Theme Options', 'redux-framework-demo'),
                'page' => __('Theme Options', 'redux-framework-demo'),
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => '', // Must be defined to add google fonts to the typography module
                //'admin_bar' => false, // Show the panel pages on the admin bar
                'global_variable' => '', // Set a different name for your global variable other than the opt_name
                'dev_mode' => false, // Show the time the page took to load, etc
                'customizer' => true, // Enable basic customizer support
                // OPTIONAL -> Give you extra features
                'page_priority' => null, // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent' => 'themes.php', // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions' => 'manage_options', // Permissions needed to access the options panel.
                'menu_icon' => '', // Specify a custom URL to an icon
                'last_tab' => '', // Force your panel to always open to a specific tab (by id)
                'page_icon' => 'icon-themes', // Icon displayed in the admin panel next to your menu_title
                'page_slug' => '_options', // Page slug used to denote the panel
                'save_defaults' => true, // On load save the defaults to DB before user clicks save or not
                'default_show' => false, // If true, shows the default value next to each field that is not the default value.
                'default_mark' => '', // What to print by the field's title if the value shown is default. Suggested: *
                // CAREFUL -> These options are for advanced use only
                'transient_time' => 60 * MINUTE_IN_SECONDS,
                'output' => true, // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag' => true, // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                //'domain'             	=> 'redux-framework', // Translation domain key. Don't change this unless you want to retranslate all of Redux.
                //'footer_credit'      	=> '', // Disable the footer credit of Redux. Please leave if you can help it.
                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database' => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'show_import_export' => true, // REMOVE
                'system_info' => false, // REMOVE
                'help_tabs' => array(),
                'help_sidebar' => '', // __( '', $this->args['domain'] );            
            );


            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.		
            $this->args['share_icons'][] = array(
                'url' => 'https://github.com/ReduxFramework/ReduxFramework',
                'title' => 'Visit us on GitHub',
                'icon' => 'el-icon-github'
                    // 'img' => '', // You can use icon OR img. IMG needs to be a full URL.
            );
            $this->args['share_icons'][] = array(
                'url' => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',
                'title' => 'Like us on Facebook',
                'icon' => 'el-icon-facebook'
            );
            $this->args['share_icons'][] = array(
                'url' => 'http://twitter.com/reduxframework',
                'title' => 'Follow us on Twitter',
                'icon' => 'el-icon-twitter'
            );
            $this->args['share_icons'][] = array(
                'url' => 'http://www.linkedin.com/company/redux-framework',
                'title' => 'Find us on LinkedIn',
                'icon' => 'el-icon-linkedin'
            );



            // Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace("-", "_", $this->args['opt_name']);
                }
                //$this->args['intro_text'] = sprintf(__('<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'redux-framework-demo'), $v);
            } else {
                $this->args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'redux-framework-demo');
            }

            // Add content after the form.
            $this->args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'redux-framework-demo');
        }

    }

    new Redux_Framework_sample_config();
}


/**

  Custom function for the callback referenced above

 */
if (!function_exists('redux_my_custom_field')):

    function redux_my_custom_field($field, $value) {
        print_r($field);
        print_r($value);
    }

endif;

/**

  Custom function for the callback validation referenced above

 * */
if (!function_exists('redux_validate_callback_function')):

    function redux_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';
        /*
          do your validation

          if(something) {
          $value = $value;
          } elseif(something else) {
          $error = true;
          $value = $existing_value;
          $field['msg'] = 'your custom error message';
          }
         */

        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }


endif;
