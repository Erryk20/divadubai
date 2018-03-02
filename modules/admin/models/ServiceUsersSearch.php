<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UserInfo;

/**
 * UserInfoSearch represents the model behind the search form about `app\models\UserInfo`.
 */
class ServiceUsersSearch extends UserInfo
{
   
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'category_id', 'birth', 'address', 'weight', 'collar', 'chest', 'waist', 'hips', 'shoe', 'servCatName'], 'integer'],
            [['gender', 'name', 'last_name', 'gender', 'phone', 'phone2', 'nationality', 'country', 'city', 'ethnicity', 'height', 'suit', 'pant', 'hair', 'hair_length', 'eye', 'language', 'visa_status', 'specialization'], 'safe'],
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
        $query = UserInfo::find();
        
        $query->select([
            "ui.id",
            "ui.user_id",
            "ui.name",
            "ui.last_name",
            "ui.last_name",
            "ui.gender",
            "ui.nationality",
            "ui.country",
            "ui.city",
            "ui.ethnicity",
            "ui.visa_status",
            "ui.specialization",
            "sc.name AS servCatName",
        ]);
        $query->from('user_info ui');
        $query->leftJoin('service_users su', 'su.info_user_id = ui.id');
        $query->leftJoin('service_categories sc', 'sc.id = su.service_cat_id');
        
        
        $this->load($params);
        if(!Yii::$app->request->get('sort', false)){
            $query->orderBy('su.order ASC');
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        if($this['servCatName'] != NULL){
            $query->andWhere(['sc.id' => ($this['servCatName'] == '0') ? NULL : $this->servCatName]);
        }
        
        $query->andFilterWhere([
            'ui.user_id' => $this->user_id,
            'ui.category_id' => $this->category_id,
            'ui.birth' => $this->birth,
            'ui.address' => $this->address,
            'ui.weight' => $this->weight,
            'ui.collar' => $this->collar,
            'ui.chest' => $this->chest,
            'ui.waist' => $this->waist,
            'ui.hips' => $this->hips,
            'ui.shoe' => $this->shoe,
        ]);
        
        

        $query->andFilterWhere(['like', 'ui.gender', $this->gender, false])
            ->andFilterWhere(['like', 'ui.name', $this->name])
            ->andFilterWhere(['like', 'ui.last_name', $this->last_name])
            ->andFilterWhere(['like', 'ui.gender', $this->gender])
            ->andFilterWhere(['like', 'ui.phone', $this->phone])
            ->andFilterWhere(['like', 'ui.phone2', $this->phone2])
            ->andFilterWhere(['like', 'ui.nationality', $this->nationality])
            ->andFilterWhere(['like', 'ui.country', $this->country])
            ->andFilterWhere(['like', 'ui.city', $this->city])
            ->andFilterWhere(['like', 'ui.ethnicity', $this->ethnicity])
            ->andFilterWhere(['like', 'ui.height', $this->height])
            ->andFilterWhere(['like', 'ui.suit', $this->suit])
            ->andFilterWhere(['like', 'ui.pant', $this->pant])
            ->andFilterWhere(['like', 'ui.hair', $this->hair])
            ->andFilterWhere(['like', 'ui.hair_length', $this->hair_length])
            ->andFilterWhere(['like', 'ui.eye', $this->eye])
            ->andFilterWhere(['like', 'ui.language', $this->language])
            ->andFilterWhere(['like', 'ui.visa_status', $this->visa_status])
            ->andFilterWhere(['like', 'ui.specialization', $this->specialization]);

        return $dataProvider;
    }
}
