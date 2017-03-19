<?php
$comment = null;
$A_id=null;
$S_email=null;
$flag=0;
$Result_Id=null;
$connection=new MongoClient();
$db=$connection->project;
if($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['preview-form-comment'])) {
	$comment = $_POST['preview-form-comment'];
        $S_email=$_POST['S_email'];
        $A_id=$_POST['A_id'];
        $Result_Id=$_POST['Result_Id'];
}
?>


<html>
    <head>
        <title>Assignment's</title>
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
        <a href="studentHomePage.php" style="text-decoration: none;font-size: 30px;margin-left: 41%;">Home</a>
        <a href="studentResults.php" style="text-decoration: none;text-align:  center; font-size: 30px;">Results</a>
        <a href="home.php" style="text-decoration: none;text-align: center; font-size: 30px;">Logout</a>
        <hr>
        </div>
        <div class="theory">
<?php
    $collection=$db->assignment;
    $A_id=$_POST['A_id'];
    $Result_Id="Result_".$A_id;          //result database name
    $query=$db->createCollection($Result_Id);
    $realId=new MongoId($A_id);         //change string to mongoid data type
    $S_email=$_POST['S_email'];
    $findQuery=array('A_id'=>$realId);
    $marks=0;
    $cursor = $collection->find($findQuery)->limit(1);
    foreach ($cursor as $doc){
        echo "<h3>Title</h3>";
        echo "<pre>".$doc['A_title']."</pre>";
        echo "<h3>Problem Statement</h3>";
        echo "<pre>".$doc['A_problem']."</pre>";
        echo "<h3>Input Format</h3>";
        echo $doc['A_inputFormat'];
        echo "<h3>Constraints</h3>";
        echo "<pre>".$doc['A_inputCons']."</pre>";
        echo "<h3>Output Format</h3>";
        echo "<pre>".$doc['A_outputFormat']."</pre>";
        echo "<h3>Sample Input</h3>";
        echo "<pre>".$doc['A_sampleInput']."</pre>";
        echo "<h3>Sample Output</h3>";
        echo "<pre>".$doc['A_sampleOutput']."</pre>";
        echo "<br>";
        $A_input1=trim($doc['A_input1']);
        $A_input2=trim($doc['A_input2']);
        $A_input3=trim($doc['A_input3']);
        $A_input4=trim($doc['A_input4']);
        $A_input5=trim($doc['A_input5']);
        $A_output1=trim($doc['A_output1']);
        $A_output2=trim($doc['A_output2']);
        $A_output3=trim($doc['A_output3']);
        $A_output4=trim($doc['A_output4']);
        $A_output5=trim($doc['A_output5']);
    }
    $coll_res=$db->$Result_Id;
    $find_res=array('S_email'=>$S_email);
    $cursor=$coll_res->find($find_res);
    foreach ($cursor as $doc1){
        $comment=$doc1['code'];
    }
    //var_dump($db->prevError());
    //var_dump($db->getCollectionInfo());
?>
        </div>
        <div class="editor_block">
            <h3>Editor</h3>
            <form id="preview-form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" name="A_id" value="<?php echo $A_id;?>">
                <input type="hidden" name="S_email" value="<?php echo $S_email;?>">
                <input type="hidden" name="Result_Id" value="<?php echo $Result_Id;?>">
                <textarea id="c-code" name="preview-form-comment" id="preview-form-comment"><?php echo $comment;?></textarea>
                <br>
                <input type="submit" name="preview-form-submit" id="preview-form-submit" value="Compile&Run" class="button">
                <input type="submit" name="testcases" value="Submit" class="button">
            </form>
            
            <script>
                var editor = CodeMirror.fromTextArea(document.getElementById("c-code"), {
                    lineNumbers: true,
                    matchBrackets: true,
                    mode: "text/x-java"
                });
                
                $('#c-code').autogrow();
                $('#c-code').css('overflow', 'hidden').autogrow();
            </script>
        </div>
    

