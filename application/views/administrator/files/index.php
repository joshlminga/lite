
<!-- Head -->
<?php include("head.php"); ?>

<!-- Header -->
<?php include("header.php"); ?>

<!-- Menu -->
<?php include("menu.php"); ?>

            <section id="content">
                <div class="container">
                    <div class="c-analytics row hidden-xs">

                        <div class="btn-group btn-group-justified" role="group" aria-label="...">

                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-default">New Page</button>
                            </div>

                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-info">Theme Customization</button>
                            </div>

                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-warning">Site Settings</button>
                            </div>

                        </div>

                    </div>

                    <div class="row dash-margin">
                        <div class="col-md-3">
                            <div class="core-text">
                                <h1>Dashboard  |</h1>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="">
                                <div class="alert alert-info dash-notify" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    Heads up! This alert needs your attention, but it's not super important.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="">
                        <div class="alert alert-default alert-dismissible alert-core-1" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            Well done! You successfully read this important alert message.
                        </div>
                    </div>

                    <div id="c-grid" class="clearfix" data-columns>
                        <div class="card c-dark palette-Blue-Grey bg">
                            <div class="card-header pad-btm-0">
                                <h2>Overview <small>Jump to manager on click</small></h2>
                            </div>
                            <hr>
                            <div class="row card-body card-padding core-overview">
                                <div class="col-md-6">
                                    <span>
                                        <i class="zmdi zmdi-format-color-text"></i> <a href=""> 2 Post</a>
                                    </span>
                                </div>
                                <div class="col-md-6">
                                    <span>
                                        <i class="zmdi zmdi-comment-list"></i> <a href=""> 1 Comment</a>
                                    </span>
                                </div>
                                <div class="col-md-6">
                                    <span>
                                        <i class="zmdi zmdi-file-plus"></i> <a href=""> 3 Page</a>
                                    </span>
                                </div>
                                <div class="col-md-6">
                                    <span>
                                        <i class="zmdi zmdi-plus-circle-o-duplicate"></i> <a href=""> 2 Content</a>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="card ">
                            <div class="card-header ch-alt">
                                <h2>Blog Draft <small>Draft a post</small></h2>
                            </div>

                            <div class="card-body card-padding">

                                <form enctype="">

                                    <div class="form-group fg-float m-b-30">
                                        <div class="fg-line">
                                            <input type="text" placeholder="Post Title" class="form-control input-sm">
                                        </div>
                                    </div>

                                    <div class="form-group fg-float">
                                        <div class="fg-line">
                                            <textarea class="form-control" placeholder="Write a quick blog post draft/memo" rows="6"></textarea>
                                        </div>
                                    </div>

                                    <div class="m-t-20">
                                        <button type="button" class="btn btn-info">Save as Draft</button>
                                    </div>

                                </form>

                                <div class="clearfix"></div>

                                <div class="pad-top-5">
                                    <p> <a href=""> <i class="zmdi zmdi-more-vert"></i> 2 Draft Post ... </a></p>
                                    <p>All Drafted post wont be published directely, you have to <a href="">open draft</a> and publish them. </p>
                                </div>

                            </div>
                        </div>

                        <div class="card c-dark palette-Blue-Only bg">
                            <div class="card-header pad-btm-0">
                                <h2>Controls <small>Theme &amp; Layout Settings</small></h2>
                            </div>
                            <hr>
                            <div class="row card-body card-padding core-overview core-overview-two">
                                <div class="col-md-4">
                                    <span>
                                        <i class="zmdi zmdi-money"></i> <a href=""> Visit Store</a>
                                    </span>
                                </div>
                                <div class="col-md-4">
                                    <span>
                                        <i class="zmdi zmdi-star-half"></i> <a href=""> Widgets</a>
                                    </span>
                                </div>
                                <div class="col-md-4">
                                    <span>
                                        <i class="zmdi zmdi-puzzle-piece"></i> <a href=""> Extensions</a>
                                    </span>
                                </div>
                                <div class="col-md-6">
                                    <span>
                                        <i class="zmdi zmdi-menu"></i> <a href=""> Menu Manager</a>
                                    </span>
                                </div>
                                <div class="col-md-6">
                                    <span>
                                        <i class="zmdi zmdi-flower"></i> <a href=""> Theme Customize</a>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="card popular-post">
                            <div class="card-header ch-img" style="background-image: url(img/headers/4.png); height: 150px;">
                                <h2>Recent Posts <small>Venenatis Sollicitudin Ipsum</small></h2>

                                <button class="btn palette-Light-Green bg btn-float waves-effect waves-circle waves-float"><i class="zmdi zmdi-plus"></i></button>
                            </div>
                            <div class="card-body m-t-20">
                                <div class="list-group lg-alt">
                                    <a href="#" class="list-group-item media">
                                        <div class="pull-left">
                                            <img class="avatar-img" src="img/profile-pics/1.jpg" alt="">
                                        </div>

                                        <div class="media-body">
                                            <div class="lgi-heading">David Villa Jacobs</div>
                                            <small class="lgi-text">Sorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam mattis lobortis sapien non posuere</small>
                                        </div>
                                    </a>

                                    <a href="#" class="list-group-item media">
                                        <div class="pull-left">
                                            <img class="avatar-img" src="img/profile-pics/5.jpg" alt="">
                                        </div>
                                        <div class="media-body">
                                            <div class="lgi-heading">Candice Barnes</div>
                                            <small class="lgi-text">Quisque non tortor ultricies, posuere elit id, lacinia purus curabitur.</small>
                                        </div>
                                    </a>

                                    <a href="#" class="list-group-item media">
                                        <div class="pull-left">
                                            <img class="avatar-img" src="img/profile-pics/3.jpg" alt="">
                                        </div>
                                        <div class="media-body">
                                            <div class="lgi-heading">Jeannette Lawson</div>
                                            <small class="lgi-text">Donec congue tempus ligula, varius hendrerit mi hendrerit sit amet. Duis ac quam sit amet leo feugiat iaculis</small>
                                        </div>
                                    </a>

                                    <a href="#" class="list-group-item media">
                                        <div class="pull-left">
                                            <img class="avatar-img" src="img/profile-pics/4.jpg" alt="">
                                        </div>
                                        <div class="media-body">
                                            <div class="lgi-heading">Darla Mckinney</div>
                                            <small class="lgi-text">Duis tincidunt augue nec sem dignissim scelerisque. Vestibulum rhoncus sapien sed nulla aliquam lacinia</small>
                                        </div>
                                    </a>

                                    <a href="#" class="list-group-item media">
                                        <div class="pull-left">
                                            <img class="avatar-img" src="img/profile-pics/2.jpg" alt="">
                                        </div>
                                        <div class="media-body">
                                            <div class="lgi-heading">Rudolph Perez</div>
                                            <small class="lgi-text">Phasellus a ullamcorper lectus, sit amet viverra quam. In luctus tortor vel nulla pharetra bibendum</small>
                                        </div>
                                    </a>

                                    <a href="#" class="list-group-item view-more">
                                        <i class="zmdi zmdi-long-arrow-right"></i> View all
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="card palette-Cyan bg">
                            <ul class="actions a-alt">
                                <li class="dropdown">
                                    <a href="#" data-toggle="dropdown">
                                        <i class="zmdi zmdi-more-vert"></i>
                                    </a>

                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li>
                                            <a href="#">Select City</a>
                                        </li>
                                        <li>
                                            <a href="#">Settings</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>

                            <div id="c-weather"></div>
                        </div>

                        <div class="card palette-Red-400 bg">
                            <div class="pie-grid clearfix text-center">
                                <div class="col-xs-4 col-sm-6 col-md-4 pg-item">
                                    <div class="easy-pie-2 easy-pie" data-percent="92">
                                        <span class="ep-value">92</span>
                                    </div>
                                    <div class="pgi-title">Email<br> Scheduled</div>
                                </div>
                                <div class="col-xs-4 col-sm-6 col-md-4 pg-item">
                                    <div class="easy-pie-3 easy-pie" data-percent="11">
                                        <span class="ep-value">11</span>
                                    </div>
                                    <div class="pgi-title">Email<br> Bounced</div>
                                </div>
                                <div class="col-xs-4 col-sm-6 col-md-4 pg-item">
                                    <div class="easy-pie-4 easy-pie" data-percent="52">
                                        <span class="ep-value">52</span>
                                    </div>
                                    <div class="pgi-title">Email<br> Opened</div>
                                </div>
                                <div class="col-xs-4 col-sm-6 col-md-4 pg-item">
                                    <div class="easy-pie-2 easy-pie" data-percent="44">
                                        <span class="ep-value">44</span>
                                    </div>
                                    <div class="pgi-title">Storage<br>Remaining</div>
                                </div>
                                <div class="col-xs-4 col-sm-6 col-md-4 pg-item">
                                    <div class="easy-pie-3 easy-pie" data-percent="78">
                                        <span class="ep-value">78</span>
                                    </div>
                                    <div class="pgi-title">Web Page<br> Views</div>
                                </div>
                                <div class="col-xs-4 col-sm-6 col-md-4 pg-item">
                                    <div class="easy-pie-4 easy-pie" data-percent="32">
                                        <span class="ep-value">32</span>
                                    </div>
                                    <div class="pgi-title">Server<br> Processing</div>
                                </div>
                            </div>
                        </div>

                        <div class="card c-dark palette-Amber bg">
                            <div class="card-header p-b-0">
                                <h2>For the past 30 days <small>Tortor Magna Parturient</small></h2>
                                <ul class="actions a-alt">
                                    <li class="dropdown">
                                        <a href="#" data-toggle="dropdown">
                                            <i class="zmdi zmdi-more-vert"></i>
                                        </a>

                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li>
                                                <a href="#">Change Date Range</a>
                                            </li>
                                            <li>
                                                <a href="#">Change Graph Type</a>
                                            </li>
                                            <li>
                                                <a href="#">Other Settings</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="chart-edge">
                                    <div class="ns-chart flot-chart m-b-20" id="number-stats-chart"></div>
                                </div>

                                <div class="list-group lg-alt lg-even-white">
                                    <div class="list-group-item media">
                                        <div class="pull-right hidden-sm">
                                            <div class="sparkline-bar-1"></div>
                                        </div>

                                        <div class="media-body ns-item">
                                            <small>Page Views</small>
                                            <h3>47,896,536</h3>
                                        </div>
                                    </div>

                                    <div class="list-group-item media">
                                        <div class="pull-right hidden-sm">
                                            <div class="sparkline-bar-2"></div>
                                        </div>

                                        <div class="media-body ns-item">
                                            <small>Site Visitors</small>
                                            <h3>24,456,799</h3>
                                        </div>
                                    </div>

                                    <div class="list-group-item media">
                                        <div class="pull-right hidden-sm">
                                            <div class="sparkline-bar-3"></div>
                                        </div>

                                        <div class="media-body ns-item">
                                            <small>Total Clicks</small>
                                            <h3>13,965</h3>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-5"></div>
                            </div>
                        </div>



                        <div class="card">
                            <div class="card-header ch-dark palette-Purple-300 bg">
                                <h2>Todo lists <small>Mattis Malesuada Risus</small></h2>

                                <ul class="actions a-alt">
                                    <li class="dropdown">
                                        <a href="#" data-toggle="dropdown">
                                            <i class="zmdi zmdi-more-vert"></i>
                                        </a>

                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li>
                                                <a href="#">Change Date Range</a>
                                            </li>
                                            <li>
                                                <a href="#">Change Graph Type</a>
                                            </li>
                                            <li>
                                                <a href="#">Other Settings</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <div class="list-group lg-alt">
                                    <div class="list-group-item-header palette-Purple text">Today</div>

                                    <a href="#" class="list-group-item media">
                                        <div class="pull-left">
                                            <div class="avatar-char palette-Purple-300 bg">C</div>
                                        </div>

                                        <div class="media-body">
                                            <div class="lgi-heading">Consectetur Sem Sollicitudin</div>
                                            <small class="lgi-text">08:55 AM</small>
                                        </div>
                                    </a>

                                    <a href="#" class="list-group-item media">
                                        <div class="pull-left">
                                            <div class="avatar-char palette-Purple-300 bg">E</div>
                                        </div>
                                        <div class="media-body">
                                            <div class="lgi-heading">Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</div>
                                            <small class="lgi-text">07:32 AM</small>
                                        </div>
                                    </a>

                                    <div class="list-group-item-header palette-Light-Blue text">Tomorrow</div>

                                    <a href="#" class="list-group-item media">
                                        <div class="pull-left">
                                            <div class="avatar-char palette-Light-Blue bg">P</div>
                                        </div>
                                        <div class="media-body">
                                            <div class="lgi-heading">Porta Venenatis Quam</div>
                                            <small class="lgi-text">10:30 P</small>
                                        </div>
                                    </a>

                                    <a href="#" class="list-group-item media">
                                        <div class="pull-left">
                                            <div class="avatar-char palette-Light-Blue bg">N</div>
                                        </div>
                                        <div class="media-body">
                                            <div class="lgi-heading">Nullam quis risus eget urna mollis ornare vel eu leo</div>
                                            <small class="lgi-text">11:02 PM</small>
                                        </div>
                                    </a>

                                    <a href="#" class="list-group-item view-more">
                                        <i class="zmdi zmdi-long-arrow-right"></i> View all
                                    </a>
                                </div>

                                <button class="btn palette-Purple-300 bg btn-float waves-effect waves-circle waves-float"><i class="zmdi zmdi-plus"></i></button>
                            </div>
                        </div>



                        <div class="card c-dark palette-Grey bg recent-signups">
                            <div class="card-header p-b-0">
                                <h2>Most Recent Signups <small>Magna Cursus Malesuada</small></h2>
                                <ul class="actions a-alt">
                                    <li class="dropdown">
                                        <a href="#" data-toggle="dropdown">
                                            <i class="zmdi zmdi-more-vert"></i>
                                        </a>

                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li>
                                                <a href="#">Change Date Range</a>
                                            </li>
                                            <li>
                                                <a href="#">Change Graph Type</a>
                                            </li>
                                            <li>
                                                <a href="#">Other Settings</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <div class="sparkline-1 p-30"></div>

                                <ul class="rs-list">
                                    <li>
                                        <a href="#">
                                            <div class="avatar-char">B</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img class="avatar-img" src="img/profile-pics/5.jpg" alt="">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="avatar-char">L</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="avatar-char">A</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img class="avatar-img" src="img/profile-pics/4.jpg" alt="">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="avatar-char">Z</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="avatar-char">I</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="avatar-char">S</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="avatar-char">C</div>
                                        </a>
                                    </li>
                                     <li>
                                        <a href="#">
                                            <div class="avatar-char">W</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img class="avatar-img" src="img/profile-pics/3.jpg" alt="">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="avatar-char">A</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img class="avatar-img" src="img/profile-pics/9.jpg" alt="">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="avatar-char">N</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="avatar-char">X</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="avatar-char">V</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img class="avatar-img" src="img/profile-pics/7.jpg" alt="">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img class="avatar-img" src="img/profile-pics/6.jpg" alt="">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img class="avatar-img" src="img/profile-pics/8.jpg" alt="">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="avatar-char">F</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="avatar-char">E</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="avatar-char">A</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="avatar-char">A</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="avatar-char">M</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="avatar-char">O</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="avatar-char">I</div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card" id="calendar-widget">
                            <div class="card-header cw-header palette-Teal-400 bg">
                                <div class="cwh-year"></div>
                                <div class="cwh-day"></div>

                                <button class="btn palette-Light-Green bg btn-float waves-effect waves-circle waves-float"><i class="zmdi zmdi-plus"></i></button>
                            </div>

                            <div class="card-body card-padding-sm">
                                <div id="cw-body"></div>
                            </div>

                        </div>

                        <div class="card">
                            <div class="card-header ch-img" style="background-image: url(img/demo/note5.html); height: 250px;"></div>
                            <div class="card-header">
                                <h2>
                                    Pellentesque Ligula Fringilla

                                    <small>by Malinda Hollaway on 19th June 2015 at 09:10 AM</small>
                                </h2>
                            </div>
                            <div class="card-body card-padding">
                                <p>Donec ullamcorper nulla non metus auctor fringilla. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Vestibulum id ligula porta felis euismod semper. Nulla vitae elit libero, a pharetra </p>

                                <a href="#" class="view-more"><i class="zmdi zmdi-long-arrow-right"></i> View Article...</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

<!-- Footer -->
<?php include("footer.php"); ?>
