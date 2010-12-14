<?php 
/**
 * Implementation of hook_preprocess_page
 * 
 * @param unknown_type $variables
 */
function alternator_preprocess_page(&$variables){
  $variables['mobilemainmenu'] = menu_navigation_links('menu-mobile-menu');
  $mobilebottommenu = menu_navigation_links('menu-bottom-menu');
  $mobilebottommenu['mainsite'] = array('href' => variable_get('mobile_tools_desktop_url',''),'title' => t('Gå til koldingbibliotekerners hjemmeside'));
  if(!drupal_is_front_page()){
    $mobilebottommenu = array_merge(array( 'frontpage' => array('href' => '<front>','title' => t('Forsiden'))),$mobilebottommenu);
  } 
  $variables['mobilebottommenu'] = $mobilebottommenu; 
}
function format_danmarc2($string){
  $string = str_replace('Indhold:','',$string);
  $string = str_replace(' ; ','<br/>',$string);
  $string = str_replace(' / ','<br/>',$string);

  return $string;
}