<?php
/* @var $task Task */
?>

<li>
    <div class="view">
        <input class="toggle" type="checkbox">
        <label><?php echo $task->name; ?></label>
        <button class="destroy"></button>
    </div>
    <input class="edit" value="<?php echo $task->name; ?>">
</li>