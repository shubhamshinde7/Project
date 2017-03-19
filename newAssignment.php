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
                <caption><h1>New Assignment</h1></caption>
                <tr>
                    <td>Title</td>
                    <td>:</td>
                    <td><textarea rows="5" cols="70" name="A_title" required="required"></textarea></td>
                </tr>
                <tr>
                    <td>Start Date</td>
                    <td>:</td>
                    <td><input type="date" name="A_startDate" required="required"></td>
                </tr>
                <tr>
                    <td>End Date</td>
                    <td>:</td>
                    <td><input type="date" name="A_endDate" required="required"></td>
                </tr>
                <tr>
                    <td>Problem Statement</td>
                    <td>:</td>
                    <td><textarea rows="5" cols="70" name="A_problem" required="required"></textarea></td>
                </tr>
                <tr>
                    <td>Theory</td>
                    <td>:</td>
                    <td><textarea rows="5" cols="70" name="A_theory" required="required"></textarea></td>
                </tr>
                <tr>
                    <td>Input Format</td>
                    <td>:</td>
                    <td><textarea rows="5" cols="70" name="A_inputFormat" required="required"></textarea></td>
                </tr>
                <tr>
                    <td>Input Constraints</td>
                    <td>:</td>
                    <td><textarea rows="5" cols="70" name="A_inputCons" required="required"></textarea></td>
                </tr>
                <tr>
                    <td>Output Format</td>
                    <td>:</td>
                    <td><textarea rows="5" cols="70" name="A_outputFormat" required="required"></textarea></td>
                </tr>
                <tr>
                    <td>Sample Input</td>
                    <td>:</td>
                    <td><textarea rows="5" cols="70" name="A_sampleInput" required="required"></textarea></td>
                </tr>
                <tr>
                    <td>Sample Output</td>
                    <td>:</td>
                    <td><textarea rows="5" cols="70" name="A_sampleOutput" required="required"></textarea></td>
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
        date_default_timezone_set("Asia/Kolkata");
        $A_title=$_POST['A_title'];
        $A_problem=$_POST['A_problem'];
        $A_startDate=$_POST['A_startDate'];
        $A_endDate=$_POST['A_endDate'];
        $A_theory=$_POST['A_theory'];
        $A_inputFormat=$_POST['A_inputFormat'];
        $A_inputCons=$_POST['A_inputCons'];
        $A_outputFormat=$_POST['A_outputFormat'];
        $A_sampleInput=$_POST['A_sampleInput'];
        $A_sampleOutput=$_POST['A_sampleOutput'];
        $A_id=new MongoId();
        $connection=new MongoClient();
        $db=$connection->project;
        $collection=$db->createCollection("assignment");
        $details=array(
            "A_title"=>$A_title,
            "A_id"=>$A_id,
            "A_problem"=>$A_problem,
            "A_startDate"=>$A_startDate,
            "A_endDate"=>$A_endDate,
            "A_theory"=>$A_theory,
            "A_inputFormat"=>$A_inputFormat,
            "A_inputCons"=>$A_inputCons,
            "A_outputFormat"=>$A_outputFormat,
            "A_sampleInput"=>$A_sampleInput,
            "A_sampleOutput"=>$A_sampleOutput
        );
        $collection->insert($details);
        session_start();
        $_SESSION['A_id']=$A_id;
        echo "<script type='text/javascript'>alert('New assignment created sucessfully');</script>";
        header('Location:newTestCases.php');
    }
?>