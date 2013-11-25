<?php
/* @var $this TaskController */
/* @var $form CActiveForm */
/* @var $allTasksCompleted boolean */

Yii::app()->clientScript->registerScript('toggle-all', "
    $('#toggle-all').bind('change', function() {
        $('#toggle-all-form').submit();
    });
");
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'toggle-all-form',
    'action'=>Yii::app()->createAbsoluteUrl('task/toggleAll'),
)); ?>

    <?php echo CHtml::hiddenField('toggleAll', 0); ?>

    <?php echo CHtml::checkBox('toggleAll', $allTasksCompleted, array(
        'id'=>'toggle-all',
        'title'=>'Mark all as complete',
    )); ?>

<?php $this->endWidget(); ?>
<!-- toggle-all form -->