<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- SEO -->
    <meta name="author" content="<?= $site_title; ?>">
    <meta name="robots" content="noindex, nofollow">

	<!-- Title -->
	<title><?= $site_title; ?></title>
	
    <!-- Favicon Load -->
    <link rel="shortcut icon" href="<?= base_url($theme_assets); ?>/favicon.ico" type="image/x-icon">

    <!-- Load STyle -->
    <link href="<?= base_url($theme_assets); ?>/css/style.css" rel="stylesheet">

    <!-- Include Head -->
    <?php $this->load->view("$theme_dir/functions/incl_head"); ?>
    <!-- End Include Head -->
</head>
<body>


    <!-- Main Page -->
    <?php $this->load->view("admin/pages/$site_page"); ?>
    <!-- End Main Page -->


    <script src="<?= base_url($theme_assets); ?>/js/function.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
        
        });
    </script>

    <!-- Include Footer -->
    <?php $this->load->view("$theme_dir/functions/incl_footer"); ?>
    <!-- End Include Footer -->

</body>
</html>