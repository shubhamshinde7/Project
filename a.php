<html>
    <head>
        <title>Sample Code</title>
    </head>
    <body>
        <h2><b>Problem Statement</b></h2>
        Write a C program for addition of two numbers.
        <h2><b>Sample Input</b></h2>
        4 1
        <h2><b>Sample Output</b></h2>
        5
        <h2><b>Explanation</b></h2>
        4+1=5
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
            <h2>Write your code here!!!</h2>
            <table>
                <tr>
                    <td>
            <textarea rows="20" cols="50" name="code">
#include<stdio.h>
int main()
{
    int a,b,c;
    scanf("%d %d",&a,&b);
    c=a+b;
    printf("%d",c);
    return 0;
}
            </textarea>
            </td>
            </tr>
            </table>
            <input type="submit" name="submit" value="submit">
        </form>
    </body>
</html>
<?php
if(isset($_POST['submit']))
{   
    $code=$_POST['code'];
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
                    echo "without input file";
		}
		else
		{
			$out=$out." < ".$filename_in;
			$output=shell_exec($out);
                        echo "With input file without error";
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
                 
                echo "here";
	}
	else
	{
		echo "$error";
	}
}
?>
