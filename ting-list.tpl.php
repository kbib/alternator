<?php
// $Id$
/**
 * @file
 * Display a list of ting objects.
 *
 * Available variables:
 * - $ting_list: Array of ting items.
 */
?>
<!-- ting-list.tpl -->
<div>
<?php
foreach ($ting_list as $type => $objects) {
  if (count($ting_list) > 1) {
    print '<h2>' . $type . '</h2>';
  }
  print $objects;
}

?>

</div>