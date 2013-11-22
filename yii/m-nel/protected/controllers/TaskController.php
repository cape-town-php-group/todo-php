<?php

class TaskController extends Controller
{
	public function actionIndex()
	{
        $tasks = Task::model()->findAll();
        $model = new Task;
        $todoCount = Task::getActiveTasksCount();
        $completedCount = Task::getCompletedTasksCount();
        $allTasksCompleted = Task::areAllTasksCompleted();
        
		$this->render('index', array(
            'tasks'=>$tasks,
            'model'=>$model,
            'todoCount'=>$todoCount,
            'completedCount'=>$completedCount,
            'allTasksCompleted'=>$allTasksCompleted,
        ));
	}
    
    /**
     * Creates a new model.
     */
    public function actionCreate()
    {
        $model=new Task;

        if(isset($_POST['Task']))
        {
            $model->attributes=$_POST['Task'];
            if($model->save())
            {
                $this->redirect(array('index'));
            }
            else
            {
                Yii::app()->user->setFlash('error', $model->getError('name'));
                $this->redirect(array('index'));
            }
        }
    }
    
    /**
     * Toggle all the tasks to either active or completed.
     */
    public function actionToggleAll()
    {
        if(isset($_POST['toggleAll']))
        {
            $state = (bool)$_POST['toggleAll'];
            Task::toggleAll($state);
            
            $this->redirect(array('task/index'));
        }
    }
    
    /**
     * Clear all completed tasks.
     */
    public function actionClearCompleted()
    {
        Task::clearCompleted();
        
        $this->redirect(array('task/index'));
    }
    
    /**
     * Toggle a task's status.
     */
    public function actionToggle($id)
    {
        $task = $this->loadTask($id);
        $task->toggleStatus();
        
        $this->redirect(array('task/index'));
    }
    
    /**
     * Delate a task.
     */
    public function actionDelete($id)
    {
        $task = $this->loadTask($id);
        $task->delete();
        
        $this->redirect(array('task/index'));
    }
    
    /**
     * Update a task.
     */
    public function actionUpdate($id)
    {
        if(isset($_POST['Task']))
        {
            $task = $this->loadTask($id);
            $task->scenario = 'update';
            $task->attributes = $_POST['Task'];
            $task->update();
        }
        
        $this->redirect(array('task/index'));
    }
    
    /**
     * Fetches the specific task.
     * 
     * @param integer $id The ID of the task to fetch
     * @return Task The specified task.
     */
    private function loadTask($id)
    {
        $task = Task::model()->findByPk($id);
        if($task === null)
        {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        
        return $task;
    }


    // Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}