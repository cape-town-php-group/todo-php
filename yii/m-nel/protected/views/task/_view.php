<?php
/* @var $task Task */
?>

<li <?php echo $task->isCompleted()?'class="completed"':''; ?>>
    <div class="view">
        <input class="toggle" type="checkbox" <?php echo $task->isCompleted()?'checked':''; ?>>
        <label><?php echo $task->name; ?></label>
        <button class="destroy"></button>
    </div>
    <input class="edit" value="<?php echo $task->name; ?>">
</li>