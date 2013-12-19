<?php

/**
 * This is the model class for table "codes".
 *
 * The followings are the available columns in table 'codes':
 * @property integer $id
 * @property string $uniquecode
 * @property integer $status
 * @property string $date_claimed
 * @property integer $claimed_by
 */
class Codes extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Codes the static model class
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
		return 'codes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('uniquecode, status, date_claimed, claimed_by', 'required'),
				array('status, claimed_by', 'numerical', 'integerOnly'=>true),
				array('uniquecode', 'length', 'max'=>30),
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array('id, uniquecode, status, date_claimed, claimed_by', 'safe', 'on'=>'search'),
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
				'uniquecode' => 'Uniquecode',
				'status' => 'Status',
				'date_claimed' => 'Date Claimed',
				'claimed_by' => 'Claimed By',
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
		$criteria->compare('uniquecode',$this->uniquecode,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('date_claimed',$this->date_claimed,true);
		$criteria->compare('claimed_by',$this->claimed_by);

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
}