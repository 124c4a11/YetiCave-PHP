<?php if ($categories && count($categories)): ?>
  <ul class="nav__list">
    <?php foreach ($categories as $category): ?>
      <li class="nav__item">
        <a href="category.php?id=<?= $category['id']; ?>"><?= $category['name']; ?></a>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>