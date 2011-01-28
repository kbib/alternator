




<div id="ting-search-summary">
  <?php print t('Showing !firstResult-!lastResult of !count results',
                array(
                  '!firstResult' => '<span class="firstResult"></span>',
                  '!lastResult' => '<span class="lastResult"></span>',
                  '!count' => '<span class="count"></span>',
                )); ?>
</div>

<div id="ting-search-sort">
  <?php print t('Sorted by'); ?>
  <select id="edit-ting-search-sort">
    <?php foreach ($sort_options as $sort => $label) { ?>
      <?php print '<option value="' . $sort . '">' . check_plain($label) . '</option>'; ?>
    <?php } ?>
  </select>
</div>

<div id="ting-search-result"  class="reset-list">
  <ul>
  </ul>
</div>

