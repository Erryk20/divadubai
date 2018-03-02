<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Diva;

/**
 * DivaSearch represents the model behind the search form about `app\models\Diva`.
 */
class DivaSearch extends Diva
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['title', 'url', 'type', 'block_1', 'block_2', 'block_3', 'block_4', 'block_5', 'block_6'], 'safe'],
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
        $query = Diva::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'block_1', $this->block_1])
            ->andFilterWhere(['like', 'block_2', $this->block_2])
            ->andFilterWhere(['like', 'block_3', $this->block_3])
            ->andFilterWhere(['like', 'block_4', $this->block_4])
            ->andFilterWhere(['like', 'block_5', $this->block_5])
            ->andFilterWhere(['like', 'block_6', $this->block_6]);

        return $dataProvider;
    }
}
