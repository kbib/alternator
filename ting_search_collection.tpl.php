<?php
// $Id$

/**
 * @file
 * Template to render a Ting collection of books.
 */

#var_dump($collection);

?>
  <li class="clear-block">
  
  <?php if ($picture): ?>
      <div class="picture">
        <?php print $picture; ?>
      </div>
    <?php endif; ?>
    <div class="item graybox-btns<?php print $picture?'':' nopicture'; ?>">
    <a href="<?php print $collection->url; ?>">
    
      <h3><?php print $collection->title ?></h3>
      <?php if ($collection->creators_string) : ?>
      <span class="creator">
        <?php echo t('By %creator_name%', array('%creator_name%' => $collection->creators_string)) ?>
      </span>
      <?php endif; ?>
      <?php if ($collection->date) : ?>
      <span class="publication_date">
        (<?php echo $collection->date /* TODO: Improve date handling, localizations etc. */ ?>)
      </span>
      <?php endif; ?>
      <?php if ($collection->abstract) : ?>
      <p class="abstract">
        <?php print check_plain($collection->abstract); ?>
      </p>
      <?php endif; ?>
      <div class="types">
        <?php print $type_list; ?>
      </div>
    </a>
    </div>
  </li>

