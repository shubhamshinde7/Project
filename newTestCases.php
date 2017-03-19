<?php
    date_default_timezone_set("Asia/Kolkata");
    session_start();
    $A_id=$_SESSION['A_id'];
?>

<html>
    <head>
        <link href="editorCSS.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="nav">
            <h1 style="text-align: center;">MIT</h1>
            <hr>
            <a href="teacherHomePage.php" style="text-decoration: none;font-size: 30px;margin-left: 41%;">Home</a>
            <a href="teacherResults.php" style="text-decoration: none;text-align:  center; font-size: 30px;">Results</a>
            <a href="home.php" style="text-decoration: none;text-align: center; font-size: 30px;">Logout</a>
            <hr>
        </div>
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            <table align="center">
                <caption><h1>New Test Cases</h1></caption>
                <tr>
                    <td>Input 1</td>
                    <td>:</td>
                    <td><textarea rows="5" cols="70" name="A_ip1" required="required"></textarea></td>
                </tr>
                <tr>
                    <td>Output 1</td>
                    <td>:</td>
                    <td><textarea rows="5" cols="70" name="A_op1" required="required"></textarea></td>
                </tr>
                <tr>
                    <td>Input 2</td>
                    <td>:</td>
                    <td><textarea rows="5" cols="70" name="A_ip2"></textarea></td>
                </tr>
                <tr>
                    <td>Output 2</td>
                    <td>:</td>
                    <td><textarea rows="5" cols="70" name="A_op2"></textarea></td>
                </tr>
                <tr>
                    <td>Input 3</td>
                    <td>:</td>
                    <td><textarea rows="5" cols="70" name="A_ip3"></textarea></td>
                </tr>
                <tr>
                    <td>Output 3</td>
                    <td>:</td>
                    <td><textarea rows="5" cols="70" name="A_op3"></textarea></td>
                </tr>
                <tr>
                    <td>Input 4</td>
                    <td>:</td>
                    <td><textarea rows="5" cols="70" name="A_ip4"></textarea></td>
                </tr>
                <tr>
                    <td>Output 4</td>
                    <td>:</td>
                    <td><textarea rows="5" cols="70" name="A_op4"></textarea></td>
                </tr>
                <tr>
                    <td>Input 5</td>
                    <td>:</td>
                    <td><textarea rows="5" cols="70" name="A_ip5"></textarea></td>
                </tr>
                <tr>
                    <td>Output 5</td>
                    <td>:</td>
                    <td><textarea rows="5" cols="70" name="A_op5"></textarea></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td><input type="submit" name="Submit" value="Submit" class="button"></td>
                </tr>
            </table>
        </form>
    </body>
</html>

<?php
    if(!empty($_POST['Submit'])){
        $A_input1=$_POST['A_ip1'];
        $A_input2=$_POST['A_ip2'];
        $A_input3=$_POST['A_ip3'];
        $A_input4=$_POST['A_ip4'];
        $A_input5=$_POST['A_ip5'];
        $A_output1=$_POST['A_op1'];
        $A_output2=$_POST['A_op2'];
        $A_output3=$_POST['A_op3'];
        $A_output4=$_POST['A_op4'];
        $A_output5=$_POST['A_op5'];
        $connection=new MongoClient();
        $db=$connection->project;
        $collection=$db->assignment;
        $details=array(
            "A_input1"=>$A_input1,
            "A_input2"=>$A_input2,
            "A_input3"=>$A_input3,
            "A_input4"=>$A_input4,
            "A_input5"=>$A_input5,
            "A_output1"=>$A_output1,
            "A_output2"=>$A_output2,
            "A_output3"=>$A_output3,
            "A_output4"=>$A_output4,
            "A_output5"=>$A_output5
        );
        $query=$collection->findAndModify(
                array("A_id"=>$A_id),
                array('$set'=>$details)
        );
        header('Location:teacherHomePage.php');
    }
?>