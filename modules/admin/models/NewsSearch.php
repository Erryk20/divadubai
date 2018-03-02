<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\News;

/**
 * PostsSearch represents the model behind the search form about `app\models\Posts`.
 */
class NewsSearch extends News
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'url', 'category_id', 'user_id', 'created_at', 'updated_at', 'published'], 'integer'],
            [['name', 'language', 'category', 'description', 'img', 'username'], 'safe'],
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
        $query = News::find()
                ->select(['n.id', 'n.url', 'nc.name AS category', 'n.updated_at', 'n.published', 'n.language', 'n.name', 'n.user_id', 'n.img' , 'u.username'])
                ->from('news n')
                ->leftJoin('user u', 'n.user_id = u.id')
                ->leftJoin('news_categories nc', 'n.category_id = nc.id');

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
            'n.id' => $this->id,
            'n.user_id' => $this->user_id,
            'n.created_at' => $this->created_at,
            'n.updated_at' => $this->updated_at,
            'n.published' => $this->published,
            'n.category_id' => $this->category_id,
        ]);

        $query->andFilterWhere(['like', 'n.name', $this->name])
            ->andFilterWhere(['like', 'n.description', $this->description])
            ->andFilterWhere(['like', 'n.language', $this->language])
            ->andFilterWhere(['like', 'n.img', $this->img])
            ->andFilterWhere(['like', 'u.username', $this->username])
            ->andFilterWhere(['like', 'nc.name', $this->category]);

        return $dataProvider;
    }
}
