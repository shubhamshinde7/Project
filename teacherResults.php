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
        <?php
            $connection=new MongoClient();
            $db=$connection->project;
            $A_id=$_POST['A_id'];
            $Result_Id="Result_".$A_id;
            $collection=$db->$Result_Id;
            $collection_student=$db->studentInfo;
            $cursor=$collection->find();
            echo "<table>";
            echo "<tr>";
            echo "<th>Roll No</th>";
            echo "<th>First Name</th>";
            echo "<th>Last Name</th>";
            echo "<th>Marks</th>";
            echo "<th>Code</th>";
            echo "</tr>";
            foreach ($cursor as $doc){
                $S_email=$doc['S_email'];
                $code=trim($doc['code']);
                $marks=$doc['marks'];
                $query=array('S_email'=>$S_email);
                $cursor1=$collection_student->find($query);
                foreach ($cursor1 as $doc_stu){
                    $S_rollNo=$doc_stu['S_rollNo'];
                    $S_firstName=$doc_stu['S_firstName'];
                    $S_lastName=$doc_stu['S_lastName'];
                }
                echo "<tr>";
                echo "<td>$S_rollNo</td>";
                echo "<td>$S_firstName</td>";
                echo "<td>$S_lastName</td>";
                echo "<td>$marks</td>";
                echo "<form action='viewCode.php' method='post'>";
                echo "<td><input type='submit' name='View Code' value='View Code' class='button'></td>";
                echo "<input type='hidden' name='S_firstName' value='$S_firstName'>";
                echo "<input type='hidden' name='S_lastName' value='$S_lastName'>";
                echo "<input type='hidden' name='S_rollNo' value='$S_rollNo'>";
                echo "<input type='hidden' name='code' value='$code'>";
                echo "<input type='hidden' name='marks' value='$marks'>";
                echo "</form>";
                echo "</tr>";
            }
            echo "</table>";
        ?>
    </body>
</html>