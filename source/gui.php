<?php
require_once('./stelib.php');
require_once('./pluto.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Pluto frontend</title>
        <style type="text/css">
            form {
                border: thin dashed #000000;            
            }
            figure {
                margin-left: 0%;
                margin-left: 0%;
                border: thin dashed #0000FF;            
            }
        </style>
    </head>
    <body>
        <p>Diagram Title: <?php echo $_POST['diagtitle']; ?></p>
        <form action="" method="POST">
            <div>Diagram Title:
            <!--<input name="diagtitle" type="text"></div>-->
            <div>Please give me a *.pluto file.
            <input name="input_file" type="file"></div>
            <input type="submit" value="OK">
        </form>
        <div>
        </div>
        <textarea cols="79" rows="20">
        
        </textarea>
        <div>
            <?php
            echo $_POST['input_file'] . "\n";
            echo read_file($_POST['input_file']);
            ?>
        </div>
        <figure>
            <figcaption>The output diagram</figcaption>
            <img src="out.png" alt="the output image">        
        </figure>
    </body>
</html>
