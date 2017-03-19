<?php

//initially
$comment = null;

//if the form is submitted
if($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['preview-form-comment'])) {
	$comment = $_POST['preview-form-comment'];
}

?>

<html>
    <head>
        <link rel="stylesheet" href="CodeMirror/lib/codemirror.css">
    </head>
    <body>
        <form id="preview-form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<textarea id="demotext" name="preview-form-comment" id="preview-form-comment"><?php echo $comment;?></textarea>
	<br>
	<input type="submit" name="preview-form-submit" id="preview-form-submit" value="Submit">
</form>
        <script src="CodeMirror/lib/codemirror.js"></script>
        <script>
            var editor = CodeMirror.fromTextArea(demotext, {
            lineNumbers: true
            });
        </script>
    </body>
</html>

<?php
    $code=null;
    if($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['preview-form-comment'])) {
	$code = $_POST['preview-form-comment'];
        //echo "$code";
        //$test="<stdio.h>";
       // echo htmlspecialchars($test);
        $CC="gcc";
    $out="./a.out";
    $input1="4 1";
    $input2="5 10";
    $input3="52 25";
    $filename_code="main.c";
	$filename_in="input.txt";
	$filename_error="error.txt";
	$executable="a";
	$command=$CC." -lm ".$filename_code;	
	$command_error=$command." 2>".$filename_error;
	if(trim($code)=="")
            die("The code area is empty");
	$file_code=fopen("main.c","w");
	fwrite($file_code,$code);
	fclose($file_code);
        //Test Case 1
        echo "<b>Test Case 1</b>"."<br>";
        echo "Sample Input"."<br>";
        echo '4 1'."<br>";
        echo 'Expected Output'."<br>";
        echo '5'."<br>";
        echo 'Your output'."<br>";
	$file_in=fopen($filename_in,"w");
	fwrite($file_in,$input1);           //change
	fclose($file_in);
	exec("chmod 777 -R $executable"); 	//change mode to read,write and execute
	exec("chmod 777 -R $filename_error");	
	shell_exec($command_error);
	$error=file_get_contents($filename_error);
	if(trim($error)=="")
	{
		if(trim($input1)=="")       //change
		{
                    $output=shell_exec($out);
		}
		else
		{
			$out=$out." < ".$filename_in;
			$output=shell_exec($out);
		}
		echo "$output";
	}
	else if(!strpos($error,"error"))
	{
		echo "<pre>$error</pre>";
		if(trim($input)=="")
		{
			$output=shell_exec($out);
                        echo "$output";
		}
		else
		{
			$out=$out." < ".$filename_in;
			$output=shell_exec($out);
		}
		echo "$output";
	}
	else
	{
		echo "$error";
	}
	
        
        //Test Case 2
        echo "<br>"."<b>Test Case 2</b>"."<br>";
        echo "Sample Input"."<br>";
        echo '5 10'."<br>";
        echo 'Expected Output'."<br>";
        echo '15'."<br>";
        echo 'Your output'."<br>";
	$file_in=fopen($filename_in,"w");
	fwrite($file_in,$input2);           //change
	fclose($file_in);
	exec("chmod 777 -R $executable"); 
	exec("chmod 777 -R $filename_error");	
	shell_exec($command_error);
	$error=file_get_contents($filename_error);
	if(trim($error)=="")
	{
		if(trim($input2)=="")       //change
		{
                    $output=shell_exec($out);
		}
		else
		{
			$out=$out." < ".$filename_in;
			$output=shell_exec($out);
		}
		echo "$output";
	}
	else if(!strpos($error,"error"))
	{
		echo "<pre>$error</pre>";
		if(trim($input)=="")
		{
			$output=shell_exec($out);
                        echo "$output";
		}
		else
		{
			$out=$out." < ".$filename_in;
			$output=shell_exec($out);
		}
		echo "$output";
	}
	else
	{
		echo "$error";
	}

}

?>