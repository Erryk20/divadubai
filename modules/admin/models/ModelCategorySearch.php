<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ModelCategory;

/**
 * ModelCategorySearch represents the model behind the search form about `app\models\ModelCategory`.
 */
class ModelCategorySearch extends ModelCategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent_id'], 'integer'],
            [['name', 'slug', 'type'], 'safe'],
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
        $query = ModelCategory::find();
        $query->select('mc.*, pmc.name AS parent');
        $query->from('model_category mc');
        $query->leftJoin('model_category pmc', 'mc.parent_id = pmc.id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'order' => SORT_ASC,
                ]
            ],
//            'sort' => [
//                'defaultOrder' => [
//                    'id' => SORT_DESC,
//                ]
//            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'mc.id' => $this->id,
            'mc.parent_id' => $this->parent_id,
        ]);

        $query->andFilterWhere(['like', 'mc.name', $this->name])
                ->andFilterWhere(['like', 'mc.slug', $this->slug])
                ->andFilterWhere(['like', 'mc.type', $this->type]);

        return $dataProvider;
    }
}
