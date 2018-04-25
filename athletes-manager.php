<?php
/*
* Plugin Name: Althetes Manager
* Description: This application allows you to manage athletes database. You can add, edit and delete athletes and its information.
* Author: Julius Lagutan
* Version: 0.0.1
*/

if( !defined( 'ABSPATH' ) ) exit;

require_once plugin_dir_path( __FILE__ ) . 'includes/install.php';

// Includes
require_once plugin_dir_path( __FILE__ ) . 'includes/page.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/menu.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/main.php';

// Models
require_once plugin_dir_path( __FILE__ ) . 'model/athletes.php';
require_once plugin_dir_path( __FILE__ ) . 'model/athlete.php';
require_once plugin_dir_path( __FILE__ ) . 'model/event-participants.php';
require_once plugin_dir_path( __FILE__ ) . 'model/events.php';

// Controllers
require_once plugin_dir_path( __FILE__ ) . 'controller/athletes.php';
require_once plugin_dir_path( __FILE__ ) . 'controller/athlete.php';
require_once plugin_dir_path( __FILE__ ) . 'controller/event-participants.php';
require_once plugin_dir_path( __FILE__ ) . 'controller/events.php';

// Views
require_once plugin_dir_path( __FILE__ ) . 'pages/athletes.php';
require_once plugin_dir_path( __FILE__ ) . 'pages/event_participants.php';
require_once plugin_dir_path( __FILE__ ) . 'pages/events.php';

require_once plugin_dir_path( __FILE__ ) . 'pages/add_athlete.php';
require_once plugin_dir_path( __FILE__ ) . 'pages/athlete.php';

require_once plugin_dir_path( __FILE__ ) . 'pages/event_details.php';
require_once plugin_dir_path( __FILE__ ) . 'pages/add_event.php';
require_once plugin_dir_path( __FILE__ ) . 'pages/add_bike_check.php';

register_activation_hook( __FILE__, array( 'Athletes_Manager_Install', 'install' ) );