<?php if ($lots && count($lots)): ?>
	<ul class="lots__list">
		<?php foreach ($lots as $lot): ?>
			<li class="lots__item lot">
				<div class="lot__image">
					<img src="<?= $lot['image']; ?>" width="350" height="260" alt="Сноуборд">
				</div>
				<div class="lot__info">
					<span class="lot__category"><?= htmlspecialchars($lot['category']); ?></span>
					<h3 class="lot__title"><a class="text-link" href="lot.php?id=<?= $lot['id']; ?>"><?= htmlspecialchars($lot['name']); ?></a></h3>
					<div class="lot__state">
						<div class="lot__rate">
							<span class="lot__amount">Стартовая цена</span>
							<span class="lot__cost"><?= format_price($lot['start_price']); ?></span>
						</div>
						<div class="lot__timer timer"><?= get_remaining_time($lot['end_date']); ?></div>
					</div>
				</div>
			</li>
		<?php endforeach; ?>
  </ul>
<?php endif; ?>