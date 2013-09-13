<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $address1
 * @property string $suburb
 * @property string $country
 * @property string $region
 * @property string $postcode
 * @property string $date_created
 * @property string $date_modified
 */
class Users extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Users the static model class
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
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('first_name, last_name, email, address1, suburb, country, region, postcode, date_created, date_modified,unique_code,status', 'required'),
				array('first_name, last_name', 'length', 'max'=>20),
				array('address1', 'length', 'max'=>40),
				array('suburb, region, email', 'length', 'max'=>30),
				array('postcode', 'length', 'max'=>4),
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array('id, first_name, last_name, email, address1, suburb, country, region, postcode, date_created, date_modified, unique_code', 'safe', 'on'=>'search'),
				array('email', 'email','message'=>"The email isn't correct"),
				array('email', 'unique','message'=>'Email already exists!'),
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
		  'states' => array(self::BELONGS_TO, 'States', 'states'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
				'id' => 'ID',
				'first_name' => 'First Name',
				'last_name' => 'Last Name',
				'email' => 'Email',
				'address1' => 'Address1',
				'suburb' => 'Suburb',
				'country' => 'Country',
				'region' => 'Region',
				'postcode' => 'Postcode',
				'date_created' => 'Date Created',
				'date_modified' => 'Date Modified',
				'unique_code' => 'Unique Code',
				'status'=>'Status',
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
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('address1',$this->address1,true);
		$criteria->compare('suburb',$this->suburb,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('region',$this->region,true);
		$criteria->compare('postcode',$this->postcode,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_modified',$this->date_modified,true);

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}

}
