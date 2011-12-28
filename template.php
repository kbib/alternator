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
  $mobilebottommenu['mainsite'] = array('href' => variable_get('mobile_tools_desktop_url','').'?nomobile=true','title' => t('Gå til koldingbibliotekerners hjemmeside'));
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

function alternator_ding_library_user_loan_list_form($form) {
  $date_format = variable_get('date_format_date_short', 'Y-m-d');
  module_load_include('client.inc', 'ting');
  $groups = array();
  $output = '';

  if ($form['buttons']) {
    $form['top_buttons'] = $form['buttons'];
    // Add suffix to duplicated form button ids to ensure uniqueness
    foreach (element_children($form['top_buttons']) as $key) {
      if (isset($form['top_buttons'][$key]['#id'])) {
        $form['top_buttons'][$key]['#id'] .= '-top';
      }
    }
    $output .= drupal_render($form['top_buttons']);
  }

  $header = array(t('Select'), '', t('Title'), t('Loan date'), t('Due date'));
  $header = array(t('Select'), t('Title'), t('Due date'));

  $colgroups = array(
    array(
      array(
        'class' => 'col-selection',
      ),
    ),
    /*array(
      array(
        'class' => 'col-image',
      ),
    ),*/
    array(
      array(
        'class' => 'col-title',
      ),
    ),
 /*   array(
      array(
        'class' => 'col-loan-date',
      ),
    ),*/
    array(
      array(
        'class' => 'col-due-date',
      ),
    ),
  );

  foreach ($form['loan_data']['#grouped'] as $date => $group) {
    // Overdue loans get preferential treatment. No checkboxes here.
    if ($date == 'overdue') {
      $table_title = t('Overdue loans');
    }
    // The normal loans get grouped by due date.
    else {
      if ($date == 'due') {
        $table_title = t('Due today');
      }
      else {
        $table_title = t('Due in @count days, @date', array('@date' => date('d/m/y', strtotime($date)), '@count' => ceil((strtotime($date) - $_SERVER['REQUEST_TIME']) / 86400)));
      }
    }

    $rows = array();
    foreach ($group as $loan_id) {
      $loan = $form['loan_data']['#value'][$loan_id];
      $cells = array();

      $cells['checkbox'] = array(
        'class' => 'checkbox',
        'data' => drupal_render($form['loans'][$loan_id]),
      );

   /*   $cells['image'] = array(
        'class' => 'image',
        'data' => theme('ding_library_user_list_item_image', 'loan', $loan, '80_x'),
      );*/

      $cells['title'] = array(
        'class' => 'title',
        'data' => theme('ding_library_user_list_item', 'loan', $loan),
      );

    /*  $cells['loan_date'] = array(
        'class' => 'loan_date',
        'data' => ding_library_user_format_date($loan['loan_date'], $date_format),
      );*/

      $cells['due_date'] = array(
        'class' => 'due_date',
        'data' => ding_library_user_format_date($loan['due_date'], $date_format),
      );

      $rows[] = array(
        'data' => $cells,
        'class' => ($checkbox) ? 'selectable' : 'immutable',
      );
    }

    if (!empty($rows)) {
      $output .= theme('table', $header, $rows, array('colgroups' => $colgroups), $table_title);
    }
  }
  if (empty($output)) {
    return t('No loans found.');
  }

  $output .= drupal_render($form);
  return $output;
}

/**
 * Theming of reservation detailed list form.
 */
