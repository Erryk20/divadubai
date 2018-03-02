<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ServicePage;

/**
 * MainListSearch represents the model behind the search form about `app\models\MainList`.
 */
class ServicesSearch extends ServicePage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'link', 'order', 'parent_id'], 'integer'],
            [['name', 'src'], 'safe'],
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
        $query = ServicePage::find();
        $query->from('service_page sp');
        $query->select([
            "sp.*",
            "(SELECT `name` FROM service_page WHERE id = sp.parent_id) AS parentName",
        ]);
        

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
            'sp.id' => $this->id,
            'sp.llink' => $this->link,
            'sp.order' => $this->order,
            'sp.parent_id' => $this->parent_id,
        ]);

        $query->andFilterWhere(['like', 'sp.name', $this->name])
            ->andFilterWhere(['like', 'sp.src', $this->src]);

        return $dataProvider;
    }
}
