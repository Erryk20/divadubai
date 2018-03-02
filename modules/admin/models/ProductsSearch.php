<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Products;

/**
 * ProductsSearch represents the model behind the search form about `app\models\Products`.
 */
class ProductsSearch extends Products
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at', 'published', 'category_id'], 'integer'],
            [['img', 'language', 'name', 'description'], 'safe'],
//            [['price'], 'number'],
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
            'sql' =>"SELECT p.id, p.category_id, CONCAT('images/products/', p.img) AS src, p.price, p.published, p.created_at, p.updated_at, cl.name AS category_name, pl.language, pl.name, pl.description ". 
                    "FROM products p ".
                    "LEFT JOIN products_lan pl ON pl.product_id = p.id ".
                    "LEFT JOIN categories_lan cl ON cl.category_id = p.category_id AND cl.language = pl.language ".
                    "WHERE IF(:language = '', 1, pl.language = :language) ".
                    "AND IF(:published = '', 1, published = :published) ".
                    "AND IF(:category = '', 1, p.category_id = :category) ".
                    "AND IF(:name = '', 1, pl.name LIKE :name) ".
                    "AND IF(:description = '', 1, pl.name LIKE :description) ".
                    "GROUP BY pl.id",
//                    "AND IF(:price = '', 1, pl.name LIKE :price)",
           'params' => [
               ':language'    => $this->language ? $this->language : '' ,
               ':published'   => ($this->published === NULL)? '': $this->published,
               ':category'    => ($this->category_id === NULL)? '': $this->category_id,
               ':name'        => $this->name ? "%{$this->name}%" : '' ,
               ':description' => $this->description ? "%{$this->description}%" : '' ,
//               ':price' => $this->price ? "%{$this->price}%" : '' ,
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
