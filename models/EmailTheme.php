<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "email_theme".
 *
 * @property int $id
 * @property string $type
 * @property string $content
 * @property string $subject
 */
class EmailTheme extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'email_theme';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'content', 'subject'], 'required'],
            [['content'], 'string'],
            [['type'], 'string', 'max' => 20],
            [['type'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'content' => 'Content',
            'subject' => 'Letter Subject',
        ];
    }
    
    public static function getTheme($type, $id){
        $domen = Yii::$app->getRequest()->hostInfo;
        $hostName = Yii::$app->request->hostName;
        $link = \kartik\helpers\Html::a($hostName, $domen);
        
        $info = \app\models\PDF::getUserInfo($id);
        
        $query = "
            SELECT content, subject
            FROM email_theme
            WHERE `type` = :type
        ";
        
        $request = Yii::$app->db->createCommand($query, [':type'=>$type])->queryOne();
        
        $result = [
                'message' => '',
                'subject' => '',
                'email' => $info['email'],
        ];
        if($request){
            // {domen} {link} {fulllName}
            $request = preg_replace("/{domen}/", $hostName, $request);
            $request = preg_replace("/{link}/", $link, $request);
            $request = preg_replace("/{fulllName}/", $info['fulllName'], $request);
            $request = preg_replace("/{category}/", $info['category'], $request);


            return [
                'message' => $request['content'],
                'subject' => $request['subject'],
                'email' => $info['email'],
            ];
        }
    }
}
