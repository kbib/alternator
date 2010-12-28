<?php
// $Id$
/**
 * @file
 * Display a ting objects as part of a list.
 *
 * Available variables:
 * - $object: The thing..
 * - $local_id: The local id if the thing.
 * - $type: Type of the thing.
 * - $image: Image.
 * - $date: The date of the thing.
 * - $creator: Primary author.
 * - $additional_creators: Other authors.
 * - $language: The language of the item.
 * - $more_link: Link to details page.
 */
?>
<!-- ting-list-item.tpl -->

<?php #var_dump($object)?>


<div id="ting-item-<?php print $local_id; ?>" class="ting-item clearfix graybox-btns">

<div class="content clearfix clear-block">
    <div class="picture">
      <?php if ($image) { ?>
        <?php print $image; ?>
      <?php } ?>
    </div>
  
<div class="item">
<a href="<?php print $object->url ?>">
    <div class="info">
      
      <h3><?php print $object->title; ?></h3>

      <span class="author"><em><?php echo t('by'); ?></em>
      <?php print $object->creators_string ?></span>
      <span class='date'><?php print $date; ?></span>

      <div class='language'><?php echo t('Language') . ': ' . $language; ?></div>
      <?php
      foreach ($additional_creators as $creator) {
        print "<p>" . $creator . "</p>";
      }
      ?>

      <?php
        // TODO: This should go into ting_availability.
      if ($type != 'Netdokument') { ?>
      <div class="ting-status waiting">Afventer data…</div>
      <?php } ?>
    </div>

  <?php if ($buttons) :?>
    <div class="ting-object-buttons">
      <?php #print theme('item_list', $buttons, NULL, 'ul', array('class' => 'buttons')) ?>
    </div>
  <?php endif; ?>
</a>
</div>
</div>
</div>
