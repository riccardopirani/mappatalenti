<?php
/*
Plugin Name: Ek Mappa dei talenti
Description: plugin per la gestione della mappa dei talenti 
Version:     1.0
Author:      Alessandro Grassi
Text Domain: ek_mappa
Domain Path: /languages
*/
namespace map_plugin;

if (!defined('WPINC')) {
  die;
}

Define('PLUGIN_DIR' , dirname(__FILE__));
Define('PLUGIN_PATH' , plugin_dir_path( __FILE__ ));


register_activation_hook( __FILE__, __NAMESPACE__ . '\\ek_activation' );
  function ek_activation(){
    require_once PLUGIN_DIR. '/includes/class-activator.php';
    Activator::attivazione();

  }


register_deactivation_hook( __FILE__,  __NAMESPACE__ .'\\ek_deactivation' );
function ek_deactivation(){
  require_once PLUGIN_DIR. '/includes/class-deactivator.php';
  Deactivator::disattivazione();
}

require_once PLUGIN_DIR. '/includes/class-plugin.php';
$starter = new Map_plugin();
