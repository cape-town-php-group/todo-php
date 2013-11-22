<?php

/**
 * This is the model class for table "task".
 *
 * The followings are the available columns in table 'task':
 * @property integer $id
 * @property string $name
 * @property integer $status
 */
class Task extends CActiveRecord
{
    const STATUS_ACTIVE = 0;
    const STATUS_COMPLETED = 1;
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'task';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>45),
            array('name', 'filter', 'filter'=>'trim'),
            
			array('id, name, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'status' => 'Status',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Task the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    /**
     * Check if the task has been completed
     * 
     * @return boolean True if the task has been completed, false otherwise.
     */
    public function isCompleted()
    {
        return $this->status == self::STATUS_COMPLETED;
    }
    
    /**
     * Scope
     * Only tasks that have been completed
     * 
     * @return Task The task instance
     */
    public function completed()
    {
        $criteria=new CDbCriteria();
        $criteria->compare('status', self::STATUS_COMPLETED);
        
        $this->getDbCriteria()->mergeWith($criteria);
        return $this;
    }
    
    /**
     * Scope
     * Only tasks that are active
     * 
     * @return Task The task instance
     */
    public function active()
    {
        $criteria=new CDbCriteria();
        $criteria->compare('status', self::STATUS_ACTIVE);
        
        $this->getDbCriteria()->mergeWith($criteria);
        return $this;
    }
    
    /**
     * Mark all tasks as either active or complete.
     * 
     * @param boolean $state If true mark all as completed, otherwise active.
     */
    public static function toggleAll($state)
    {
        Task::model()->updateAll(array(
            'status'=> $state? Task::STATUS_COMPLETED : Task::STATUS_ACTIVE,
        ));
    }
    
    /**
     * Deletes all completed tasks
     */
    public static function clearCompleted()
    {
        Task::model()->deleteAll(
            Task::model()->completed()->getDbCriteria()
        );
    }
    
    /**
     * Returns the number of completed tasks
     * 
     * @return integer The number of completed tasks
     */
    public static function getCompletedTasksCount()
    {
        return (int)Task::model()->completed()->count();
    }
    
    /**
     * Returns the number of active tasks
     * 
     * @return integer The number of active tasks
     */
    public static function getActiveTasksCount()
    {
        return (int)Task::model()->active()->count();
    }
    
    /**
     * Returns whether all tasks have been completed or not
     * 
     * @return boolean True if all tasks have been completed, false otherwise.
     */
    public static function areAllTasksCompleted()
    {
        $completedTasks = self::getCompletedTasksCount();
        $totalTasks = $completedTasks + self::getActiveTasksCount();
        return $totalTasks === $completedTasks;
    }
}