<?php
    $output=null;
    $CC="gcc";
    $out="./a.out";
    $filename_code="main.c";
    $filename_in="input.txt";
    $filename_error="error.txt";
    $executable="a";
    $command=$CC." -lm ".$filename_code;	
    $command_error=$command." 2>".$filename_error;
    if(isset($_POST['preview-form-submit'])){       //Compile and Run
        $code=$_POST['preview-form-comment'];
        $comment=$_POST['preview-form-comment'];
        $file_code=fopen("main.c","w");
	fwrite($file_code,$code);
	fclose($file_code);
        exec("chmod 777  $executable"); 	//change mode to read,write and execute
	exec("chmod 777  $filename_error");	
	shell_exec($command_error);
	$error=file_get_contents($filename_error);
        if(strlen($error)>0){
         //   echo "<pre>$error</pre>";
        }
        else{
            $flag=1;
            if(trim($error)=="")
            {
                $file_in=fopen($filename_in,"w");
                fwrite($file_in,$A_input1);           
                fclose($file_in);
		if(trim($A_input1)=="")       
		{
                    $output=shell_exec($out);
		}
		else
		{
                    $out=$out." < ".$filename_in;
                    $output=shell_exec($out);
		}
		//echo "$output";
            }
            $find_res=array('S_email'=>$S_email);
            $coll_res=$db->$Result_Id;
            $cursor=$coll_res->find($find_res);
            if($cursor){
                $data=array('S_email'=>$S_email,'code'=>$code);
                $query=$coll_res->insert($data);
            }
            else{
                $query=$coll_res->update(array('S_email'=>$S_email),array('$set'=>array('code'=>$code)));
            }
        }
        echo "<h3>Result</h3><hr>";
        echo "<h4>Input<h4>";
        echo "<pre>$A_input1</pre>";
        echo "<h4>Your Code's Output</h4>";
        echo "<pre>$output</pre>";
        echo "<h4>Expected Correct Output</h4>";
        echo "<pre>$A_output1</pre>";
        echo "<h4>Compilation Log</h4>";
        if(strlen($error)==0){
            echo "Compiled Sucessfully";
        }
        else {
            echo "<pre>$error</pre>";
        }
    }
    if(isset($_POST['testcases'])){             //Test Case Evaluation
        $code=$_POST['preview-form-comment'];
        echo "<h3>Result</h3>";
        echo "<table>";
        echo "<tr>";
        echo "<th>Input</th>";
        echo "<th>Result</th>";
        echo "<th>Score</th>";
        echo "</tr>";
        if($A_input1!=""){
            $file_code=fopen("main.c","w");
            fwrite($file_code,$code);
            fclose($file_code);
            exec("chmod 777  $executable"); 	//change mode to read,write and execute
            exec("chmod 777  $filename_error");	
            shell_exec($command_error);
            $error=file_get_contents($filename_error);
            if(strlen($error)>0){
                //echo "<pre>$error</pre>";
            }
            else{
                $flag=1;
                if(trim($error)=="")
                {
                    $file_in=fopen($filename_in,"w");
                    fwrite($file_in,$A_input1);           
                    fclose($file_in);
                    if(trim($A_input1)=="")       
                    {
                        $output=shell_exec($out);
                    }
                    else
                    {
                        $out=$out." < ".$filename_in;
                        $output=shell_exec($out);
                    }
                   // echo "$output";
                }
            }
            echo "<tr>";
            echo "<td>#Input1</td>";
            if(strcmp(trim($output),$A_output1)==0){
                $marks=$marks+10;
                echo "<td>Accepted</td>";
                echo "<td>10</td>";
            }
            else{
                echo "<td>Wrong Answer</td>";
                echo "<td>0.0</td>";
            }
            echo "</tr>";
        }
        if($A_input2!=""){
            $file_code=fopen("main.c","w");
            fwrite($file_code,$code);
            fclose($file_code);
            exec("chmod 777  $executable"); 	//change mode to read,write and execute
            exec("chmod 777  $filename_error");	
            shell_exec($command_error);
            $error=file_get_contents($filename_error);
            if(strlen($error)>0){
              //  echo "<pre>$error</pre>";
            }
            else{
                $flag=1;
                if(trim($error)=="")
                {
                    $file_in=fopen($filename_in,"w");
                    fwrite($file_in,$A_input2);           
                    fclose($file_in);
                    if(trim($A_input2)=="")       
                    {
                        $output=shell_exec($out);
                    }
                    else
                    {
                        $out=$out." < ".$filename_in;
                        $output=shell_exec($out);
                    }
                   // echo "$output";
                }
            }
            echo "<tr>";
            echo "<td>#Input2</td>";
            if(strcmp(trim($output),$A_output2)==0){
                $marks=$marks+10;
                echo "<td>Accepted</td>";
                echo "<td>10</td>";
            }
            else{
                echo "<td>Wrong Answer</td>";
                echo "<td>0.0</td>";
            }
            echo "</tr>";
        }
        if($A_input3!=""){
            $file_code=fopen("main.c","w");
            fwrite($file_code,$code);
            fclose($file_code);
            exec("chmod 777  $executable"); 	//change mode to read,write and execute
            exec("chmod 777  $filename_error");	
            shell_exec($command_error);
            $error=file_get_contents($filename_error);
            if(strlen($error)>0){
               // echo "<pre>$error</pre>";
            }
            else{
                $flag=1;
                if(trim($error)=="")
                {
                    $file_in=fopen($filename_in,"w");
                    fwrite($file_in,$A_input3);           
                    fclose($file_in);
                    if($A_input3=="")       
                    {
                        $output=shell_exec($out);
                    }
                    else
                    {
                        $out=$out." < ".$filename_in;
                        $output=shell_exec($out);
                    }
                    //echo "$output";
                }
            }
            echo "<tr>";
            echo "<td>#Input3</td>";
            if(strcmp(trim($output),$A_output3)==0){
                $marks=$marks+10;
                echo "<td>Accepted</td>";
                echo "<td>10</td>";
            }
            else{
                echo "<td>Wrong Answer</td>";
                echo "<td>0.0</td>";
            }
            echo "</tr>";
        }
        if($A_input4!=""){
            $file_code=fopen("main.c","w");
            fwrite($file_code,$code);
            fclose($file_code);
            exec("chmod 777  $executable"); 	//change mode to read,write and execute
            exec("chmod 777  $filename_error");	
            shell_exec($command_error);
            $error=file_get_contents($filename_error);
            if(strlen($error)>0){
              //  echo "<pre>$error</pre>";
            }
            else{
                $flag=1;
                if(trim($error)=="")
                {
                    $file_in=fopen($filename_in,"w");
                    fwrite($file_in,$A_input4);           
                    fclose($file_in);
                    if(trim($A_input4)=="")       
                    {
                        $output=shell_exec($out);
                    }
                    else
                    {
                        $out=$out." < ".$filename_in;
                        $output=shell_exec($out);
                    }
                   // echo "$output";
                }
            }
            echo "<tr>";
            echo "<td>#Input4</td>";
            if(strcmp(trim($output),$A_output4)==0){
                $marks=$marks+10;
                echo "<td>Accepted</td>";
                echo "<td>10</td>";
            }
            else{
                echo "<td>Wrong Answer</td>";
                echo "<td>0.0</td>";
            }
            echo "</tr>";
        }
        if($A_input5!=""){
            $file_code=fopen("main.c","w");
            fwrite($file_code,$code);
            fclose($file_code);
            exec("chmod 777  $executable"); 	//change mode to read,write and execute
            exec("chmod 777  $filename_error");	
            shell_exec($command_error);
            $error=file_get_contents($filename_error);
            if(strlen($error)>0){
                //echo "<pre>$error</pre>";
            }
            else{
                $flag=1;
                if(trim($error)=="")
                {
                    $file_in=fopen($filename_in,"w");
                    fwrite($file_in,$A_input5);           
                    fclose($file_in);
                    if(trim($A_input5)=="")       
                    {
                        $output=shell_exec($out);
                    }
                    else
                    {
                        $out=$out." < ".$filename_in;
                        $output=shell_exec($out);
                    }
                   // echo "$output";
                }
            }
            echo "<tr>";
            echo "<td>#Input5</td>";
            if(strcmp(trim($output),$A_output5)==0){
                $marks=$marks+10;
                echo "<td>Accepted</td>";
                echo "<td>10</td>";
            }
            else{
                echo "<td>Wrong Answer</td>";
                echo "<td>0.0</td>";
            }
            echo "</tr>";
        }
        $find_res=array('S_email'=>$S_email);
        $coll_res=$db->$Result_Id;
        $cursor=$coll_res->find($find_res);
        if(count($cursor)==0){
            $data=array('S_email'=>$S_email,'code'=>$code,'marks'=>$marks);
            $query=$coll_res->insert($data);
        }
        else{
            $query=$coll_res->update(array('S_email'=>$S_email),array('$set'=>array('code'=>$code,'marks'=>$marks)));
        }
    }
    echo "</table>";  
?>
    </body>
</html>