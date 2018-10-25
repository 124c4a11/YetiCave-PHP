<nav class="nav">
  <?= $nav_list; ?> 
</nav>

<?php $class_name = isset($errors) ? 'form--invalid' : ''; ?>
<form class="form container <?= $class_name; ?>" action="login.php" method="post"> <!-- form--invalid -->
  <h2>Вход</h2>
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
  <div class="form__item form__item--last <?= $class_name; ?>">
    <label for="password">Пароль*</label>
    <input id="password" type="text" name="password" placeholder="Введите пароль" value="<?= $value; ?>">
    <?php if (isset($errors['password'])): ?>
      <span class="form__error"><?= $errors['password']; ?></span>
    <?php endif; ?>
  </div>
  <button type="submit" class="button">Войти</button>
</form>