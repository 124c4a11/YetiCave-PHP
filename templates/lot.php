<nav class="nav">
  <?= $nav_list; ?>
</nav>

<section class="lot-item">
  <?php if (isset($lot)): ?>
    <h2><?=htmlspecialchars($lot['name']); ?></h2>
    <div class="lot-item__content">
      <div class="lot-item__left">
        <div class="lot-item__image">
          <img src="<?= $lot['image']; ?>" width="730" height="548" alt="<?= $lot['name']; ?>">
        </div>
        <p class="lot-item__category">Категория: <span><?= $lot['category'] ?></span></p>
        <p class="lot-item__description"><?=htmlspecialchars($lot['description']); ?></p>
      </div>
      <div class="lot-item__right">
        <div class="lot-item__state">
          <div class="lot-item__timer timer">
            <?=date_format(date_create($lot['end_date']), 'd-m-Y'); ?>
          </div>
          <div class="lot-item__cost-state">
            <div class="lot-item__rate">
              <span class="lot-item__amount">Текущая цена</span>
              <span class="lot-item__cost"><?= format_price($lot['current_price']); ?></span>
            </div>
            <div class="lot-item__min-cost">
              Мин. ставка <span><?= format_price($lot['min_cost']); ?></span>
            </div>
          </div>
          <?php if (isset($_SESSION['user'])): ?>
            <?php $class_name = isset($errors) ? 'form--invalid' : ''; ?>
            <form class="lot-item__form <?= $class_name; ?>" action="lot.php?id=<?= $lot['id']; ?>" method="post">
              <?php
                $class_name = isset($errors['bet']) ? 'form__item--invalid' : '';
                $value = isset($lot['bet']) ? $lot['bet'] : ''; 
              ?>
              <p class="lot-item__form-item <?= $class_name; ?>">
                <label for="cost">Ваша ставка</label>
                <input id="cost" type="number" name="cost" placeholder="<?= $lot['min_cost']; ?>" value="<?= $value; ?>">
                <?php if (isset($errors['bet'])): ?>
                  <span class="form__error"><?= $errors['bet']; ?></span>
                <?php endif; ?>
              </p>
              <button type="submit" class="button">Сделать ставку</button>
            </form>
          <?php endif; ?>
        </div>
        <?php if (count($last_bets)): ?>
          <div class="history">
            <h3>История ставок (<span><?= count($last_bets); ?></span>)</h3>
            <table class="history__list">
              <?php foreach ($last_bets as $bet): ?>
                <tr class="history__item">
                  <td class="history__name"><?= $bet['user_name']; ?></td>
                  <td class="history__price"><?= format_price($bet['price']); ?></td>
                  <td class="history__time"><?= $bet['creation_date']; ?></td>
                </tr>
              <?php endforeach; ?>
            </table>
          </div>
        <?php endif; ?>
      </div>
    </div>
  <?php else: ?>
    <h1>Данный лот не существует!</h1>
  <?php endif; ?>
</section>