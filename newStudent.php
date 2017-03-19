<html>
	<head>
		<title>New Student Signin</title>
                <link href="login.css" rel="stylesheet" type="text/css"/>
	</head>
	<body>
            <div class="nav">
                <h1 style="text-align: center;">MIT</h1>
                <hr>
            </div>
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                <table align="center">
                    <caption><h1>New Student Registration</h1></caption>
			<tr>
                            <td><input type="text" name="S_firstName" required="required" class="ip" placeholder="First Name"></td>
			</tr>
			<tr>
                            <td><input type="text" name="S_lastName"required="required" class="ip" placeholder="Last Name"></td>
			</tr>
			<tr>
                                <td><input type="text" name="S_rollNo" required="required" class="ip" placeholder="Roll No"></td>
			</tr>
			<tr>
                            <td><input type="Email" name="S_email" required="required" class="ip" placeholder="Email"></td>
			</tr>
			<tr>
                            <td><input type="text" name="S_mobileNo" required="required" class="ip" placeholder="Mobile No"></td>
			</tr>
			<tr>
                            <td><input type="password" name="S_password" required="required" class="ip" placeholder="Password"></td>
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
        $S_firstName=$_POST['S_firstName'];
        $S_lastName=$_POST['S_lastName'];
        $S_rollNo=$_POST['S_rollNo'];
        $S_email=$_POST['S_email'];
        $S_mobileNo=$_POST['S_mobileNo'];
        $S_password=$_POST['S_password'];
        $connection=new MongoClient();
        $db=$connection->project;
        $collection=$db->createCollection("studentInfo");
        $details=array(
            "S_firstName"=>$S_firstName,
            "S_lastName"=>$S_lastName,
            "S_rollNo"=>$S_rollNo,
            "S_email"=>$S_email,
            "S_mobileNo"=>$S_mobileNo,
            "S_password"=>$S_password
        );
        $collection->insert($details);
        echo "<script type='text/javascript'>alert('New user created sucessfully');</script>";
        header('Location:studentLogin.php');
    }
?>