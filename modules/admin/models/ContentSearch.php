<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Content;

/**
 * ContentSearch represents the model behind the search form about `app\models\Content`.
 */
class ContentSearch extends Content
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['target_id'], 'integer'],
            [['type', 'top', 'blockquote', 'description'], 'safe'],
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
        $query = Content::find();

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
            'target_id' => $this->target_id,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'top', $this->top])
            ->andFilterWhere(['like', 'blockquote', $this->blockquote])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
