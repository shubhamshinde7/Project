<html>
    <head>
        <title>Students Login</title>
        <link href="login.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="nav">
            <h1 style="text-align: center;">MIT</h1>
            <hr>
        </div>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
            <table align="center">
                <caption><h1>Students Login</h1></caption>
                <tr>
                    <td><input type="text" name="email" class="ip" placeholder="Email" required="required"></td>
                </tr>
                <tr>
                    <td><input type="password" name="password" class="ip" placeholder="Password" required="required"></td>
                </tr>
                <tr>
                    <td align="center"><input type="submit" name="Submit" value="Login" class="button"></td>
                </tr>
                <tr>
                    <td align="center"><a href="newStudent.php" class="button">New User</a></td>
                </tr>
            </table>
        </form>
    </body>
</html>


<?php
    if(!empty($_POST['Submit'])){
        $email=$_POST['email'];
        $password=$_POST['password'];
        $connection=new MongoClient();
        $db=$connection->project;
        $collection=$db->studentInfo;
        $query=(array("S_email"=>$email,"S_password"=>$password));
        $result=$collection->findOne($query);
        if($result){
            session_start();
            $_SESSION['S_email']=$email;
            header('Location:studentHomePage.php');
        }
        else{
            echo "<script type='text/javascript'>alert('Invalid username or password');</script>";
        }
    }
?>