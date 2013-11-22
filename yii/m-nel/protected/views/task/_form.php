<?php
/* @var $this TaskController */
/* @var $model Task */
/* @var $form CActiveForm */
/* @var $action string The action (string cannonical url) */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'task-form',
    'action'=>$action,
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
