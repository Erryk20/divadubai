<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pages;

/**
 * PageSearch represents the model behind the search form about `app\models\Page`.
 */
class _PageSearch extends Pages
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'published', 'main', 'order'], 'integer'],
            [['url', 'name', 'content', 'language'], 'safe'],
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
        $query = self::find()
            ->select(['p.*', 'l.name As language'])
            ->from('pages p')
            ->leftJoin('language l', 'l.short_name = p.language');
        $query->orderBy('p.order ASC');
        
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'updated_at' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params);

        $this->language ?: $query->where(['l.short_name'=>Yii::$app->language]);
        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'p.id' => $this->id,
            'p.parent_id' => $this->parent_id,
            'p.published' => $this->published,
            'p.main' => $this->main,
            'p.order' => $this->order,
            'language' => $this->language,
        ]);

        $query->andFilterWhere(['like', 'p.url', $this->url])
            ->andFilterWhere(['like', 'p.name', $this->name])
            ->andFilterWhere(['like', 'p.content', $this->content]);

        return $dataProvider;
    }
}
