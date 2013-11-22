<?php

class TaskController extends Controller
{
	public function actionIndex()
	{
        $tasks = Task::model()->findAll();
        $model = new Task;
        $todoCount = Task::model()->active()->count();
        
		$this->render('index', array(
            'tasks'=>$tasks,
            'model'=>$model,
            'todoCount'=>$todoCount,
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
            
            Yii::app()->user->setState('toggleAll', $state);
            $this->redirect(array('task/index'));
        }
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