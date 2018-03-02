<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\NewsCategories;

/**
 * PageSearch represents the model behind the search form about `app\models\Page`.
 */
class NewsCategoriesSearch extends NewsCategories
{
    
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'updated_at', 'order', 'published'], 'integer'],
            [['url', 'name', 'language'], 'safe'],
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
            ->select(['nc.*', 'l.name As language'])
            ->from('news_categories nc')
            ->leftJoin('language l', 'l.short_name = nc.language');
        $query->orderBy('nc.order ASC');
        
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $this->language ?: $query->where(['l.short_name'=>Yii::$app->language]);
        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'nc.id' => $this->id,
            'nc.order' => $this->order,
            'nc.language' => $this->language,
        ]);

        $query->andFilterWhere(['like', 'nc.url', $this->url])
            ->andFilterWhere(['like', 'nc.name', $this->name]);

        return $dataProvider;
    }
}
