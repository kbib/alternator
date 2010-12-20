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
function alternator_feed_icon($url) {
  if ($image = theme('image', drupal_get_path('theme', 'dynamo').'/images/feed.png', t('RSS feed'), t('RSS feed'))) {
    // Transform view expose query string in to drupal style arguments -- ?library=1 <-> /1
    if ($pos = strpos($url, '?')) {
      $base = substr($url, 0, $pos);
      $parm = '';
      foreach ($_GET as $key => $value) {
        if ($key != 'q') {
          $parm .= '/' . strtolower($value);
        }
      }

      // Extra fix for event arrangementer?library=x, as it wants taks. id/lib. id
      if (isset($_GET['library'])) {
        if (arg(1) == '') {
          $parm = '/all'.$parm;
        }
      }
      $url = $base.$parm;
    }
    return '<a href="'. check_url($url) .'" class="feed-icon">'. $image .'<span>'. t('RSS') .'</span></a>';
  }
}
