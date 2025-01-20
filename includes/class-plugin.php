<?php

/**
 * classe principale starter plugin
 **/
namespace map_plugin;
require_once PLUGIN_DIR . '/includes/class-mastermap.php';
require_once PLUGIN_DIR . '/includes/class-backend.php';
require_once PLUGIN_DIR . '/includes/functions.php';

class Map_plugin
{

  private $versione;
  public $masterMap;

  function __construct()
  {
    $this->versione = Mastermap::VERSIONE;

    $this->masterMap = new Mastermap();
    
    $backend = new Map_backend();

    $GLOBALS['ek_map'] = $this->masterMap; //lo metto fra le variabili globali 

    add_action('admin_menu', array($this, 'add_options_page_style')); //aggiungo stile pagina backend
    add_action('admin_enqueue_scripts', array($this, 'add_options_page_js')); //aggiungo js per backend
    add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_scripts')); //aggiungo js per frontend

  }

  public function enqueue_frontend_scripts()
  {
    wp_enqueue_script('booknow-frontend-js', plugins_url('/js/frontend.js', __FILE__), array('jquery'), $this->versione, true);
  }




  //aggiungo stile pagina backend
  public function add_options_page_style()
  {
    wp_register_style('options_page_style', plugins_url('css/options_style.css', __FILE__));
    wp_enqueue_style('options_page_style');
  }
  //aggiungo js per backend
  public function add_options_page_js()
  {
    wp_enqueue_script('options_page_js', plugins_url('js/script.js', __FILE__));
  }


}