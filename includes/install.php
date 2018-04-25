<?php
if(!defined('ABSPATH')) exit;

class Athletes_Manager_Install {

    public function __construct() {
        add_action( 'admin_enqueue_scripts', array( $this, 'registerScripts' ) );
    }

	public function install () {
        self::createPluginTables();
	}

    public function registerScripts () {
        
        // Scripts
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'athletes-manager-datatables-script', '//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js');
        
        $this->wp_enqueue_js_scripts();
        
        // Styles
        wp_enqueue_style( 'athletes-manager-datatables-style', '//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css');
        wp_enqueue_style( 'athletes-manager-plugin-style', plugins_url( 'athletes-manager/css/main.css' ));
    }

    private static function wp_enqueue_js_scripts () {
        $ajax_localize = array(
                    'object_name' => 'ajax_object',
                    'translations' => array( "ajax_url" => admin_url( 'admin-ajax.php' ) )
                );

        $scripts = array(
            array('key' => 'main', 'src' => 'main.js', 'req' => true),
            array('key' => 'webcam','src' => 'webcam.js', 'req' => true),
            array('key' => 'modal','src' => 'modal.js', 'req' => true),
            array('key' => 'amDataTable','src' => 'am-datatable.js', 'req' => true),
            array(
                'key' => 'events',
                'src' => 'events.js',
                'ajaxLocalize' => true
            ),
            array(
                'key' => 'event_participants',
                'src' => 'event-participants.js',
                'ajaxLocalize' => true
            ),
            array(
                'key' => 'athletes',
                'src' => 'athletes.js',
                'ajaxLocalize' => true
            )
        );

        $helper = (object) array( 'page' => new Athletes_Manager_Page);
        $currentPage = $helper->page->getRequestParameter("page");
        error_log('Current Page: ' . $currentPage);

        foreach( $scripts as $script ){
            $enqueue = false;
            
            if(key_exists('req', $script)){
                $enqueue = true;
            }else{
                if($currentPage == $script['key']){
                    $enqueue = true;
                }    
            }

            if($enqueue){
                wp_enqueue_script( "athletes-manager-{$script['key']}-script", plugins_url( 'athletes-manager/js/' . $script['src'] ) );

                if( key_exists( 'ajaxLocalize', $script ) and $script['ajaxLocalize'] ){
                    wp_localize_script( "athletes-manager-{$script['key']}-script", $ajax_localize['object_name'], $ajax_localize['translations'] );
                }
            }
        }
    }

    public function createPluginTables () {
        global $wpdb;

        // wp_athletes_manager_athletes
        $tablename = $wpdb->prefix . 'athletes_manager_athletes';
        if( $wpdb->get_var("SHOW TABLES LIKE '".$tablename."'") != $tablename){
            $sql = "CREATE TABLE `". $tablename . "` ( ";
            $sql .= " `id` int(11) NOT NULL AUTO_INCREMENT, ";
            $sql .= " `athlete_code` VARCHAR(255) NOT NULL, ";
            $sql .= " `lastname` VARCHAR(255) NOT NULL, ";
            $sql .= " `firstname` VARCHAR(255) NOT NULL, ";
            $sql .= " `middlename` VARCHAR(255) NOT NULL, ";
            $sql .= " `category` VARCHAR(255) NOT NULL, ";
            $sql .= " `gender` VARCHAR(255) NOT NULL, ";
            $sql .= " `birthdate` VARCHAR(255) NOT NULL, ";
            $sql .= " `email_address` VARCHAR(255) NOT NULL, ";
            $sql .= " `mobile_number` VARCHAR(255) NOT NULL, ";
            $sql .= " `date_added` DATETIME NOT NULL, ";
            $sql .= " `last_modified` DATETIME NOT NULL, ";
            $sql .= " `profile_picture` BLOB NOT NULL, ";
            $sql .= "  PRIMARY KEY (`id`) ";
            $sql .= ") ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ; ";
            require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
            dbDelta($sql);
        }else{
            error_log("Table " . $tablename . " already exists!");
        }

        // wp_athletes_manager_events
        $tablename = $wpdb->prefix . 'athletes_manager_events';
        if( $wpdb->get_var("SHOW TABLES LIKE '".$tablename."'") != $tablename){
            $sql = "CREATE TABLE `". $tablename . "` ( ";
            $sql .= " `id` int(11) NOT NULL AUTO_INCREMENT, ";
            $sql .= " `title` VARCHAR(255) NOT NULL, ";
            $sql .= " `date` DATETIME NOT NULL, ";
            $sql .= " `date_added` DATETIME NOT NULL, ";
            $sql .= " `last_modified` DATETIME NOT NULL, ";
            $sql .= " `status` VARCHAR(255) NOT NULL, ";
            $sql .= "  PRIMARY KEY (`id`) ";
            $sql .= ") ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ; ";
            require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
            dbDelta($sql);
        }else{
            error_log("Table " . $tablename . " already exists!");
        }

        // wp_athletes_manager_event_participants
        $tablename = $wpdb->prefix . 'athletes_manager_event_participants';
        if( $wpdb->get_var("SHOW TABLES LIKE '".$tablename."'") != $tablename){
            $sql = "CREATE TABLE `". $tablename . "` ( ";
            $sql .= " `id` int(11) NOT NULL AUTO_INCREMENT, ";
            $sql .= " `event_id` VARCHAR(255) NOT NULL, ";
            $sql .= " `athlete_id` VARCHAR(255) NOT NULL, ";
            $sql .= " `date_added` DATETIME NOT NULL, ";
            $sql .= "  PRIMARY KEY (`id`) ";
            $sql .= ") ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ; ";
            require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
            dbDelta($sql);
        }else{
            error_log("Table " . $tablename . " already exists!");
        }

        // wp_athletes_manager_bike_check
        $tablename = $wpdb->prefix . 'athletes_manager_bike_check';
        if( $wpdb->get_var("SHOW TABLES LIKE '".$tablename."'") != $tablename){
            $sql = "CREATE TABLE `". $tablename . "` ( ";
            $sql .= " `id` int(11) NOT NULL AUTO_INCREMENT, ";
            $sql .= " `event_id` VARCHAR(255) NOT NULL, ";
            $sql .= " `athlete_id` VARCHAR(255) NOT NULL, ";
            $sql .= " `stab_id` VARCHAR(255) NOT NULL, ";
            $sql .= " `check_in` DATETIME NOT NULL, ";
            $sql .= " `check_out` DATETIME NOT NULL, ";
            $sql .= " `check_in_photo` BLOB NOT NULL, ";
            $sql .= " `check_out_photo` BLOB NOT NULL, ";
            $sql .= "  PRIMARY KEY (`id`) ";
            $sql .= ") ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ; ";
            require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
            dbDelta($sql);
        }else{
            error_log("Table " . $tablename . " already exists!");
        }
    }
}

new Athletes_Manager_Install;