<?php

namespace app\models;

use Yii;
use app\models\User;
/**
 * This is the model class for table "diva_user".
 *
 * @property int $id
 * @property int $diva_media_id
 * @property string $type
 * @property int $info_user_id
 *
 * @property User $user
 * @property DivaMedia $divaMedia
 */
class DivaUser extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
            'sortable' => [
                'class' => \kotchuprik\sortable\behaviors\Sortable::className(),
                'query' => self::find(),
            ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'diva_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['diva_media_id', 'type', 'info_user_id'], 'required'],
            [['diva_media_id', 'info_user_id'], 'integer'],
            [['type'], 'string', 'max' => 20],
            [['info_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserInfo::className(), 'targetAttribute' => ['info_user_id' => 'id']],
            [['diva_media_id'], 'exist', 'skipOnError' => true, 'targetClass' => DivaMedia::className(), 'targetAttribute' => ['diva_media_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'diva_media_id' => 'Diva Media ID',
            'type' => 'Type',
            'info_user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(UserInfo::className(), ['id' => 'info_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDivaMedia()
    {
        return $this->hasOne(DivaMedia::className(), ['id' => 'diva_media_id']);
    }
    
            
    public static function getNextLast($order_id){
        $query = "
            SELECT dm.url, du.info_user_id,  '/site/diva' AS pre_url, du.info_user_id
            FROM diva d
            LEFT JOIN diva_media dm ON dm.diva_id = d.id
            LEFT JOIN diva_user du ON du.diva_media_id = dm.id

            WHERE d.url = 'productions'
            AND dm.url = 'post-production'
            AND (du.order IN(:order_id-1, :order_id+1))
            ORDER BY du.order ASC
        ";
        
        $request = Yii::$app->db->createCommand($query, [
            ':order_id' => $order_id,
        ]); 
        
//        vd($request);
                
        return ArrayHelper::map($request->queryAll(), 'id', 'src') ;
    }
    
}
