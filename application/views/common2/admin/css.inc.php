    <!-- Custom Fonts -->
    <link href="<?=HTTP_PLUGIN;?>font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Animate Core CSS -->
    <link href="<?=HTTP_PLUGIN;?>animate/animate.css" rel="stylesheet">
    <!-- Bootstrap Core CSS -->
    <link href="<?=HTTP_PLUGIN;?>bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tempusdominus Bbootstrap 4 -->
    <!--link rel="stylesheet" href="<?= PATH_ASSETS ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css"-->

    <!-- Bootstrap DateTime and Date Picker CSS -->
    <link href="<?=HTTP_PLUGIN;?>datepicker/css/jquery-ui.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="<?=HTTP_PLUGIN;?>metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?=HTTP_CSS;?>sb-admin-2.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?=HTTP_PLUGIN;?>fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
    <!-- jStarbox CSS -->
    <link href="<?=HTTP_PLUGIN;?>jStarbox/css/jstarbox.css" rel="stylesheet">
    <!-- Select2 CSS -->
    <link href="<?=HTTP_PLUGIN;?>select2/select2.min.css" rel="stylesheet">
    <!-- Self CSS -->
    <link href="<?=HTTP_CSS;?>style.css" rel="stylesheet">
    <link href="<?=HTTP_CSS;?>calendar.css" rel="stylesheet">
    <link href="<?=HTTP_CSS;?>sidebar_anime.css" rel="stylesheet">
    <link href="<?=HTTP_CSS;?>drag_and_drop.css" rel="stylesheet">

	<? if (!empty($site_css)) : ?>
		<? foreach ($site_css as $css) : ?>
			<link rel="stylesheet" type="text/css" href="<?=base_url() . $css;?>" />
		<? endforeach; ?>
	<? endif; ?>
