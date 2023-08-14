<?php

require 'Newsletter.php';
$form = new Newsletter('post','index.php');

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Treehouse Newsletter Signup</title>
        <link rel="stylesheet" href="common.css">
    </head>
    <body>
        <br>
        <br>
        <br>
        <h1>Treehouse Newsletter</h1>
        <br>
        <div class="content">
            <?php $form->showForm(); ?>
        </div>
        <br>
        <div class="content">
            <a href="list.php"><input type="button" value="View Current List"></a>
        </div>
    </body>
</html>
