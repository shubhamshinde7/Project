<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Editor</title>
  <link href="editorCSS.css" rel="stylesheet" type="text/css"/>
  <style type="text/css" media="screen">
    body {
        overflow: hidden;
    }
  </style>
</head>
<body>
<pre id="editor">
#include <stdio.h>
int main(){

}
</pre>
<script src="Ace/src-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
<script>
    var editor = ace.edit("editor");
    editor.setTheme("ace/theme/eclipse");
    editor.session.setMode("ace/mode/c_cpp");
    var code=editor.getValue();
    document.getElementById('editor').style.fontSize='22px';
    editor.setShowPrintMargin(false);
    
</script>
<h1>
<?php
    $code="<script>document.writeln(code);</script>";
    echo $code;
    ?>
</h1>
</body>
</html>

