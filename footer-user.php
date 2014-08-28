
        </div>
    </div>
    <!-- basic scripts -->

    <!--[if !IE]> -->

    <script src="http://ajax.useso.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>

    <!-- <![endif]-->

    <!--[if IE]>
    <script src="http://ajax.useso.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <![endif]-->

    <!--[if !IE]> -->

    <script type="text/javascript">
        window.jQuery || document.write("<script src='<?php echo template_uri; ?>/js/member/jquery-2.0.3.min.js'>"+"<"+"/script>");
        window.$ = window.jQuery;
    </script>

    <!-- <![endif]-->

    <!--[if IE]>
    <script type="text/javascript">
        window.jQuery || document.write("<script src='<?php echo template_uri; ?>/js/member/jquery-1.10.2.min.js'>"+"<"+"/script>");
        window.$ = window.jQuery;
    </script>
    <![endif]-->


    <!-- ace settings handler -->

    <script src="<?php echo template_uri; ?>/js/member/ace-extra.min.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>
    <script src="<?php echo template_uri; ?>/js/member/html5shiv.js"></script>
    <script src="<?php echo template_uri; ?>/js/member/respond.min.js"></script>
    <![endif]-->

    <script type="text/javascript">
        if("ontouchend" in document) document.write("<script src='<?php echo template_uri; ?>/js/member/jquery.mobile.custom.min.js'>"+"<"+"/script>");
    </script>
    <script src="<?php echo template_uri; ?>/js/member/bootstrap.min.js"></script>
    <script src="<?php echo template_uri; ?>/js/member/typeahead-bs2.min.js"></script>

    <!-- page specific plugin scripts -->

    <!--[if lte IE 8]>
      <script src="<?php echo template_uri; ?>/js/member/excanvas.min.js"></script>
    <![endif]-->
    <script src="<?php echo template_uri; ?>/js/member/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="<?php echo template_uri; ?>/js/member/jquery.ui.touch-punch.min.js"></script>
    <script src="<?php echo template_uri; ?>/js/member/bootbox.min.js"></script>
    <script src="<?php echo template_uri; ?>/js/member/jquery.easy-pie-chart.min.js"></script>
    <script src="<?php echo template_uri; ?>/js/member/jquery.gritter.min.js"></script>
    <!-- ace scripts -->

    <script src="<?php echo template_uri; ?>/js/member/ace-elements.min.js"></script>
    <script src="<?php echo template_uri; ?>/js/member/ace.min.js"></script>

    <?php wp_footer() ?>

</body>
</html>
