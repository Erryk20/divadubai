<?php

namespace app\models;

use Yii;


/**
 * This is the model class for table "user_subcategory".
 *
 * @property int $id
 * @property int $info_user_id
 * @property int $subcategory_id
 *
 * @property ModelSubcategry $subcategory
 * @property UserInfo $infoUser
 */
class UserSubcategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_subcategory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['info_user_id', 'subcategory_id'], 'required'],
            [['info_user_id', 'subcategory_id'], 'integer'],
            [['info_user_id', 'subcategory_id'], 'unique', 'targetAttribute' => ['info_user_id', 'subcategory_id']],
            [['subcategory_id'], 'exist', 'skipOnError' => true, 'targetClass' => ModelSubcategory::className(), 'targetAttribute' => ['subcategory_id' => 'id']],
            [['info_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserInfo::className(), 'targetAttribute' => ['info_user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'info_user_id' => 'Info User ID',
            'subcategory_id' => 'Subcategory ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubcategory()
    {
        return $this->hasOne(ModelSubcategry::className(), ['id' => 'subcategory_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInfoUser()
    {
        return $this->hasOne(UserInfo::className(), ['id' => 'info_user_id']);
    }
    
    public static function getLIstSubcategoyForUser($id){
        $query = "
            SELECT CONCAT('{',GROUP_CONCAT(CONCAT('\"',ms.id, '\":', '\"', ms.`name`, '\"') SEPARATOR ','), '}') AS subcategory
            FROM user_subcategory us
            LEFT JOIN model_subcategry ms ON ms.id = us.subcategory_id
            WHERE us.info_user_id = :id
        ";
        
        $result = \Yii::$app->db->createCommand($query, [':id'=>$id])->queryScalar();
        return $result ? json_decode($result, true) : [];
    }
    
    public static function setSubcategory($userSubcategory, $id){
        $userSubcat = self::getLIstSubcategoyForUser($id);
        
        $userSubcategory = $userSubcategory['subcategory_id'];
        
        
        // Add user subcategory
        foreach (array_diff_key($userSubcategory, $userSubcat) as $key => $value) {
            $model = new \app\models\UserSubcategory();
            $model->info_user_id = $id;
            $model->subcategory_id = $key;
            $model->save();
        }
        
        // Delete user subcategory
        foreach (array_diff_key($userSubcat, $userSubcategory) as $key => $value) {
            $model = \app\models\UserSubcategory::findOne([
                 'info_user_id' => $id,
                 'subcategory_id' => $key
            ]);
            $model->delete();
        }
        
        return self::getLIstSubcategoyForUser($id);
    }
 }
