

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

        <!--<script src="<?= base_url($assets); ?>/js/demo.js"></script>-->

        <script src="<?= base_url($assets); ?>/custom/custom.js"></script>
        
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
                            return "<a onclick=\"actionSingle(\'edit,"+ row.id +"\');\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-edit\"></span></a> " + 
                                "<a onclick=\"actionSingle(\'delete,"+ row.id +"\');\" class=\"btn btn-icon command-delete waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-delete\"></span></a>";
                        }
                    },
                    selection: true,
                    multiSelect: true,
                    rowSelect: true,
                    keepSelection: true
                });
            });
        </script>

        <script type="text/javascript">
            //Manage Bulk Action
            function actionBulk(argument) {
                
                //Set Counter Variable and Array
                var i = 0, sThisVal = {};

                //Set Data
                $('input[name=select-inputs]:checked').each(function () {                    
                    if($(this).val() != 'all'){

                        sThisVal[i] = $(this).val();
                        i++;
                    }
                }); 

                //Get Data In Json Format  
                var selectedData = JSON.stringify(sThisVal);

                //base URL as found in config-base URL
                var base_url = "<?= site_url(strtolower($Module)) ?>";
                //Action and Element ID/Name/Data
                var action_id = '/multiple/' + '?action=' + argument + '&name_id_data=' + selectedData;
                //Url to Action
                var action_url = base_url+action_id;
                window.location.href =action_url;
            }

            //Edit / Delete One
            function actionSingle(argument) {
                var dataSelected = argument.split(",");

                //base URL as found in config-base URL
                var base_url = "<?= site_url(strtolower($Module)) ?>";
                //Action and Element ID/Name/Data
                var action_id = '/' + dataSelected[0] + '?name_id_data=' + dataSelected[1];
                //Url to Action
                var action_url = base_url+action_id;
                window.location.href =action_url;
            }
        </script>

    </body>
  
</html>