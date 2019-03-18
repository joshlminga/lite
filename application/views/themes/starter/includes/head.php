<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- SEO -->
    <?php if ($site_global == 'any'): ?>
    <meta name="description" content="<?= $description; ?>">
    <meta name="keywords" content="<?= $keywords; ?>">
    <meta name="author" content="<?= $site_title; ?>">
    <meta name="robots" content="<?= $site_robots; ?>">
    <?= stripcslashes($seo_data); ?>
    <?php endif ?>
	
	<!-- Title -->
	<title><?= $site_title; ?></title>
	
    <!-- Load STyle -->
    <link href="<?= base_url($assets); ?>/css/style.css" rel="stylesheet">
</head>
<body>
