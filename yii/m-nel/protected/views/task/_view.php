<?php
/* @var $task Task */
?>

<li <?php echo $task->isCompleted()?'class="completed"':''; ?>>
    <div class="view">
        <?php echo CHtml::checkBox('task-status', $task->isCompleted(), array(
            'class'=>'toggle',
            'data-target'=>Yii::app()->createAbsoluteUrl('task/toggle', array('id'=>$task->id)),
        )); ?>

        <label><?php echo $task->name; ?></label>
        
        <button class="destroy" data-target="<?php echo Yii::app()->createAbsoluteUrl('task/delete', array('id'=>$task->id)); ?>"></button>
    </div>
    <input class="edit" value="<?php echo $task->name; ?>">
</li>