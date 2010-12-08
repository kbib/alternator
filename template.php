<?php 
/**
 * Implementation of hook_preprocess_page
 * 
 * @param unknown_type $variables
 */
function alternator_preprocess_page(&$variables){
  #var_dump($variables);

  $variables['mobilemainmenu'] = menu_navigation_links('menu-mobile-menu');
}