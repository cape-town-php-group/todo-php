<?php
/* @var $this TaskController */
/* @var $todoCount integer */
/* @var $completedCount integer */
?>

<footer id="footer">
    
    <span id="todo-count">
        <strong><?php echo $todoCount; ?></strong>
        item<?php echo ($todoCount==1)?'':'s'; ?> left
    </span>
    
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
    <?php if($completedCount > 0) {
        $this->renderPartial('_clearCompletedForm', array('completedCount'=>$completedCount));
    } ?>
</footer>