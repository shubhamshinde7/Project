<?php
$connection=new MongoClient();
$db=$connection->project;
$S_firstName=$_POST['S_firstName'];
$S_lastName=$_POST['S_lastName'];
$S_rollNo=$_POST['S_rollNo'];
$code=$_POST['code'];
$marks=$_POST['marks'];
?>
<html>
    <head>
        <link href="editorCSS.css" rel="stylesheet" type="text/css"/>
        <link href="CodeMirror/lib/codemirror.css" rel="stylesheet" type="text/css"/>
        <script src="CodeMirror/addon/edit/matchbrackets.js"></script>
        <link href="CodeMirror/addon/hint/show-hint.css" rel="stylesheet" type="text/css"/>
        <script src="CodeMirror/addon/hint/show-hint.js"></script>
        <script src="CodeMirror/mode/clike/clike.js"></script>
        <script src="CodeMirror/lib/codemirror.js"></script>
        <script src="jquery-3.1.1.min.js" type="text/javascript"></script>
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
        <h3>Name</h3>
        <?php echo "$S_firstName $S_lastName";?>
        <h3>Roll No</h3>
        <?php echo "$S_rollNo";?>
        <h3>Marks Obtained</h3>
        <?php echo $marks;?>
        <h3>Code</h3>
        <div id="editor">
            <textarea id="c-code"><?php echo $code;?></textarea>
            <script>
                var editor = CodeMirror.fromTextArea(document.getElementById("c-code"), {
                    lineNumbers: true,
                    matchBrackets: true,
                    mode: "text/x-csrc"
                });
            </script>
        </div>
    </body>
    </head>
</html>