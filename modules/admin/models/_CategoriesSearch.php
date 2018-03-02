<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Categories;

/**
 * CategoriesSearch represents the model behind the search form about `app\models\Categories`.
 */
class _CategoriesSearch extends Categories
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at'], 'integer'],
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
        $this->load($params);

        $dataProvider = new \yii\data\SqlDataProvider([
            'sql' =>"SELECT c.id, c.url, cl.language, cl.name ". 
                    "FROM categories c ".
                    "LEFT JOIN categories_lan cl ON cl.category_id = c.id ".
            
                    "WHERE IF(:language = '', 1, cl.language = :language) ".
                    "AND IF(:name = '', 1, cl.name LIKE :name) ".
                    "AND IF(:url = '', 1, c.url LIKE :url) ",
           'params' => [
               ':language'  => $this->language ? $this->language : '' ,
               ':name'      => $this->name ? "%{$this->name}%" : '' ,
               ':url' => $this->url ? "%{$this->url}%" : '' ,
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
       
        return $dataProvider;
    }
}
