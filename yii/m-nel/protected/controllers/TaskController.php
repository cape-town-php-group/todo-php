<?php

class TaskController extends Controller
{
	public function actionIndex()
	{
        $tasks = Task::model()->findAll();
        $model = new Task;
        
		$this->render('index', array(
            'tasks'=>$tasks,
            'model'=>$model,
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
                $this->redirect(array('index'));
            }
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