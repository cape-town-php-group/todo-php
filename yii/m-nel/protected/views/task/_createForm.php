<?php
/* @var $this TaskController */
/* @var $model Task */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'task-form',
    'action'=>Yii::app()->createAbsoluteUrl('task/create'),
)); ?>

    <?php echo $form->textField($model,'name',array(
        'size'=>45,
        'maxlength'=>45,
        'id'=>'new-todo',
        'placeholder'=>'What needs to be done?',
        'autofocus'=>'',
        'autocomplete'=>'off'
    )); ?>

<?php $this->endWidget(); ?>
<!-- form -->
