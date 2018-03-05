<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "book_fields_user".
 *
 * @property int $id
 * @property int $book_fields_id
 * @property string $value
 * @property string $viewed
 *
 * @property BookFields $bookFields
 */
class BookFieldsUser extends \yii\db\ActiveRecord
{
    public $book;
    public $email;
    public $name;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'book_fields_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['book_fields_id', 'value'], 'required'],
            [['book_fields_id'], 'integer'],
            [['viewed'], 'string'],
            [['value'], 'string', 'max' => 255],
            [['book_fields_id'], 'exist', 'skipOnError' => true, 'targetClass' => BookFields::className(), 'targetAttribute' => ['book_fields_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'book_fields_id' => 'Book Fields ID',
            'value' => 'Value',
            'viewed' => 'Viewed',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookFields()
    {
        return $this->hasOne(BookFields::className(), ['id' => 'book_fields_id']);
    }
    
    public static function getFieldsUser($id) {
        $query = "
            SELECT b.title, u.`book_fields_id`, bf.label, u.`value`, u.viewed
            FROM `book_fields_user` u 
            LEFT JOIN `book_fields` bf ON bf.id = u.`book_fields_id`
            LEFT JOIN `book` b ON b.id = bf.book_id
            WHERE u.id_field = :id
            ORDER BY bf.order ASC
        ";

        return \Yii::$app->db->createCommand($query, [
            ':id' => $id,
        ])->queryAll();
    }
    
    
    public static function setStatus($id, $status) {
        $query = "
            UPDATE book_fields_user 
            SET viewed = :status
            WHERE id_field = :id
        ";

        return \Yii::$app->db->createCommand($query, [
            ':id' => $id,
            ':status' => $status,
        ])->execute();
    }
    
    public static function DeleteFieldsUser($pks) {
        $query = "
            DELETE FROM book_fields_user
            WHERE id_field = :pks;
        ";

        return \Yii::$app->db->createCommand($query, [
            ':pks' => $pks,
        ])->execute();
    }
    
    public static function getEmailFromID($listID){
        $listID = implode(',', $listID);
        
        $query = "
            SELECT bfu.id, bfu.`value` AS 'email',
            (
                SELECT nbfu.`value`
                FROM book_fields_user nbfu
                LEFT JOIN book_fields bf ON bf.id = nbfu.book_fields_id
                WHERE bf.label = 'Name' AND nbfu.id_field = bfu.id_field
                LIMIT 1
            ) AS 'name'
            FROM book_fields_user bfu
            WHERE bfu.id IN ({$listID});
            GROUP BY bfu.`value`
        ";
            
        $list = Yii::$app->db->createCommand($query)->queryAll();
        
        $result = [];
        foreach ($list as $value) {
            $result[$value['id']] = [
                        'name' => $value['name'],
                        'email' => $value['email']
                    ];
        }
        
        return $result;
    }
}
