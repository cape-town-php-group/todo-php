<?php
/* @var $this TaskController */
/* @var $tasks Task[] */
/* @var $model Task */
/* @var $todoCount integer */
/* @var $completedCount integer */
/* @var $allTasksCompleted boolean */

Yii::app()->clientScript->registerScript('toggle', "
    $('.toggle').bind('change', function() {
        var toggleURL = $(this).attr('data-target');
        window.location = toggleURL;
    });
");
Yii::app()->clientScript->registerScript('destroy', "
    $('.destroy').click(function() {
        var destroyURL = $(this).attr('data-target');
        window.location = destroyURL;
    });
");
Yii::app()->clientScript->registerScript('editing', "
    $('div.view>label').dblclick(function() {
        var view = $(this).parent();
        var task = view.parent();
        task.addClass('editing');
        
        var edit = view.siblings('form').children('input.edit');
        edit.focus();
    });
");
Yii::app()->clientScript->registerScript('update', "
    $('.edit').blur(function() {
        $(this).parent('form').submit();
    });
");
Yii::app()->clientScript->registerScript('escape-edit', "
    $('.edit').on('keydown', function(e) {
        if (e.keyCode == 27) {
            $(this).parents('li').removeClass('editing');
        }
    });
");
?>


<header id="header">
    <h1>todos</h1>
    
    <?php if(Yii::app()->user->hasFlash('error')):?>
        <div id="validation-error" class="flash error">
            <?php echo Yii::app()->user->getFlash('error'); ?>
        </div>
    <?php endif; ?>
    
    <?php $this->renderPartial('_createForm', array('model'=>$model)); ?>
</header>

<?php if(count($tasks) > 0): ?>

    <!-- Todo list -->
    <section id="main">
        <?php $this->renderPartial('_toggleAllForm', array(
            'allTasksCompleted'=>$allTasksCompleted
        )); ?>
        
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