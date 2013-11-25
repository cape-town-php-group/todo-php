<?php
/* @var $this TaskController */
/* @var $model Task */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createAbsoluteUrl('task/update', array('id'=>$model->id)),
)); ?>

    <?php echo $form->textField($model,'name',array(
        'size'=>45,
        'maxlength'=>45,
        'autocomplete'=>'off',
        'class'=>'edit',
    )); ?>

<?php $this->endWidget(); ?>
<!-- form -->
