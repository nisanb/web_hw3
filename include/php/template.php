<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>iScience | <?=$title;?></title>

    <link href="./include/css/bootstrap.min.css" rel="stylesheet">
    <link href="./include/css/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Toastr style -->
    <link href="./include/css/plugins/toastr/toastr.min.css" rel="stylesheet">

    <!-- Gritter -->
    <link href="./include/js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

    <link href="./include/css/animate.css" rel="stylesheet">
    <link href="./include/css/style.css" rel="stylesheet">

    <?=@$include_header;?>

</head>

<body>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" style="width: 50px;" src="./include/img/avatar/<?=$_SESSION['UserID'];?>.jpg" />
                             </span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="./include/css/font-bold" id="profile_name"></strong>
                            </span> <span class="text-muted text-xs block" id="profile_role"></span><b class="caret"></b> </span> </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a href="./?act=profile">Profile</a></li>
                                <li><a href="#">Followers</a></li>
                                <li><a href="#">Mailbox</a></li>
                                <li class="divider"></li>
                                <li><a href="./?act=logout">Logout</a></li>
                            </ul>
                        </div>
                        <div class="logo-element">
                            iS+
                        </div>
                    </li>

                    <li <?=active("default");?>>
                    <a href="./"><i class="fa fa-home"></i> <span class="nav-label">iScience Home</span></a>
                    </li>
                    <!-- TODO Future
                    <li <?=active("mailbox");?>>
                    <a href="./?act=mailbox"><i class="fa fa-inbox"></i> <span class="nav-label">Mailbox</span></a>
                    </li>
                    <li <?=active("following");?>>
                    <a href="./?act=following"><i class="fa fa-users"></i> <span class="nav-label">Followers</span></a>
                    </li>
                    <li <?=active("notifications");?>>
                    <a href="./?act=notifications"><i class="fa fa-trello"></i> <span class="nav-label">Notifications</span></a>
                    </li>
                  -->
                    <li <?=active("profile");?>>
                    <a href="./?act=profile"><i class="fa fa-user"></i> <span class="nav-label">Profile</span></a>
                    </li>

