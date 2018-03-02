<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DivaMedia;

/**
 * DivaMediaSearch represents the model behind the search form about `app\models\DivaMedia`.
 */
class DivaMediaSearch extends DivaMedia
{
    public $type;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'diva_id', 'order'], 'integer'],
            [['title', 'slug', 'img'], 'safe'],
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
        $query = DivaMedia::find();
        $query->select('dm.*');
        $query->from('diva_media dm');
        $query->leftJoin('diva d', 'd.id = dm.diva_id');
        $query->where(['d.url'=> $this->type]);

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
            'diva_id' => $this->diva_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'img', $this->img]);

        return $dataProvider;
    }
}
