<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Category;

/**
 * CategorySearch represents the model behind the search form about `backend\models\Category`.
 */
class _CategorySearch extends Category
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'published', 'order', 'language_id'], 'integer'],
            [['name', 'url'], 'safe'],
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
        $query = Category::find();
        $query->from('categories c');
        $query->leftJoin('language l', 'l.id = c.language_id');


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $get = Yii::$app->request->get('sort');
        !$get ? $query->orderBy('c.update_date DESC') : null;

        $this->load($params);
        $this->language_id ?: $query->where(['l.short_name'=>Yii::$app->language]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'c.id' => $this->id,
            'c.published' => $this->published,
            'c.language_id' => $this->language_id,
            'c.order' => $this->order,
        ]);

        $query->andFilterWhere(['like', 'c.name', $this->name])
            ->andFilterWhere(['like', 'c.url', $this->url]);

        return $dataProvider;
    }
}
