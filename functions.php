<?php

function format_price($price) {
	$price = number_format($price, 0, '', ' ');
	return $price . ' <b class="rub">р</b>';
}

function include_template($path, $data) {
	if (file_exists($path)) {
		ob_start();
		extract($data);
		require_once($path);
		return ob_get_clean();
	} else {
		return '';
	}
}