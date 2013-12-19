<?php

/**
 * This is the model class for table "gift".
 *
 * The followings are the available columns in table 'gift':
 * @property integer $id
 * @property integer $user_id
 * @property string $size
 * @property string $custom_msg
 * @property string $jersey_mockup
 * @property string $status
 * @property string $created
 * @property string $modified
 */
class Gift extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Gift the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'gift';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('size, custom_msg,', 'required'),
				//array('user_id, size, custom_msg, jersey_mockup, status, created, modified,shared', 'required'),
				array('user_id', 'numerical', 'integerOnly'=>true),
				array('jersey_mockup', 'length', 'max'=>100),
				array('custom_msg', 'length', 'max'=>9),
				array('shared', 'length', 'max'=>20),
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array('id, user_id, size, custom_msg, jersey_mockup,shared, status, created, modified', 'safe', 'on'=>'search'),
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
				'user_id' => 'User',
				'size' => 'Size',
				'custom_msg' => 'Custom Msg',
				'jersey_mockup' => 'Jersey Mockup',
				'status' => 'Status',
				'created' => 'Created',
				'modified' => 'Modified',
				'shared'=>'Shared',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('size',$this->size,true);
		$criteria->compare('custom_msg',$this->custom_msg,true);
		$criteria->compare('jersey_mockup',$this->jersey_mockup,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
}
