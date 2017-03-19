<html>
    <head>
        <title>Teacher's Login</title>
        <link href="login.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="nav">
            <h1 style="text-align: center;">MIT</h1>
            <hr>
        </div>
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            <table align="center">
                <caption><h1>Teacher's Login</h1></caption>
                <tr>
                    <td><input type="text" name="email" required="required" class="ip" placeholder="Email"></td>
                </tr>
                <tr>
                    <td><input type="password" name="password" required="required" class="ip" placeholder="Password"></td>
                </tr>
                <tr>
                    <td align="center"><input type="submit" name="Submit" value="Login" class="button"></td>
                </tr>
                <tr>
                    <td align="center"><a href="newTeacher.php" class="button">New User</a></td>
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
        $collection=$db->teacherInfo;
        $query=(array("T_email"=>$email,"T_password"=>$password));
        $result=$collection->findOne($query);
        if($result){
            session_start();
            $_SESSION["T_email"]=$email;
            header("Location:teacherHomePage.php");
        }
        else{
            echo "<script type='text/javascript'>alert('Invalid username or password');</script>";
        }
    }
?>