<?php
/* @var $this SiteController */
/* @var $error array */
?>

<header id="header">
    <h1>error <?php echo $code; ?></h1>
    <div class="error">
        <?php echo CHtml::encode($message); ?>
    </div>
</header>