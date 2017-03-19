<html>
    <head>
        <link href="editorCSS.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="nav">
            <h1 style="text-align: center;">MIT</h1>
            <hr>
            <a href="studentHomePage.php" style="text-decoration: none;font-size: 30px;margin-left: 41%;">Home</a>
            <a href="studentResults.php" style="text-decoration: none;text-align:  center; font-size: 30px;">Results</a>
            <a href="home.php" style="text-decoration: none;text-align: center; font-size: 30px;">Logout</a>
            <hr>
        </div>
        <?php
            $currDate= date("Y-m-d");
            $connection=new MongoClient();
            $db=$connection->project;
            $collection=$db->assignment;
            $findQuery=array('A_startDate'=>array('$lt'=>$currDate),'A_endDate'=>array('$gt'=>$currDate));
            $cursor = $collection->find($findQuery);
            echo "<h2>Active Assignmments</h2>";
            echo "<table>";
            foreach ($cursor as $doc) {
                echo "<tr>";
                echo "<form action='teacherResults.php' method='post'>";
                echo "<br>";
                $A_id=$doc['A_id'];
                echo "<td>".$doc['A_title']."</td>";
                echo "<td><input type='submit' name='Submit' value='View Results' class='button'></td>";
                echo "<input type='hidden' name='A_id' value='$A_id'>";
                echo "</form>";
                echo "</tr>";
            }
            echo "</table>";
            $findQuery=array('A_endDate'=>array('$lt'=>$currDate));
            $cursor = $collection->find($findQuery);
            echo "<h2>Completed Assignmments</h2>";
            echo "<table>";
            foreach ($cursor as $doc) {
                echo "<tr>";
                echo "<form action='teacherResults.php' method='post'>";
                echo "<br>";
                $A_id=$doc['A_id'];
                echo "<td>".$doc['A_title']."</td>";
                echo "<td><input type='submit' name='Submit' value='View Results' class='button'></td>";
                echo "<input type='hidden' name='A_id' value='$A_id'>";
                echo "</form>";
                echo "</tr>";
            }
            echo "</table>";
        ?>
    </body>
</html>