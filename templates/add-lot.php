<nav class="nav">
  <?= $nav_list; ?>
</nav>

<?php if ($_SESSION['user']): ?>
  <?php $class_name = isset($errors) ? 'form--invalid' : ''; ?>
  <form class="form form--add-lot container <?=$class_name; ?>" action="add.php" method="post" enctype="multipart/form-data">
    <h2>Добавление лота</h2>
    <div class="form__container-two">
      <?php
        $class_name = isset($errors['name']) ? 'form__item--invalid' : '';
        $value = isset($lot['name']) ? $lot['name'] : '';
      ?>
      <div class="form__item <?=$class_name; ?>">
        <label for="lot-name">Наименование</label>
        <input id="lot-name" type="text" name="name" placeholder="Введите наименование лота" value="<?=$value; ?>" required>
        <?php if (isset($errors['name'])): ?>
        <span class="form__error"><?=$errors['name']; ?></span>
        <? endif; ?>
      </div>

      <?php
        $class_name = isset($errors['category']) ? 'form__item--invalid' : '';
        $value = isset($lot['category']) ? $lot['category'] : '';
      ?>
      <div class="form__item <?=$class_name; ?>">
        <label for="category">Категория</label>
        <select id="category" name="category" required>
          <option>Выберите категорию</option>

          <?php foreach ($categories as $category): ?>
            <?php $selected = ($category['name'] == $lot['category']) ? 'selected' : '' ?>
            <option <?=$selected; ?> ><?= $category['name']; ?></option>
          <?php endforeach; ?>
        </select>
        <?php if (isset($errors['category'])): ?>
          <span class="form__error"><?=$errors['category']; ?></span>
        <?php endif; ?>
      </div>
    </div>

    <?php
      $class_name = isset($errors['description']) ? 'form__item--invalid' : '';
      $value = isset($lot['description']) ? $lot['description'] : '';
    ?>
    <div class="form__item form__item--wide <?=$class_name; ?>">
      <label for="message">Описание</label>
      <textarea id="message" name="description" placeholder="Напишите описание лота" required><?=$value; ?></textarea>
      <?php if (isset($errors['description'])): ?>
        <span class="form__error"><?=$errors['description']; ?></span>
      <?php endif; ?>
    </div>

    <?php
      $class_name = isset($errors['image']) ? 'form__item--invalid' : '';
      $class_name_uploaded = isset($lot['image']) ? 'form__item--uploaded' : '';
    ?>
    <div class="form__item form__item--file <?=$class_name_uploaded; ?> <?=$class_name; ?>" >
      <label>Изображение</label>
      <div class="preview">
        <button class="preview__remove" type="button">x</button>
        <div class="preview__img">
          <?php if (isset($lot['image'])): ?>
            <img src="<?=$lot['image']; ?>" width="113" height="113" alt="Изображение лота">
          <? endif; ?>
        </div>
      </div>
      <div class="form__input-file">
        <input class="visually-hidden" type="file" name="image" id="photo2">
        <label for="photo2">
          <span>+ Добавить</span>
        </label>
      </div>
      <?php if (isset($errors['image'])): ?>
        <span class="form__error"><?=$errors['image']; ?></span>
      <?php endif; ?>
    </div>
    <div class="form__container-three">
      <?php
        $class_name = isset($errors['price']) ? 'form__item--invalid' : '';
        $value = isset($lot['price']) ? $lot['price'] : '';
      ?>
      <div class="form__item form__item--small <?=$class_name ?>">
        <label for="lot-rate">Начальная цена</label>
        <input id="lot-rate" type="number" name="price" placeholder="0" value="<?=$value; ?>" required>
        <?php if (isset($errors['price'])): ?>
          <span class="form__error"><?=$errors['price']; ?></span>
        <?php endif; ?>
      </div>

      <?php
        $class_name = isset($errors['step']) ? 'form__item--invalid' : '';
        $value = isset($lot['step']) ? $lot['step'] : '';
      ?>
      <div class="form__item form__item--small <?=$class_name; ?>">
        <label for="lot-step">Шаг ставки</label>
        <input id="lot-step" type="number" name="step" placeholder="0" value="<?=$value; ?>" required>
        <?php if (isset($errors['step'])): ?>
          <span class="form__error"><?=$errors['step']; ?></span>
        <?php endif; ?>
      </div>

      <?php
        $class_name = isset($errors['date']) ? 'form__item--invalid' : '';
        $value = isset($lot['date']) ? $lot['date'] : '';
      ?>
      <div class="form__item <?=$class_name; ?>">
        <label for="lot-date">Дата окончания торгов</label>
        <input class="form__input-date" id="lot-date" type="date" name="date" value="<?=$value; ?>" required>
        <?php if (isset($errors['date'])): ?>
          <span class="form__error">Введите дату завершения торгов</span>
        <?php endif; ?>
      </div>
    </div>

    <?php if ( $errors && count($errors)): ?>
      <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <?php endif; ?>
    <button type="submit" class="button">Добавить лот</button>
  </form>
<?php else: ?>
  <h2>Данная страница доступна только аутентифицированным пользователям!</h2>
<?php endif; ?>