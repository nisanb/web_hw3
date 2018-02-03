<?php
require_once("./include/php/sql.php");
$error = null;

if(@isset($_POST['userid']))
{
    try{
        
        
        if($_POST['password'] != $_POST['passwordrepeat'])
            throw new Exception("Passwords do not match");
        
            echo $_FILES["avatar"]["name"];
            
        //Attempt to add an account
            ISDB::addAccount($_POST['userid'], $_POST['password'], $_POST['name'], $_POST['role'], $_POST['role_desc'], $_FILES["avatar"]);
        header("Location: ./");
    }
    catch(Exception $e)
    {
        $error = $e;
    }
   
}

?><!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>iScience | Register</title>

    <link href="./include/css/bootstrap.min.css" rel="stylesheet">
    <link href="./include/css/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="./include/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="./include/css/animate.css" rel="stylesheet">
    <link href="./include/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen   animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">iS+</h1>

            </div>
            <h3>Register to iScience+</h3>
            <p>Create account to see it in action.</p>
            <?php 
            if(@isset($error))
            {
                echo "<p style='color: red;'>".$error->getMessage()."</p>";
            }
            ?>
            <form class="form" enctype="multipart/form-data" action="./?act=register" method="POST">
                <label for="image_uploads">Account Information</label>
                <div class="form-group">
                    <input type="text" name="userid" value="<?=@$_POST['userid']?>" class="form-control" placeholder="User ID" required>
                </div>
                <div class="form-group">
                    <input type="text" name="name" value="<?=@$_POST['name']?>" class="form-control" placeholder="Full Name" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <input type="password" name="passwordrepeat" class="form-control" placeholder="Repeat Password" required>
                </div>
                <hr />
                <label for="image_uploads">Job information</label>
                <div class="form-group">
                    <input type="text" name="role" value="<?=@$_POST['role']?>" class="form-control" placeholder="Job Title" required>
                </div>
                
                <div class="form-group">
                    <input type="text" name="role_desc" value="<?=@$_POST['role_desc']?>" class="form-control" placeholder="Job Description" required>
                </div>
                <hr />
                <div class="form-group">
                <label for="image_uploads">Upload Avatar Image <span style="font-size: 8px;">(Optional)</span></label>
                    <input type="file" name="avatar" class="form-control" />
                </div>
                <hr />
                
                <div class="form-group">
                        <div class="checkbox i-checks"><label> <input type="checkbox" REQUIRED><i></i> Agree the terms and policy </label></div>
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Register</button>

                <p class="text-muted text-center"><small>Already have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="./?act=login">Login</a>
            </form>
            <p class="m-t"> <small>iScience - 2018 &copy;</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="./include/js/jquery-2.1.1.js"></script>
    <script src="./include/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="./include/js/plugins/iCheck/icheck.min.js"></script>
    
    <!-- DROPZONE -->
    <script src="js/plugins/dropzone/dropzone.js"></script>


    
    <script>
        $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
        
    </script>
    
</body>

</html>
