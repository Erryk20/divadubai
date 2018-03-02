<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * UserSearch represents the model behind the search form about `app\common\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['role', 'type', 'category_id'], 'string'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email'], 'safe'],
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
        $query = User::find();
        $query->select('u.*, ui.gender, c.name AS category_id');
        $query->from('user u');
        $query->leftJoin('user_info ui', 'u.id = ui.user_id');
        $query->leftJoin('categories c', 'c.id = ui.category_id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'updated_at' => 'DESC',
                    'id' => 'DESC', 
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
            'u.id' => $this->id,
            'u.status' => $this->status,
            'u.role' => $this->role,
            'u.type' => $this->type,
            'u.created_at' => $this->created_at,
            'u.updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'u.username', $this->username])
            ->andFilterWhere(['like', 'u.auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'u.email', $this->email])
            ->andFilterWhere(['like', 'c.name', $this->category_id]);

        return $dataProvider;
    }
}
