<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MenuCategory;

/**
 * MenuCategorySearch represents the model behind the search form about `app\models\MenuCategory`.
 */
class MenuCategorySearch extends MenuCategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'categories'], 'integer'],
            [['menu'], 'safe'],
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
//        SELECT mc.menu, CONCAT('{', GROUP_CONCAT(CONCAT('"', md.id, '":"', md.`name`, '"') SEPARATOR ','), '}')
//        FROM menu_category mc
//        LEFT JOIN model_category md ON md.id = mc.category_id
//        GROUP BY menu
        
        
        $query = MenuCategory::find();
        $query->from('menu_category mc');
        $query->select([
            "mc.menu",
            "CONCAT('{', GROUP_CONCAT(CONCAT('\"', md.id, '\":\"', md.`name`, '\"') SEPARATOR ','), '}') AS categories",
        ]);
        $query->leftJoin('model_category md', 'md.id = mc.category_id');
        $query->groupBy('mc.menu');
        
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
            'mc.id' => $this->id,
            'mc.category_id' => $this->category_id,
            'mc.category_id' => $this->categories,
        ]);

        $query->andFilterWhere(['like', 'mc.menu', $this->menu]);

        return $dataProvider;
    }
}
