<?php

if (isset($_POST['message'])){

    try{
      $msg = $_POST['message'];
      $user = $_SESSION['UserID'];
      $sendto = $_POST['sendto'];
      ISDB::addMessage($user, $sendto, $msg);

    }
    catch(Exception $e){
        $error = $e;
        echo $error->getMessage();
    }
}


$userList = ISDB::getUsers($_SESSION['UserID']);


$title = "Chat";
$include_header = '<link href="./include/css/plugins/footable/footable.core.css" rel="stylesheet">';
$include_footer = '  <!-- FooTable -->

<script>

$("#chatbox").stop().animate({
  scrollTop: $("#chatbox")[0].scrollHeight
}, 800);
</script>
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
                         Message Box
                    </div>




                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-md-9 ">
                                <div class="chat-discussion" id="chatbox">
';

//Get messages from user & to
if(@isset($_GET['from']))
{
    $content .= ' <div class="chat-message left">
    <img class="message-avatar" src="./include/img/avatar/Default.png" alt="">
    <div class="message">
    <a class="message-author" href="#"> iScience+ </a>
    <span class="message-date"> Sun Feb 11 2018 - 09:13:11 </span>
    <span class="message-content">
This is the start of your chat history with <a href="./?act=profile&user='.$_GET['from'].'">'.$_GET['from'].'</a>!<br />
    Please use the textbox below in order to send a private message.
    </span>
    </div>
    </div>
        
';
    foreach(ISDB::getMessages($_GET['from']) as $message)
    {
        $mine = "left";
        if($message["FromID"] == $_SESSION['UserID'])
        {
            $mine = "right";
        }
        
        $userDetails = ISDB::getUserDetails($message["FromID"]);
        
        $content .= '

 <div class="chat-message '.$mine.'">
    <img class="message-avatar" src="./include/img/avatar/'.$userDetails["profilepic"].'" alt="">
    <div class="message">
    <a class="message-author" href="#"> '.$userDetails["name"].' </a>
    <span class="message-date"> '.ISDB::time_elapsed_string($message["date"]).' </span>
    <span class="message-content">
'.nl2br($message["strMessage"]).'
    </span>
    </div>
    </div>
';
        
    }
    

}
else
{
   $content .= ' <div class="chat-message left">
    <img class="message-avatar" src="./include/img/avatar/Default.png" alt="">
    <div class="message">
    <a class="message-author" href="#"> iScience+ </a>
    <span class="message-date"> Sun Feb 11 2018 - 09:13:11 </span>
    <span class="message-content">
Welcome to our chat feature!<br />
    Please choose a user to chat with.
    </span>
    </div>
    </div>
    
';
}

$content .= '
                                    

                                </div>

                            </div>
                            <div class="col-md-3">
                                <div class="chat-users">


                                    <div class="users-list">
';

foreach(ISDB::getUsers($_SESSION['UserID']) as $user)
{
    if($user["id"] == @$_GET['from'])
    {
        $isactive = 'style="background-color: #eee;"';
    }
    $content .= '
 <div class="chat-user" '.@$isactive.'>
                                            <img class="chat-avatar img-circle" src="./include/img/avatar/'.$user["profilepic"].'" alt="">
                                            <div class="chat-user-name">
                                                <a href="./?act=chat&from='.$user["id"].'">'.$user["name"].'</a>
                                            </div>
                                        </div>
';
}

if(!@isset($_GET['from']))
{
    $disabled = 'DISABLED';
    $placeholder = "Please select a user in order to message.";
}
else
{
    $placeholder = "Enter message text";
}
$content .= '
                                       
                                    </div>
                                </div>
                            </div>
                        </div>





                        <div class="row">
                            <div class="col-lg-12">
                                <div class="chat-message-form">
                                    <div class="form-group">
                                        <form class="m-t" role="form" method="POST" action="./?act=chat&from='.@$_GET['from'].'">
                                            <input id="sendto" name="sendto" type="hidden" value="'.@$_GET['from'].'"> </input>
                                            <textarea '.@$disabled.' class="form-control message-input" name="message" placeholder="'.$placeholder.'"></textarea>
                                            <input '.@$disabled.' type="submit" class="btn btn-sm btn-primary"
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
