<?php
// $Id$

/**
 * @file alma_user_personal_info.tpl.php
 * Template for rendering a user's library user profile.
 */
?>
<div class="vcard">
  <h4><?php print t('Basic information'); ?></h4>
  <dl>
    <dt><?php print t('Name'); ?></dt>
    <dd class="fn"><?php print check_plain($account->display_name); ?></dd>
  </dl>
  <h4><?php print t('Contact information'); ?></h4>
  <dl>
    <dt><?php print t('E-mail address'); ?></dt>
    <dd class="email"><?php print check_plain($account->mail); ?></dd>
    <dd class="fixmenu"><?php print $links; ?></dd>
  </dl>
</div>

