<?php

if (isset($_POST['message'])){

    try{
      $msg = $_POST['message'];
      $user = $_SESSION['UserID'];
      $sendto = $_POST['sendto'];
      echo "test";
      ISDB::addMessage($user, $sendto, $msg);

    }
    catch(Exception $e){
        $error = $e;
        echo $error->getMessage();
    }
}




$title = "Chat";
$include_header = '<link href="./include/css/plugins/footable/footable.core.css" rel="stylesheet">';
$include_footer = '  <!-- FooTable -->


';

$addArticle = '
<div class="input-group">
    <input type="text" placeholder="Add a new project" class="input input-sm form-control">
    <span class="input-group-btn">
            <button type="button" class="btn btn-sm btn-white"> <i class="fa fa-plus"></i> Post Project</button>
    </span>
</div>
';


$content = '<div class="row">
            <div class="col-lg-12">

                <div class="ibox chat-view">



                    <div class="ibox-title">
                        <small class="pull-right text-muted">Last message:  Sun Feb 11 2018 - 11:12:36</small>
                         Chat room panel
                    </div>




                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-md-9 ">
                                <div class="chat-discussion">
                                    <div class="chat-message left">
                                        <img class="message-avatar" src="./include/img/avatar/admin.jpg" alt="">
                                        <div class="message">
                                            <a class="message-author" href="#"> Michael Smith </a>
											<span class="message-date"> Sun Feb 11 2018 - 09:13:11 </span>
                                            <span class="message-content">
											Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                                            </span>
                                        </div>
                                    </div>
                                    <div class="chat-message right">
                                        <img class="message-avatar" src="./include/img/avatar/nisanb.jpg" alt="">
                                        <div class="message">
                                            <a class="message-author" href="#"> Karl Jordan </a>
                                            <span class="message-date">  Sun Feb 11 2018 - 11:12:36 </span>
                                            <span class="message-content">
											Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for "lorem ipsum" will uncover.
                                            </span>
                                        </div>

                                    </div>

                                </div>

                            </div>
                            <div class="col-md-3">
                                <div class="chat-users">


                                    <div class="users-list">
                                        <div class="chat-user">
                                            <img class="chat-avatar" src="./include/img/avatar/admin.jpg" alt="">
                                            <div class="chat-user-name">
                                                <a href="#">Michael Smith</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>





                        <div class="row">
                            <div class="col-lg-12">
                                <div class="chat-message-form">
                                    <div class="form-group">
                                        <form class="m-t" role="form" action="./?act=chat" method="POST">
                                            <input id="sendto" name="sendto" type="hidden" value="ddf"> </input>
                                            <textarea class="form-control message-input" name="message" placeholder="Enter message text"></textarea>
                                            <input type="submit" class="btn btn-sm btn-primary"
                                             data-toggle="tooltip" data-placement="top" title=""
                                              data-original-title="Send" />
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                </div>
        </div>

    </div>';
?>
