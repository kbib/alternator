<?php
// $Id$

/**
 * @file alma_user_status_block.tpl.php
 * Template for the user status block.
 */

if( $user_status['loan_overdue_count'] >= 1){
  $loan_status  = "warning";
}
else{
  $loan_status  = "default";
}

if( $user_status['reservation_count'] >= 1){
  $reservation_status = "ok";
}
else{
  $reservation_status = "default";

}
?>

<p style="margin-left:10px;">
  <?php print t('Velkommen @name',array('@name' => $display_name))?>
</p>
<?php if ($status_available): ?>
<p style="margin-left:10px;">
<?php print t('Du har @loan lån og @res reservationer',array('@loan' => $user_status['loan_count'],'@res' => $user_status['reservation_count'])) ?>
</p>
<?php else: ?>
<p style="margin-left:10px;">
<?php print $status_unavailable_message; ?>
</p>
<?php endif; ?>
