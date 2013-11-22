<?php
/* @var $this TaskController */
/* @var $tasks Task[] */
/* @var $model Task */
/* @var $todoCount integer */
/* @var $completedCount integer */
?>


<header id="header">
    <h1>todos</h1>
    
    <?php if(Yii::app()->user->hasFlash('error')):?>
        <div id="validation-error" class="flash error">
            <?php echo Yii::app()->user->getFlash('error'); ?>
        </div>
    <?php endif; ?>
    
    <?php $this->renderPartial('_form', array(
        'model'=>$model,
        'action'=>Yii::app()->createAbsoluteUrl('task/create'),
    )); ?>
</header>

<?php if(count($tasks) > 0): ?>

    <!-- Todo list -->
    <section id="main">
        <?php $this->renderPartial('_toggleAllForm'); ?>
        
        <ul id="todo-list">
           <?php foreach ($tasks as $task) {
               $this->renderPartial('_view', array('task'=>$task));
           } ?>
        </ul>
    </section>
    
    <!-- Footer -->
    <?php $this->renderPartial('_footer', array(
        'completedCount'=>$completedCount,
        'todoCount'=>$todoCount,
    )); ?>

<?php endif; ?>