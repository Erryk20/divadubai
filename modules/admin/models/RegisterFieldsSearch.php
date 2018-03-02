<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RegisterFields;

/**
 * RegisterFieldsSearch represents the model behind the search form about `app\models\RegisterFields`.
 */
class RegisterFieldsSearch extends RegisterFields
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['fields', 'category_id'], 'safe'],
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
        $query = RegisterFields::find();
        $query->select(['rf.*', "mc.`name` AS 'categoryName'"]);
        $query->from('register_fields rf');
        $query->leftJoin('model_category mc', ' mc.id = rf.category_id');
                
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        if(\Yii::$app->request->get('sort', true) == true){
            $query->orderBy('mc.name ASC');
        };
        
        

        $this->load($params);
        

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'rf.fields', $this->fields]);
        $query->andFilterWhere(['like', 'mc.name', $this->category_id]);
        $query->andFilterWhere(['rf.id' => $this->id]);

        return $dataProvider;
    }
}
