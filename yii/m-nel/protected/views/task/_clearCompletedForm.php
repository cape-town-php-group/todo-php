<?php
/* @var $this TaskController */
/* @var $completedCount integer */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'clear-completed-form',
    'action'=>Yii::app()->createAbsoluteUrl('task/clearCompleted'),
)); ?>

    <button id="clear-completed">
        Clear completed (<?php echo $completedCount; ?>)
    </button>

<?php $this->endWidget(); ?>
<!-- toggle-all form -->
