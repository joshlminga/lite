<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $site_title; ?></title>

	<meta name="author" content="Core CMS Lite Team">
	<meta name="robots" content="noindex, nofollow">

	<!-- Vendor CSS -->
	<link href="<?= base_url($assets); ?>/vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">
	<link href="<?= base_url($assets); ?>/vendors/bower_components/google-material-color/dist/palette.css" rel="stylesheet">
	<link href="<?= base_url($assets); ?>/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css" rel="stylesheet">

	<!-- CSS -->
	<link href="<?= base_url($assets); ?>/css/app.min.1.css" rel="stylesheet">
	<link href="<?= base_url($assets); ?>/css/app.min.2.css" rel="stylesheet">

	<!-- Custom -->
	<link href="<?= base_url($assets); ?>/custom/custom.min.css" rel="stylesheet">
</head>

<body>

	<!-- Main Page -->
	<?php $this->load->view("admin/pages/$site_page"); ?>
	<!-- End Main Page -->

	<!-- Older IE warning message -->
	<!--[if lt IE 9]>
            <div class="ie-warning">
                <h1 class="c-white">Warning!!</h1>
                <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
                <div class="iew-container">
                    <ul class="iew-download">
                        <li>
                            <a href="http://www.google.com/chrome/">
                                <img src="img/browsers/chrome.png" alt="">
                                <div>Chrome</div>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.mozilla.org/en-US/firefox/new/">
                                <img src="img/browsers/firefox.png" alt="">
                                <div>Firefox</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://www.opera.com">
                                <img src="img/browsers/opera.png" alt="">
                                <div>Opera</div>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.apple.com/safari/">
                                <img src="img/browsers/safari.png" alt="">
                                <div>Safari</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                                <img src="img/browsers/ie.png" alt="">
                                <div>IE (New)</div>
                            </a>
                        </li>
                    </ul>
                </div>
                <p>Sorry for the inconvenience!</p>
            </div>
        <![endif]-->

	<!-- Javascript Libraries -->
	<script src="<?= base_url($assets); ?>/vendors/bower_components/jquery/dist/jquery.min.js"></script>
	<script src="<?= base_url($assets); ?>/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="<?= base_url($assets); ?>/vendors/bower_components/Waves/dist/waves.min.js"></script>

	<!-- Placeholder for IE9 -->
	<!--[if IE 9 ]>
            <script src="<?= base_url($assets); ?>/vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
        <![endif]-->

	<script src="<?= base_url($assets); ?>/js/functions.js"></script>
	<script src="<?= base_url($assets); ?>/custom/custom.js"></script>

</body>

</html>
