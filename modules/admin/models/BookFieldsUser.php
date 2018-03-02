<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BookFieldsUser as BookFieldsUserModel;

/**
 * BookFieldsUser represents the model behind the search form about `app\models\BookFieldsUser`.
 */
class BookFieldsUser extends BookFieldsUserModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'book_fields_id', 'book'], 'integer'],
            [['value', 'viewed', 'email', 'name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $this->load($params);

        $viewed = '';
        switch ($this->viewed){
            case '0': $viewed = '0'; break;
            case '1': $viewed = '1'; break;
        }
        $dataProvider = new \yii\data\SqlDataProvider([
            'sql' =>"
                SELECT bfu.id AS id, bfu.id_field, b.title AS 'book', bf.label, bfu.`value` AS 'email',
                (
                    SELECT nbfu.`value`
                    FROM book_fields_user nbfu
                    LEFT JOIN book_fields bf ON bf.id = nbfu.book_fields_id
                    WHERE bf.label = 'Name' AND nbfu.id_field = bfu.id_field
                    LIMIT 1
                ) AS 'name',
                bfu.viewed
                FROM book_fields_user bfu
                LEFT JOIN book_fields bf ON bf.id = bfu.book_fields_id
                LEFT JOIN book b ON bf.book_id = b.id
                WHERE bf.label LIKE '%email%'
                AND IF(:book = '', 1, b.id = :book) 
                AND IF(:viewed = '', 1, bfu.viewed = :viewed) 
                AND IF(:email = '', 1,  bfu.`value` LIKE :email) 
                GROUP BY bfu.id_field
                HAVING IF(:name = '', 1,  name LIKE :name)
            ",
            'params' => [
               ':book'    => $this->book ? $this->book : '' ,
               ':email'   => $this->email ? "%{$this->email}%" : '' ,
               ':name'    => $this->name ? "%{$this->name}%" : '' ,
               ':viewed'  => $viewed
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        
        if (!$this->validate()) {
            // $query->where('0=1');
            return $dataProvider;
        }
        return $dataProvider;
    }
}
