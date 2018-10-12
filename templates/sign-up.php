<nav class="nav">
  <ul class="nav__list container">
    <li class="nav__item">
      <a href="all-lots.html">Доски и лыжи</a>
    </li>
    <li class="nav__item">
      <a href="all-lots.html">Крепления</a>
    </li>
    <li class="nav__item">
      <a href="all-lots.html">Ботинки</a>
    </li>
    <li class="nav__item">
      <a href="all-lots.html">Одежда</a>
    </li>
    <li class="nav__item">
      <a href="all-lots.html">Инструменты</a>
    </li>
    <li class="nav__item">
      <a href="all-lots.html">Разное</a>
    </li>
  </ul>
</nav>

<?php $class_name = isset($errors) ? 'form--invalid' : ''; ?>
<form class="form <?= $class_name; ?>" action="sign-up.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
  <h2>Регистрация нового аккаунта</h2>

  <?php
    $class_name = isset($errors['email']) ? 'form__item--invalid' : '';
    $value = isset($user['email']) ? $user['email'] : '';
  ?>
  <div class="form__item <?= $class_name; ?>"> <!-- form__item--invalid -->
    <label for="email">E-mail*</label>
    <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= $value; ?>">
    <?php if (isset($errors['email'])): ?>
      <span class="form__error"><?= $errors['email']; ?></span>
    <?php endif; ?>
  </div>

  <?php
    $class_name = isset($errors['password']) ? 'form__item--invalid' : '';
    $value = isset($user['password']) ? $user['password'] : '';
  ?>
  <div class="form__item <?= $class_name; ?>">
    <label for="password">Пароль*</label>
    <input id="password" type="text" name="password" placeholder="Введите пароль" value="<?= $value; ?>">
    <?php if (isset($errors['password'])): ?>
      <span class="form__error"><?= $errors['password']; ?></span>
    <?php endif; ?>
  </div>

  <?php
    $class_name = isset($errors['name']) ? 'form__item--invalid' : '';
    $value = isset($user['name']) ? $user['name'] : '';
  ?>
  <div class="form__item <?= $class_name; ?>">
    <label for="name">Имя*</label>
    <input id="name" type="text" name="name" placeholder="Введите имя" value="<?= $value; ?>">
    <?php if (isset($errors['name'])): ?>
      <span class="form__error"><?= $errors['name']; ?></span>
    <?php endif; ?>
  </div>

  <?php
    $class_name = isset($errors['contacts']) ? 'form__item--invalid' : '';
    $value = isset($user['contacts']) ? $user['contacts'] : '';
  ?>
  <div class="form__item <?= $class_name; ?>">
    <label for="message">Контактные данные*</label>
    <textarea id="message" name="contacts" placeholder="Напишите как с вами связаться" ><?= $value; ?></textarea>
    <?php if (isset($errors['contacts'])): ?>
      <span class="form__error"><?= $errors['contacts']; ?></span>
    <?php endif; ?>
  </div>

  <?php
    $class_name = isset($errors['avatar']) ? 'form__item--invalid' : ''; 
  ?>
  <div class="form__item form__item--file form__item--last <?= $class_name; ?>">
    <label>Аватар</label>
    <div class="preview">
      <button class="preview__remove" type="button">x</button>
      <div class="preview__img">
        <?php if (isset($user['avatar'])): ?>
          <img src="<?= $user['avatar']; ?>" width="113" height="113" alt="Ваш аватар">
        <?php endif; ?>
      </div>
    </div>
    <div class="form__input-file">
      <input class="visually-hidden" type="file" id="photo2" name="avatar">
      <label for="photo2">
        <span>+ Добавить</span>
      </label>
    </div>
    <?php if (isset($errors['avatar'])): ?>
      <span class="form__error"><?=$errors['avatar']; ?></span>
    <?php endif; ?>
  </div>
  <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
  <button type="submit" class="button">Зарегистрироваться</button>
  <a class="text-link" href="login.php">Уже есть аккаунт</a>
</form>