<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Countries;

/**
 * CountriesSearch represents the model behind the search form about `app\models\Countries`.
 */
class CountriesSearch extends Countries
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['language', 'name', 'url'], 'safe'],
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
        $query = Countries::find();
        $query->select(['c.*', 'ca.name', 'l.name AS language', "LCASE(ca.sortname) AS short_name"])
              ->from('countries c')
              ->leftJoin('language l', 'l.short_name = c.language')
              ->leftJoin('countries_all ca', 'LCASE(ca.sortname) = c.country');

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

        $query->andFilterWhere(['like', 'language', $this->language])
            ->andFilterWhere(['like', 'ca.name', $this->name])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}
