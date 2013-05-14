<?php
// Done 'checkout/cart'

$viewTroubles = array(
		'account/address',
		'account/logout',
		'account/order',
		'account/return',
		'account/success',
		'affiliate/logout',
		'affiliate/success',
		'checkout/manual',
		'checkout/success',
		'product/manufacturer',

);

$langTroubles = array(
		'account/forgotten',
		'affiliate/forgotten',
		'checkout/confirm',
		'checkout/guest',
		'checkout/guest_shipping',
		'checkout/login',
		'checkout/payment_address',
		'checkout/payment_method',
		'checkout/register',
		'checkout/shipping_address',
		'checkout/shipping_method',

);

$delicatessen = array(
		'payment/authorizenet_aim',
		'payment/bank_transfer',
		'payment/*',

);

$files = array(
		'account/account',
		'account/download',
		'account/edit',
		'account/login',
		'account/newsletter',
		'account/password',
		'account/register',
		'account/reward',
		'account/transaction',
		'account/voucher',
		'account/wishlist',
		'affiliate/account',
		'affiliate/edit',
		'affiliate/login',
		'affiliate/password',
		'affiliate/payment',
		'affiliate/register',
		'affiliate/tracking',
		'affiliate/transaction',
		'checkout/checkout',
		'common/footer',
		'common/header',
		'common/maintenance',
		'error/not_found',
		'information/contact',
		'information/information',
		'information/sitemap',
		'module/account',
		'module/affiliate',
		'module/bestseller',
		'module/cart',
		'module/category',
		'module/currency',
		'module/featured',
		'module/filter',
		'module/google_talk',
		'module/information',
		'module/language',
		'module/latest',
		'module/special',
		'module/store',
		'module/welcome',
		'product/category',
		'product/compare',
		'product/product',
		'product/search',
		'product/special',

);

foreach ($files as $path) {

	$cFile = 'catalog/controller/'.$path.'.php';
	$lFile = 'catalog/language/english/'.$path.'.php';
	$vFile = 'catalog/view/theme/default/template/'.$path.'.tpl';

	// CONTROLLER PARSING
	preg_match_all(
	'/\$this->data\[\'(.*?)\'\] = __\(\'(.*?)\'\);/',
	file_get_contents($cFile),
	$cMatches
	);
	$cMatches = array_combine($cMatches[1], $cMatches[2]);

	// LANGUAGE PARSING
	preg_match_all(
	'/\$_\[\'(.*?)\'\]( *?)=( *?)(\'.*\')/',
	file_get_contents($lFile),
	$lMatches
	);
	$lMatches = array_combine($lMatches[1], $lMatches[4]);

	// CONTROLLER-LANGUAGE MERGING

	$clMatches = array();
	foreach ($cMatches as $key => $value) {
		if (isset($lMatches[$key])) {
			$clMatches[$key] = $lMatches[$key];
		}
	}

	// VIEW PROCESSING
	$vContent = file_get_contents($vFile);
	foreach ($clMatches as $key => $value) {
		$vContent = str_replace(
				"$".$key,
				"__($value, '$path')",
				$vContent
		);
	}

	// LANGUAGE PROCESSING
	$lContent = file_get_contents($lFile);
	foreach ($lMatches as $key => $value) {
		$lContent = str_replace(
				"'$key'",
				$value,
				$lContent
		);
	}

	// Controller processing
	$cContent = file_get_contents($cFile);
	foreach ($lMatches as $key => $value) {
		$cContent = str_replace(
				"__('".$key."')",
				"__($value,'$path')",
				$cContent
		);
	}

	file_put_contents($lFile, $lContent);
	file_put_contents($cFile, $cContent);
	file_put_contents($vFile, $vContent);
}