<?php if ($categories && count($categories)): ?>
  <ul class="promo__list">
    <?php foreach ($categories as $category): ?>
      <?php switch ($category['name']) {
        case 'Доски и лыжи':
          $class_name = 'promo__item--boards';
          break;
        case 'Крепления':
          $class_name = 'promo__item--attachment';
          break;
        case 'Ботинки':
          $class_name = 'promo__item--boots';
          break;
        case 'Одежда':
          $class_name = 'promo__item--clothing';
          break;
        case 'Инструменты':
          $class_name = 'promo__item--tools';
          break;
        case 'Разное':
          $class_name = 'promo__item--other';
      }?>

      <li class="promo__item <?= $class_name; ?>">
        <a class="promo__link" href="category.php?id=<?= $category['id']; ?>"><?= $category['name']; ?></a>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>