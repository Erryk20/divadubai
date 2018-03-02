<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ServiceCategories;

/**
 * ServiceCategoriesSearch represents the model behind the search form about `app\models\ServiceCategories`.
 */
class ServiceCategoriesSearch extends ServiceCategories
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'service_id', 'service_name'], 'integer'],
            [['name', 'slug', 'short'], 'safe'],
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
        $query = ServiceCategories::find();
        $query->select(["sc.*", "s.`name` AS 'service_name'"]);
        $query->from('service_categories sc');
        $query->leftJoin('services s', 's.id = sc.service_id');

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
            'sc.id' => $this->id,
            'sc.service_id' => $this->service_id,
        ]);

        $query->andFilterWhere(['like', 'sc.name', $this->name])
            ->andFilterWhere(['like', 'sc.slug', $this->slug])
            ->andFilterWhere(['like', 'sc.short', $this->short]);

        return $dataProvider;
    }
}
