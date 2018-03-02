<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Faqs;

/**
 * FaqsSearch represents the model behind the search form about `app\models\Faqs`.
 */
class _FaqsSearch extends Faqs
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'language_id', 'category_faqs_id'], 'integer'],
            [['questions', 'answer'], 'safe'],
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
        $query = Faqs::find()
            ->from('faqs f')
            ->leftJoin('language l', 'l.id = f.language_id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $this->language_id ?: $query->where(['l.short_name'=>Yii::$app->language]);
        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'language_id' => $this->language_id,
            'category_faqs_id' => $this->category_faqs_id,
        ]);

        $query->andFilterWhere(['like', 'questions', $this->questions])
            ->andFilterWhere(['like', 'answer', $this->answer]);

        return $dataProvider;
    }
}
