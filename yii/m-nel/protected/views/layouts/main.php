<?php /* @var $this Controller */ ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Yii - TodoPHP</title>
    <link rel="stylesheet" href="/css/base.css">
    <!-- CSS overrides -->
    <link rel="stylesheet" href="/css/todo.css">
</head>
<body>
    
    <section id="todoapp">
        <?php echo $content; ?>
    </section>
    
    <footer id="info">
        <!-- Don't know if this functionality is required -->
        <!--<p>Double-click to edit a todo</p>-->
        
        <!-- Change this out with your name and url ↓ -->
        <p>Created by <a href="https://github.com/m-nel">Michael Nel</a></p>
        <p>Part of <a href="https://github.com/cape-town-php-group/todo-php">TodoPHP</a></p>
    </footer>

</body>
</html>