function alternator_ding_reservation_list_form($form) {
  $date_format = variable_get('date_format_date_short', 'Y-m-d');
  $output = '';
  module_load_include('client.inc', 'ting');

  if (!empty($form['reservations']['#grouped']['fetchable'])) {
    $header = array(
      t('Select'),
      t('Title'),
      t('Pickup number'),
      t('Pickup by'),
      t('Pickup branch'),
    );

        $colgroups = array(
      array(
        array(
          'class' => 'col-selection',
        ),
      ),
      array(
        array(
          'class' => 'col-image',
        ),
      ),
      array(
        array(
          'class' => 'col-title',
        ),
      ),
      array(
        array(
          'class' => 'col-pickup-number',
        ),
      ),
      array(
        array(
          'class' => 'col-pickup-by',
        ),
      ),
      array(
        array(
          'class' => 'col-pickup-branch',
        ),
      ),
    );

    $rows = array();

    foreach ($form['reservations']['#grouped']['fetchable'] as $item) {
      $cells = array();
      if (isset($form['selected'][$item['id']])) {
        $cells['checkbox'] = array(
          'class' => 'checkbox',
          'data' => drupal_render($form['selected'][$item['id']]),
        );
      }
      else {
        $cells['checkbox'] = array(
          'class' => 'checkbox empty',
          'data' => '–',
        );
      }

    /*  $cells['image'] = array(
        'class' => 'image',
        'data' => theme('ding_library_user_list_item_image', 'reservation', $item, '80_x'),
      );*/

      $cells['title'] = array(
        'class' => 'title',
        'data' => theme('ding_library_user_list_item', 'reservation', $item) . ' (<span class="reservation-number">' . t('Res. no @num', array('@num' => $item['id'])) . '</span>)',
      );

      $cells['pickup_number'] = array(
        'class' => 'pickup_number',
        'data' => $item['pickup_number'],
      );

      $cells['pickup_expire_date'] = array(
        'class' => 'pickup_expire_date',
        'data' => ding_library_user_format_date($item['pickup_expire_date'], $date_format),
      );

      $cells['pickup_branch'] = array(
        'class' => 'pickup_branch',
        'data' => $item['pickup_branch'] ? $item['pickup_branch'] : t('Unknown'),
      );

      $rows[] = $cells;
    }

    $output .= theme('table', $header, $rows, array('id' => 'reservations-fetchable', 'colgroups' => $colgroups), t('Reservations ready for pickup'));
  }

  if (!empty($form['reservations']['#grouped']['active'])) {
    $header = array(
      t('Select'),
      //'',
      t('Title'),
     // t('Reserved'),
    //  t('Valid to'),
    t('Queue number'),
      t('Pickup branch'),

    );

    $colgroups = array(
      array(
        array(
          'class' => 'col-selection',
        ),
      ),
      array(
        array(
          'class' => 'col-image',
        ),
      ),
      array(
        array(
          'class' => 'col-title-res',
        ),
      ),
      array(
        array(
          'class' => 'col-reservation',
        ),
      ),
      array(
        array(
          'class' => 'col-valied-to',
        ),
      ),
      array(
        array(
          'class' => 'col-pickup-branch',
        ),
      ),
      array(
        array(
          'class' => 'col-queue-number',
        ),
      ),
    );

    $rows = array();
    foreach ($form['reservations']['#grouped']['active'] as $item) {
      $cells = array();
      if (isset($form['selected'][$item['id']])) {
        $cells['checkbox'] = array(
          'class' => 'checkbox',
          'data' => drupal_render($form['selected'][$item['id']]),
        );
      }
      else {
        $cells['checkbox'] = array(
          'class' => 'checkbox empty',
          'data' => '–',
        );
      }

 /*     $image_url = ting_covers_faust_url($item['record_id'], '80_x');
      $cells['image'] = array(
        'class' => 'image',
        'data' => ($image_url) ? theme('image', $image_url, '', '', NULL, FALSE) : '',
      );
*/
      $cells['title'] = array(
        'class' => 'title',
        'data' => theme('ding_library_user_list_item', 'reservation', $item) . ' (<span class="reservation-number">' . t('Res. no @num', array('@num' => $item['id'])) . '</span>)',
      );

      /*$cells['create_date'] = array(
        'class' => 'create_date',
        'data' => ding_library_user_format_date($item['create_date'], $date_format),
      );*/

      /*$cells['valid_to'] = array(
        'class' => 'valid_to',
        'data' => ding_library_user_format_date($item['valid_to'], $date_format),
      );*/

      $cells['queue_number'] = array(
        'class' => 'queue_no',
        'data' => $item['queue_number'],
      );

      $cells['pickup_branch'] = array(
        'class' => 'pickup_branch',
        'data' => $item['pickup_branch'] ? $item['pickup_branch'] : t('Unknown'),
      );


      $rows[] = array(
        'data' => $cells,
        'class' => 'active-reservations',
      );
    }

    $output .= theme('table', $header, $rows, array('id' => 'reservations-active', 'colgroups' => $colgroups), t('Active reservations'));
  }

  if (empty($output)) {
    return t('No reservations found.');
  }

  $output .= '<div class="update-controls clear-block">';
  $output .= drupal_render($form['options']);
  $output .= '</div>';

  // fisk
  $output .= '<div class="update-controls-button clear-block">';
  $output .= drupal_render($form['buttons']);
  $output .= '</div>';

  $output .= drupal_render($form);

  return $output;
}
