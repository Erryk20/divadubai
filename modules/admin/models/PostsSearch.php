<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Posts;

/**
 * PostsSearch represents the model behind the search form about `app\models\Posts`.
 */
class PostsSearch extends Posts
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'created_at', 'updated_at', 'published', 'introduction'], 'integer'],
            [['name', 'language', 'short_description', 'description', 'img', 'username'], 'safe'],
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
        $query = Posts::find()
                ->select([
                    'p.id', 
                    'p.type_file', 
                    'p.published', 
                    'p.language', 
                    'p.name', 
                    'p.short_description', 
                    'p.user_id', 
                    'p.img' , 
                    'u.username', 
                    'p.url' , 
                    "IF(IFNULL(i.id, 0) = 0, 0, 1) AS 'introduction'"
                ])
                ->from('posts p')
                ->leftJoin('user u', 'p.user_id = u.id')
                ->leftJoin('introduction i', "i.target_id = p.id AND i.type = 'post'");

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
//            'sort' => [
//                'defaultOrder' => [
//                    'updated_at' => SORT_DESC,
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
            'p.id' => $this->id,
            'p.user_id' => $this->user_id,
            'p.created_at' => $this->created_at,
            'p.updated_at' => $this->updated_at,
            'p.published' => $this->published,
        ]);
        
        if($this->introduction == '1'){
            $query->andWhere(['not', ['i.id' => null]]);
        }elseif($this->introduction == '0'){
            $query->andWhere(['i.id' => null]);
        }

        $query->andFilterWhere(['like', 'p.name', $this->name])
            ->andFilterWhere(['like', 'p.description', $this->description])
            ->andFilterWhere(['like', 'p.short_description', $this->short_description])
            ->andFilterWhere(['like', 'p.language', $this->language])
            ->andFilterWhere(['like', 'p.img', $this->img])
            ->andFilterWhere(['like', 'u.username', $this->username]);

        return $dataProvider;
    }
}
