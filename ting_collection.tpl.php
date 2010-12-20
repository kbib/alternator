<?php
// $Id$
/**
 * @file ting_object.tpl.php
 *
 * Template to render a collection objects from the Ting database.
 *
 * Available variables:
 * - $collection: The TingClientObjectCollection instance we're rendering.
 * - $sorted_collection: Array of TingClientObject instances sorted by type.
 * - $ting_list: Rendered ting objects.
 */
?>
<div class="ting-overview clearfix">
  <h1><?php print check_plain($collection->title); ?></h1>
  <?php if ($collection->creators) { ?>
  <div class='creator'>
    <span class='byline'><?php echo ucfirst(t('by')); ?></span>
    <?php
    $creators = array();
    foreach ($collection->creators as $i => $creator) {
      $creators[] = $creator;
    }
    print implode(', ', $creators);
    ?>
    <span class='date'>(<?php print $collection->date; ?>)</span>
  </div>
  <?php } ?>

  <p class="abstract"><?php print check_plain($collection->abstract); ?></p>

  
</div>


<?php print $ting_list; ?>
