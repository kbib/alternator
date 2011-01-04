  <?php
// $Id$

/**
 * @file page.tpl.php
 * Main page template file for the alternator theme.
 */
?>
<!DOCTYPE html>
<html>
<head>
  <title><?php print $head_title; ?></title>
  <?php print $head; ?>
  <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
  <?php print $styles; ?>
  <?php print $scripts; ?>
</head>
<body class="<?php print $body_classes; ?><?php if (!empty($admin)) print ' '.admin;  ?>">
<?php 
/*adds support for for the admin module*/
  if (!empty($admin)) print $admin; 
?>

  <div class="top">
    <div class="top_top">
    <?php if($user->uid): ?>
      <?php print l(t('Logout'),'logout', array('attributes' => array('class' => 'login-btn')))?>
    <?php else:?>
      <?php print l(t('Login'),'user/login', array('attributes' => array('class' => 'login-btn'),'query' => 'destination=user/status'))?>
    <?php endif;?>
      <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" class="home">
        <img src="/profiles/ding/themes/kolding_mobile/images/top-top.png" />
      </a>
    </div>
    <div class="top_bottom">
      <img src="/profiles/ding/themes/kolding_mobile/images/top-bottom.png" />
      <?php print $search; ?>
    </div>
  </div>
  <?php print theme('links', $mobilemainmenu, array('class' => 'topmenu blackmenu clear-block')); ?>
  
<?php if ($help OR $messages) { ?>
  <div id="drupal-messages">

    <?php print $help ?>
    <?php print $messages ?>

    </div>
<?php } ?>

<?php #print $tabs;?>

<?php print $content; ?>


<?php print theme('links', $mobilebottommenu, array('class' => 'bottommenu blackmenu clear-block')); ?>





<?php /*

<div id="container" class="clearfix">

    <div id="page" class="minheight">
      <div id="page-inner" class="clearfix">


       
        

        <div id="pageheader">
          <div id="pageheader-inner">
            
            <div id="top" class="clearfix">

              <div id="search" class="left">
                <?php #print $search ?>
              </div>

              <div id="account" class="left">
                <?php #print $account; ?>
              </div>  

            </div>

            <div id="navigation">
              <div id="navigation-inner">
                <?php if ($primary_links){ ?>
                  <?php print theme('links', $primary_links); ?>
                <?php } ?>
              </div>
            </div>

            <?php print $breadcrumb; ?>
          </div>
        </div>
        
        <div id="pagebody" class="clearfix">
          <div id="pagebody-inner" class="clearfix">

            <?php if ($left) { ?>
              <div id="content-left">
                <?php print $left; ?>
              </div>
            <?php } ?>

            <div id="content">
              <div id="content-inner">

                <?php
                  
                  if (arg(0) == 'user' && is_numeric(arg(1)) && $tabs){
                    print '<div class="tabs-user">' . $tabs . '</div>';
                  }
                ?>

                <div id="content-main">
                  <?php print $content; ?>
                </div>
                
                <?php
                  if (arg(0) != 'user'  && $tabs){
                    print '<div class="tabs">' . $tabs . '</div>';
                  }
                ?>


              </div>
            </div>

            <?php if ($right) { ?>
              <div id="content-right">
                <?php print $right; ?>
              </div>
            <?php } ?>

          </div>
        </div>

        <div id="pagefooter">
          <div id="pagefooter-inner" class="clearfix">

            <div class="left first">
              <?php print $footer_one; ?>
            </div>

            <div class="left">
              <?php print $footer_two; ?>
            </div>

            <div class="left">
              <?php print $footer_three; ?>             
            </div>

            <div class="left">
              <?php print $footer_four; ?>              
              <?php print $footer; ?>
            </div>
      
          </div>
        </div>

      </div>
    </div>

</div>

 -->
 
 */ ?>

<?php print $closure; ?>
</body>
</html>
