    <!-- jQuery -->
    <!--script src="<?=HTTP_PLUGIN;?>jquery-1.12.4.min.js"></script-->
    <script src="<?=PATH_ASSETS; ?>/plugins/jquery/jquery.min.js"></script-->
    <!-- Bootstrap Core JavaScript -->
    <script src="<?=HTTP_PLUGIN;?>bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?=HTTP_PLUGIN;?>metisMenu/dist/metisMenu.min.js"></script>
    <!-- Noty jquery notification plugin -->
    <script src="<?=HTTP_PLUGIN;?>select2/select2.full.js"></script>
    <script src="<?=HTTP_PLUGIN;?>noty/packaged/jquery.noty.packaged.min.js"></script>
    <!-- Add mousewheel plugin (this is optional) -->
    <script type="text/javascript" src="<?=HTTP_PLUGIN;?>jquery.mousewheel-3.0.6.pack.js"></script>
    <!-- Add fancyBox main JS and CSS files -->
    <script type="text/javascript" src="<?=HTTP_PLUGIN;?>fancybox/jquery.fancybox.js?v=2.1.5"></script>
    <link rel="stylesheet" type="text/css" href="<?=HTTP_PLUGIN;?>fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
    <script type="text/javascript">
        var _json = { _ALERT : {} };
        <?php if (isset($_JSON)): ?>
            _json = <?=json_encode($_JSON);?>;
        <?php endif; ?>
        var CI = CI || _json || {};
        $(document).ready(function(){
            $("a[rel=fancybox_group]").fancybox({
                prevEffect : 'none',
                nextEffect : 'none',
                closeBtn  : true,
            });
        });
    </script>
    <!-- foot -->
    <script src="<?= HTTP_PLUGIN; ?>moment-with-locales.js"></script>
    <script src="<?= HTTP_PLUGIN; ?>jStarbox/jstarbox.js"></script>
    <script src="<?= HTTP_PLUGIN; ?>datepicker/js/jquery-ui-datepicker.js"></script>
    <script src="<?= HTTP_JS; ?>my.js"></script>
    <script src="<?= HTTP_JS; ?>common.js"></script>
    <!-- Block UI -->
    <script src="<?= HTTP_PLUGIN; ?>jquery.blockUI-2.7.0/jquery.blockUI.js"> </script>
    <!-- sidebar anime -->
    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("active");
        });
    </script>