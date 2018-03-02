<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Casting;

/**
 * CastingSearch represents the model behind the search form about `app\models\Casting`.
 */
class CastingSearch extends Casting
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'casting_date', 'time_from', 'time_to', 'job_date', 'order', 'category_id'], 'integer'],
            [['title', 'src', 'gender', 'fee', 'location', 'booker_name', 'bookers_number', 'details'], 'safe'],
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
        $query = Casting::find();
        
//        LEFT JOIN model_category mc ON mc.id = c.category_id
        $query->from('casting c');
        $query->select(["c.*", "mc.name AS category"]);
        $query->leftJoin('model_category mc', 'mc.id = c.category_id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'casting_date' => SORT_DESC,
                ]
            ],
        ]);
        
        
        $role = Yii::$app->user->identity->role;
        if($role == 'user'){
            $user_id = Yii::$app->user->id;
            $query->andWhere(['user_id'=>$user_id]);
        }

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'casting_date' => $this->casting_date,
            'time_from' => $this->time_from,
            'time_to' => $this->time_to,
            'job_date' => $this->job_date,
            'order' => $this->order,
            'category_id' => $this->category_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'src', $this->src])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'fee', $this->fee])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'booker_name', $this->booker_name])
            ->andFilterWhere(['like', 'bookers_number', $this->bookers_number])
            ->andFilterWhere(['like', 'details', $this->details]);

        return $dataProvider;
    }
}
