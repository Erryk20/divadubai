<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BookFields;

/**
 * BookFieldsSearch represents the model behind the search form about `app\models\BookFields`.
 */
class BookFieldsSearch extends BookFields
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'book_id'], 'integer'],
            [['label'], 'safe'],
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
        $query = BookFields::find();
        $query->select(['bf.*', 'b.title', 'b.url']);
        $query->from('book_fields bf');
        $query->leftJoin('book b', 'b.id = bf.book_id');
        
               

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'order' => SORT_ASC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'book_id' => $this->book_id,
        ]);

        $query->andFilterWhere(['like', 'label', $this->label]);

        return $dataProvider;
    }
}
