<?php

class SiteController extends Controller
{
	/**
	 * This is the action to handle errors/exceptions.
	 */
	public function actionError()
	{
        $error = Yii::app()->errorHandler->error;
		if($error)
		{
			$this->render('error', $error);
		}
	}
}