<?php
/* @var $this TaskController */
/* @var $tasks Task[] */
/* @var $model Task */
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

    <!-- This section should be hidden by default and shown when there are todos -->
    <section id="main">
        <input id="toggle-all" type="checkbox">
        <label for="toggle-all">Mark all as complete</label>
        <ul id="todo-list">
            <!-- These are here just to show the structure of the list items -->
            <!-- List items should get the class `editing` when editing and `completed` when marked as completed -->
            <li class="completed">
                <div class="view">
                    <input class="toggle" type="checkbox" checked>
                    <label>Create a TodoMVC template</label>
                    <button class="destroy"></button>
                </div>
                <input class="edit" value="Create a TodoMVC template">
            </li>
            <li>
                <div class="view">
                    <input class="toggle" type="checkbox">
                    <label>Rule the web</label>
                    <button class="destroy"></button>
                </div>
                <input class="edit" value="Rule the web">
            </li>
        </ul>
    </section>

    <!-- This footer should hidden by default and shown when there are todos -->
    <footer id="footer">
        <!-- This should be `0 items left` by default -->
        <span id="todo-count"><strong>1</strong> item left</span>
        <!-- Remove this if you don't implement routing -->
        <ul id="filters">
            <li>
                <a class="selected" href="#/">All</a>
            </li>
            <li>
                <a href="#/active">Active</a>
            </li>
            <li>
                <a href="#/completed">Completed</a>
            </li>
        </ul>
        <!-- Hidden if no completed items are left ↓ -->
        <button id="clear-completed">Clear completed (1)</button>
    </footer>

<?php endif; ?>