<!-- Default Multi-level menu for future usage TODO
                    <li>
                        <a href="#"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Graphs</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="graph_flot.html">Flot Charts</a></li>
                            <li><a href="graph_morris.html">Morris.js Charts</a></li>
                            <li><a href="graph_rickshaw.html">Rickshaw Charts</a></li>
                            <li><a href="graph_chartjs.html">Chart.js</a></li>
                            <li><a href="graph_chartist.html">Chartist</a></li>
                            <li><a href="c3.html">c3 charts</a></li>
                            <li><a href="graph_peity.html">Peity Charts</a></li>
                            <li><a href="graph_sparkline.html">Sparkline Charts</a></li>
                        </ul>
                    </li>
                  -->

                </ul>

            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <form role="search" class="navbar-form-custom" action="search_results.html" style="width: 500px;">
                <div class="form-group" >
                    <input type="text" placeholder="Search iScience Users.." class="form-control" name="-search" id="search">
                </div>
                <ul class="list-group" id="result">

                </ul>
            </form>
        </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <span class="m-r-sm text-muted welcome-message">Welcome to iScience</span>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope"></i>  <span class="label label-warning" id="messages_size"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-messages" >
                      <div id="messages">
                      </div>
                        <li>
                            <div class="text-center link-block">
                                <a href="#">
                                    <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-user"></i>  <span class="label label-warning" id="followers_size"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-messages" id="followers">

                      <!-- Mickey - Add content from followers.json
                      User Connted: <?=$_SESSION['UserID'];?>-->
                      <!-- I will insert jquery json from followers.json data
                      Data Type:

                        <li>


                            <div class="dropdown-messages-box">
                                <a href="#" class="pull-left">
                                    <img alt="image" class="img-circle" src="./include/img/a7.jpg">
                                </a>
                                <div class="media-body">
                                    <small class="pull-right">46h ago</small>
                                    <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                                    <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>

                      -->




                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell"></i>  <span class="label label-primary" id="notifications_size"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                      <div id="notifications"></div>
                        <li>
                            <div class="text-center link-block">
                                <a href="#">
                                    <strong>See All Alerts</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>


                <li>
                    <a href="./?act=logout">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li>
                <li>
                    <a class="right-sidebar-toggle">
                        <i class="fa fa-tasks"></i>
                    </a>
                </li>
            </ul>

        </nav>
        </div>

        <div class="row">
            <div class="col-lg-12">
              <div class="wrapper wrapper-content">
                <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>iScience - <?=$title;?></h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="./">Home</a>
                        </li>
                        <li class="active">
                            <strong><a><?=$title;?></a></strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>




              <?=$content;?>
              </div>

                <div class="footer">
                    <div class="pull-right">
                        Web Course <strong>2018</strong>.
                    </div>
                    <div>
                        <strong>Copyright</strong> iScience &copy; 2018 &bull; Mickey Shalev - 200681872 &bull; Nisan Bahar - 302875646
                    </div>
                </div>
            </div>
        </div>

        </div>

        <div id="right-sidebar">
            <div class="sidebar-container">

                <ul class="nav nav-tabs navs-3">

                    <li class="active"><a data-toggle="tab" href="#tab-1">
                        Notes
                    </a></li>
                    <li><a data-toggle="tab" href="#tab-2">
                        Projects
                    </a></li>
                    <li class=""><a data-toggle="tab" href="#tab-3">
                        <i class="fa fa-gear"></i>
                    </a></li>
                </ul>



            </div>



        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="./include/js/jquery-2.1.1.js"></script>
    <script src="./include/js/jquery.timeago.js" type="text/javascript"></script>

    <script src="./include/js/bootstrap.min.js"></script>
    <script src="./include/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="./include/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Flot -->
    <script src="./include/js/plugins/flot/jquery.flot.js"></script>
    <script src="./include/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="./include/js/plugins/flot/jquery.flot.spline.js"></script>
    <script src="./include/js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="./include/js/plugins/flot/jquery.flot.pie.js"></script>

    <!-- Peity -->
    <script src="./include/js/plugins/peity/jquery.peity.min.js"></script>
    <script src="./include/js/demo/peity-demo.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="./include/js/inspinia.js"></script>
    <script src="./include/js/plugins/pace/pace.min.js"></script>

    <!-- jQuery UI -->
    <script src="./include/js/plugins/jquery-ui/jquery-ui.min.js"></script>

    <!-- GITTER -->
    <script src="./include/js/plugins/gritter/jquery.gritter.min.js"></script>

    <!-- Sparkline -->
    <script src="./include/js/plugins/sparkline/jquery.sparkline.min.js"></script>

    <!-- Sparkline demo data  -->
    <script src="./include/js/demo/sparkline-demo.js"></script>

    <!-- ChartJS-->
    <script src="./include/js/plugins/chartJs/Chart.min.js"></script>

    <!-- Toastr -->
    <script src="./include/js/plugins/toastr/toastr.min.js"></script>

    <?=@$include_footer;?>
    <script>
        $(document).ready(function() {

          //Search Box Execution
          $('#search').keyup(function(){
            $('#result').show();
            $('#result').html('<a href="#" onclick="$(\'#result\').hide()">[X]</a>');
            var searchField = $('#search').val();
            var expression = new RegExp(searchField, "i");
            $.getJSON('./include/json/users.json', function(data){
              $.each(data, function(key, value){
                if(value.name.search(expression) != -1 || value.id.search(expression) != -1)
                {
                  $('#result').append('<li class="list-group-item">'
                  + '<a href="./?act=profile&user='+value.id+'"><img src="'+value.picture+'" height="40" width="40" class="img-thumbnail" /> '
                  + value.name+'   | <span class="text-muted">'+value.id+'</span></a></li>');
                }
              });
            });
          });

            //Parse data from users.json for profile viewing
            $.getJSON("./include/json/users.json", function(data){
              for(var i = 0, len = data.length; i<len; i++){
                if(data[i].id != "<?=$_SESSION['UserID'];?>"){
                  continue;
                }
                $("#profile_role").append(data[i].role);
                $("#profile_name").append(data[i].name);
              }
            });

            //Parse data from followers.JSON

            $.getJSON("./include/json/followers.json", function(data){
                      for (var i = 0, len = data.length; i < len; i++) {

                        if(data[i].follower != "<?=$_SESSION['UserID'];?>"){
                          continue;
                        }
                        $("#followers_size").append(data[i].following.length);
                        for(var j = 0, followSize = data[i].following.length; j<followSize; j++){
                          var line = `
                                    <li>
                                          <div class="dropdown-messages-box">
                                              <a href="./?act=profile&user=`+data[i].following[j]+`" class="pull-left">
                                                  <img alt="image" class="img-circle" src="./include/img/avatar/`+data[i].following[j]+`.jpg">
                                              </a>

                                              <div class="media-body">
                                                  <small class="pull-right">46h ago</small>
                                                  You are following <strong><a href="./?act=profile&user=`+data[i].following[j]+`">`+data[i].following[j]+`</a></strong> <br />
                                                  <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                                              </div>
                                          </div>
                                      </li>
                                      <li class="divider"></li>
                          `;
                        $("#followers").append(line);


                        }

                      }});

                    //Parsing of messages.json
                    $.getJSON("./include/json/messages.json", function(data){
                        var counter = 0;
                        for (var i = 0, len = data.length; i < len; i++) {
                          if(data[i].to != "<?=$_SESSION['UserID'];?>"){
                            continue;
                          }
                          counter++;
                          //A relevant message is found
                          var line = `
                          <li>
                              <div class="dropdown-messages-box">
                                  <a href="./?act=profile&user=`+data[i].from+`" class="pull-left">
                                      <img alt="image" class="img-circle" src="./include/img/avatar/`+data[i].from+`.jpg">
                                  </a>
                                  <div class="media-body">
                                      <small class="pull-right" style="color: blue;">New</small>
                                      `+data[i].message+`<br /><br />
                                      <small class="text-muted">From <a class="text-muted" href="./?act=profile&user=`+data[i].from+`">`+data[i].from+`</a></small>
                                  </div>
                              </div>
                          </li>
                          <li class="divider"></li>
                          `;
                          $("#messages").append(line);

                        }
                        $("#messages_size").append(counter);
                              });


                          //Parsing of notifications.json
                          $.getJSON("./include/json/notifications.json", function(data){
                              var counter = 0;
                              for (var i = 0, len = data.length; i < len; i++) {
                                if(data[i].user != "<?=$_SESSION['UserID'];?>"){
                                  continue;
                                }
                                counter++;
                                //A relevant message is found
                                var line = `
                                <li>
                                    <a href="#">
                                        <div>
                                            <i class="fa fa-`+data[i].type+` fa-fw"></i>
                                            </a><br />
                                            `+data[i].statement+`
                                            <span class="pull-right text-muted small">`+jQuery.timeago(data[i].timestamp)+`</span>

                                        </div>
                                    </a>
                                </li>
                                <li class="divider"></li>
                                `;
                                $("#notifications").append(line);

                              }
                              $("#notifications_size").append(counter);
                                    });

                  /*
                  Notifications Example
                  <li>
                      <a href="mailbox.html">
                          <div>
                              <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                              <span class="pull-right text-muted small">4 minutes ago</span>
                          </div>
                      </a>
                  </li>
                  <li class="divider"></li>
                  */

                /* Message example
                <li>
                    <div class="dropdown-messages-box">
                        <a href="profile.html" class="pull-left">
                            <img alt="image" class="img-circle" src="./include/img/a7.jpg">
                        </a>
                        <div class="media-body">
                            <small class="pull-right">46h ago</small>
                            <strong>asd Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                            <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                        </div>
                    </div>
                </li>
                <li class="divider"></li>
              */

            /*
            <li>


                <div class="dropdown-messages-box">
                    <a href="#" class="pull-left">
                        <img alt="image" class="img-circle" src="./include/img/a7.jpg">
                    </a>
                    <div class="media-body">
                        <small class="pull-right">46h ago</small>
                        <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                        <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                    </div>
                </div>
            </li>
            <li class="divider"></li>
            */


            setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    positionClass: "toast-bottom-right",
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 1500
                };
                toastr.warning('Loading JSON data..', 'Welcome to iScience+');

            }, 0);
            setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-bottom-right",
                    showMethod: 'slideDown',
                    timeOut: 1500
                };
                toastr.success('Loading Complete', 'Welcome to iScience+');

            }, 1500);




        });
    </script>
</body>
</html>
