<?php
//Check if the form is submitted
if(isset($_POST['user'])){

    try{
        //Attempt to log in
        ISDB::login($_POST['user'], $_POST['password']);
        header("Location: ./");
        
    }
    catch(Exception $e){
        $error = $e;
    }
}

?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>iScience | Login</title>

    <link href="./include/css/bootstrap.min.css" rel="stylesheet">
    <link href="./include/css/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="./include/css/animate.css" rel="stylesheet">
    <link href="./include/css/style.css" rel="stylesheet">

</head>



<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>
                <h1 class="logo-name">iS+</h1>

            </div>
            <h3>Welcome to iS+</h3>
            <p>Your #1 Science Sourcing Website
                <!--Continually expanded and constantly improved Inspinia Admin Them (IN+)-->
            </p>
            <p>Log-In to see it in action!</p>
            <?php
            if(isset($error)){
              echo "<p style=\"color: red;\">".$e->getMessage()."</p>";
            }
             ?>
            <form class="m-t" role="form" action="./?act=login" method="POST">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Username" required="" name="user">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" required="" name="password">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

                <a href="#"><small>Forgot password?</small></a>
                <p class="text-muted text-center"><small>Do not have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="./?act=register">Create an account</a>
            </form>
            <p class="m-t"> <small>iScience+ &copy; 2017<br />Mickey Shalev 200681872<br />Nisan Bahar 302875646</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="./include/js/jquery-2.1.1.js"></script>
    <script src="./include/js/bootstrap.min.js"></script>

</body>

</html>
