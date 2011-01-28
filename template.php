<?php 


function alternator_preprocess_node(&$vars){
  

  if(in_array($vars['type'],array('article','event'))){
  
    unset($vars['links']);
    unset($vars['field_library_ref_rendered']);
    unset($vars['field_list_image_rendered']);
    unset($vars['field_content_images_rendered']);
    unset($vars['field_file_attachments_rendered']);
    
    #var_dump($vars);
    
    $vars['submitted'] = format_date($vars['created'],'large','Europe/Copenhagen','dk');
    
    if($vars['type'] == 'event'){
      $vars['submitted'] = $vars['node']->field_datetime[0]['view'];
      
      $vars['price'] = $vars['node']->field_entry_price[0]['view'];
      #var_dump($vars['node']->field_entry_price);
    }
    
    $vars['content'] = $vars['node']->content['body']['#value'];
    
  
  }
  
 #var_dump($vars['node']);
  
}



/**
 * Implementation of hook_preprocess_page
 * 
 * @param unknown_type $variables
 */
function alternator_preprocess_page(&$variables){
  
  if(in_array('page-user-login',$variables['template_files'])){
    $variables['content'] = '<h1>'.t('Login').'</h1>'.$variables['content'];
  }
  if(in_array('page-user-status',$variables['template_files'])){
    $variables['content'] = '<h1>'.t('Min konto').'</h1>'.$variables['content'];
  }
  
  //var_dump($variables);
  
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


function alternator_theme() {
  return array(
    'user_login' => array(
      'template' => 'user-login',
      'arguments' => array('form' => NULL),
    ),
  );
}

function alternator_preprocess_user_login(&$variables){
  
  $variables['form']['name']['#title'] = 'Cpr- eller kortnummer';
  unset($variables['form']['name']['#description']);
  $variables['form']['pass']['#title'] = 'Pinkode (4 tal)';
  unset($variables['form']['pass']['#description']);
  $variables['form']['pass']['#suffix'] = '<p>'.t('tekst der skal stå efter login').'</p>';
  
  $variables['rendered'] = drupal_render($variables['form']);
}

