<html>
	<head>
		<title>New Teacher Signin</title>
                <link href="login.css" rel="stylesheet" type="text/css"/>
	</head>
	<body>
            <div class="nav">
            <h1 style="text-align: center;">MIT</h1>
            <hr>
        </div>
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
		<table align="center">
                    <caption><h1>New Teacher's Registration</h1></caption>
			<tr>
                            <td><input type="text" name="T_firstName" required="required" class="ip" placeholder="First Name"></td>
			</tr>
			<tr>
                            <td><input type="text" name="T_lastName" required="required" class="ip" placeholder="Last Name"></td>
			</tr>
			<tr>
                            <td><input type="Email" name="T_email" required="required" class="ip" placeholder="Email"></td>
			</tr>
			<tr>
                            <td><input type="text" name="T_mobileNo" required="required" class="ip" placeholder="Mobile No"></td>
			</tr>
			<tr>
                            <td><input type="password" name="T_password" required="required" class="ip" placeholder="Password"></td>
			</tr>
                        <tr>
                            <td align="center"><input type="submit" name="Submit" value="Signin" class="button"></td>
			</tr>
		</table>
            </form>
	</body>
</html>

<?php
    if(!empty($_POST['Submit'])){
        $T_firstName=$_POST['T_firstName'];
        $T_lastName=$_POST['T_lastName'];
        $T_email=$_POST['T_email'];
        $T_mobileNo=$_POST['T_mobileNo'];
        $T_password=$_POST['T_password'];
        $connection=new MongoClient();
        $db=$connection->project;
        $collection=$db->createCollection("teacherInfo");
        $details=array(
            "T_firstName"=>$T_firstName,
            "T_lastName"=>$T_lastName,
            "T_email"=>$T_email,
            "T_mobileNo"=>$T_mobileNo,
            "T_password"=>$T_password
        );
        $collection->insert($details);
        echo "<script type='text/javascript'>alert('New user created sucessfully');</script>";
        header('Location:teacherLogin.php');
    }
?>