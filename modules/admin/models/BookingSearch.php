<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Booking;

/**
 * BookingSearch represents the model behind the search form about `app\models\Booking`.
 */
class BookingSearch extends Booking
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'client_id', 'model_id', 'status'], 'integer'],
            [['name', 'client_name', 'requirement', 'booked_as', 'usage_for', 'booker_name', 'period', 'contact_number', 'date_of_shoot', 'job_number', 'location', 'amount', 'user_name', 'ac_name', 'ac_number', 'bank_name', 'signature', 'last_date', 'act_total', 'cheque', 'type', 'from_date', 'to_date', 'email'], 'safe'],
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
    public function setDataForEmail($checked)
    {
        $query = Booking::find();
        $query->select(new \yii\db\Expression("
            null AS 'booked_as', null AS 'booker_name', 
            ui.name AS `name`, null AS 'amount',
            null AS 'act_total', null AS 'cheque',
            null AS 'bank_name', null AS 'last_date', 
            CONCAT('+', REPLACE(ui.phone, '/', '')) AS 'contact_number', 
            ui.id AS 'model_id', 
            null AS 'job_number', null AS 'usage_for',
            null AS 'period', null AS 'client_name',
            null AS 'from_date', null AS 'to_date',
            null AS 'date_of_shoot', null AS 'location', 
            ui.`email`, null AS 'requirement'
        "));
        $query->from('user_info ui');
        $query->where(['ui.id'=> explode(',', $checked)]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $dataProvider;

        
        

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        
        $dataProvider = new \yii\data\SqlDataProvider([
            'sql' => "
                SELECT null AS 'booked_as', null AS 'booker_name', 
                    ui.name AS `name`, null AS 'amount',
                    null AS 'act_total', null AS 'cheque',
                    null AS 'bank_name', null AS 'last_date', 
                    ui.phone AS 'contact_number', ui.id AS 'model_id', 
                    null AS 'job_number', null AS 'usage_for',
                    null AS 'period', null AS 'client_name',
                    null AS 'from_date', null AS 'to_date',
                    null AS 'date_of_shoot', null AS 'location', 
                    ui.`email`, null AS 'requirement'
                    FROM user_info ui
                WHERE " . (($checked != '') ? " ui.id IN ({$checked})" : 'false'),
            'totalCount' => substr_count($checked, ','),
            'sort' => [
                'attributes' => ['name'],
            ],
            'pagination' => [
                'pageSize' => false,
            ],
        ]);
        
        return $dataProvider;
    }
    
    
    public function search($params)
    {
        $query = Booking::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'client_id' => $this->client_id,
            'model_id' => $this->model_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'client_name', $this->client_name])
            ->andFilterWhere(['like', 'requirement', $this->requirement])
            ->andFilterWhere(['like', 'booked_as', $this->booked_as])
            ->andFilterWhere(['like', 'usage_for', $this->usage_for])
            ->andFilterWhere(['like', 'booker_name', $this->booker_name])
            ->andFilterWhere(['like', 'period', $this->period])
            ->andFilterWhere(['like', 'contact_number', $this->contact_number])
            ->andFilterWhere(['like', 'date_of_shoot', $this->date_of_shoot])
            ->andFilterWhere(['like', 'job_number', $this->job_number])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'amount', $this->amount])
            ->andFilterWhere(['like', 'user_name', $this->user_name])
            ->andFilterWhere(['like', 'ac_name', $this->ac_name])
            ->andFilterWhere(['like', 'ac_number', $this->ac_number])
            ->andFilterWhere(['like', 'bank_name', $this->bank_name])
            ->andFilterWhere(['like', 'signature', $this->signature])
            ->andFilterWhere(['like', 'last_date', $this->last_date])
            ->andFilterWhere(['like', 'act_total', $this->act_total])
            ->andFilterWhere(['like', 'cheque', $this->cheque])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'from_date', $this->from_date])
            ->andFilterWhere(['like', 'to_date', $this->to_date])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
