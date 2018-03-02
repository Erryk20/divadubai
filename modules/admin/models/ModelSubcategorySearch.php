<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ModelSubcategory;

/**
 * ModelSubcategrySearch represents the model behind the search form about `app\models\ModelSubcategry`.
 */
class ModelSubcategorySearch extends ModelSubcategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'parent_id'], 'integer'],
            [['name', 'slug'], 'safe'],
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
        $query = ModelSubcategory::find();
        $query->select('ms.*, mc.name AS category, pms.name AS parent');
        $query->from('model_subcategry ms');
        $query->leftJoin('model_category mc', 'mc.id = ms.category_id');
        $query->leftJoin('model_subcategry pms', 'pms.id = ms.parent_id');

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
            'ms.category_id' => $this->category_id,
            'ms.parent_id' => $this->parent_id,
        ]);

        $query->andFilterWhere(['like', 'ms.name', $this->name])
            ->andFilterWhere(['like', 'ms.slug', $this->slug]);

        return $dataProvider;
    }
}
