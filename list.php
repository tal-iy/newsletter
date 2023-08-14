<?php

require 'Newsletter.php';

?>

<!DOCTYPE html>
<html>
<head>
    <title>Treehouse Newsletter List</title>
    <link rel="stylesheet" href="common.css">
</head>
<body>
<br>
<br>
<br>
<h1>Treehouse Newsletter</h1>
<br>
<div class="content">
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Date</th>
        </tr>
        <?php Newsletter::showList(); ?>
    </table>
</div>
<br>
<div class="content">
    <a href="index.php"><input type="button" value="Return To Signup Form"></a>
</div>
</body>
</html>
