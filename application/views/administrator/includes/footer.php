

            <footer id="footer">
                Copyright &copy; 2015 Core Lite 1.0
                <center>Powered by Core-CMS Team</center>
            </footer>

        </section>

        

        <!-- Javascript Libraries -->
        <script src="<?= base_url($assets); ?>/vendors/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="<?= base_url($assets); ?>/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="<?= base_url($assets); ?>/endors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
        <script src="<?= base_url($assets); ?>/vendors/bower_components/Waves/dist/waves.min.js"></script>
        <script src="<?= base_url($assets); ?>/vendors/bootstrap-growl/bootstrap-growl.min.js"></script>
        <script src="<?= base_url($assets); ?>/vendors/bootgrid/jquery.bootgrid.updated.min.js"></script>
        <script src="<?= base_url($assets); ?>/vendors/bower_components/moment/min/moment.min.js"></script>
        <script src="<?= base_url($assets); ?>/vendors/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
        <script src="<?= base_url($assets); ?>/vendors/bower_components/simpleWeather/jquery.simpleWeather.min.js"></script>
        <script src="<?= base_url($assets); ?>/vendors/bower_components/salvattore/dist/salvattore.min.js"></script>

        <script src="<?= base_url($assets); ?>/vendors/bower_components/flot/jquery.flot.js"></script>
        <script src="<?= base_url($assets); ?>/vendors/bower_components/flot/jquery.flot.resize.js"></script>
        <script src="<?= base_url($assets); ?>/vendors/bower_components/flot.curvedlines/curvedLines.js"></script>
        <script src="<?= base_url($assets); ?>/vendors/sparklines/jquery.sparkline.min.js"></script>
        <script src="<?= base_url($assets); ?>/vendors/bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>
        <script src="<?= base_url($assets); ?>/js/flot-charts/curved-line-chart.js"></script>
        <script src="<?= base_url($assets); ?>/js/flot-charts/line-chart.js"></script>

        <!-- Placeholder for IE9 -->
        <!--[if IE 9 ]>
        <script src="<?= base_url($assets); ?>/vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
        <![endif]-->

        <script src="<?= base_url($assets); ?>/js/charts.js"></script>

        <script src="<?= base_url($assets); ?>/js/functions.js"></script>
        <script src="<?= base_url($assets); ?>/js/actions.js"></script>
        <script src="<?= base_url($assets); ?>/js/demo.js"></script>
        <script src="<?= base_url($assets); ?>/custom/custom.js"></script>


        <!-- Javascript Libraries -->
        <script src="vendors/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        
        <script src="vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
        <script src="vendors/bower_components/Waves/dist/waves.min.js"></script>
        <script src="vendors/bootstrap-growl/bootstrap-growl.min.js"></script>
        <script src="vendors/bootgrid/jquery.bootgrid.updated.min.js"></script>
        
        <!-- Placeholder for IE9 -->
        <!--[if IE 9 ]>
            <script src="vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
        <![endif]-->
        
        <script src="js/functions.js"></script>
        <script src="js/actions.js"></script>
        <script src="js/demo.js"></script>

        <!-- Data Table -->
        <script type="text/javascript">
            $(document).ready(function(){
                //Basic Example
                $("#data-table-basic").bootgrid({
                    css: {
                        icon: 'zmdi icon',
                        iconColumns: 'zmdi-view-module',
                        iconDown: 'zmdi-expand-more',
                        iconRefresh: 'zmdi-refresh',
                        iconUp: 'zmdi-expand-less'
                    },
                });
                
                //Selection
                $("#data-table-selection").bootgrid({
                    css: {
                        icon: 'zmdi icon',
                        iconColumns: 'zmdi-view-module',
                        iconDown: 'zmdi-expand-more',
                        iconRefresh: 'zmdi-refresh',
                        iconUp: 'zmdi-expand-less'
                    },
                    selection: true,
                    multiSelect: true,
                    rowSelect: true,
                    keepSelection: true
                });
                
                //Command Buttons
                $("#data-table-command").bootgrid({
                    css: {
                        icon: 'zmdi icon',
                        iconColumns: 'zmdi-view-module',
                        iconDown: 'zmdi-expand-more',
                        iconRefresh: 'zmdi-refresh',
                        iconUp: 'zmdi-expand-less'
                    },
                    formatters: {
                        "commands": function(column, row) {
                            return "<button type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-edit\"></span></button> " + 
                                "<button type=\"button\" class=\"btn btn-icon command-delete waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-delete\"></span></button>";
                        }
                    }
                });
            });
        </script>



    </body>
  
</html>