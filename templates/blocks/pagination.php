<?php if ($pages_count > 1): ?>
  <ul class="pagination-list">
    <?php 
      $prev_page = $cur_page - 1;
      $next_page = $cur_page + 1;

      if ($prev_page == 0) $prev_page = 1;
      if ($next_page > $pages_count) $next_page = $pages_count;
    ?>

    <li class="pagination-item pagination-item-prev"><a href="<?= $href . $prev_page; ?>">Назад</a></li>

    <?php foreach ($pages as $page): ?>
      <?php $class_name = $cur_page == $page ? 'pagination-item-active' : '' ?>
      <li class="pagination-item <?= $class_name; ?>"><a href="<?= $href . $page ?>"><?= $page; ?></a></li>
    <?php endforeach; ?>

    <li class="pagination-item pagination-item-next"><a href="<?= $href . $next_page; ?>">Вперед</a></li>
  </ul>
<? endif; ?>