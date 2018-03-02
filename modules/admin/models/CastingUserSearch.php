<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CastingUser;

/**
 * CastingUserSearch represents the model behind the search form about `app\models\CastingUser`.
 */
class CastingUserSearch extends CastingUser
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'casting_id', 'casting_name', 'category_id'], 'integer'],
            [['name', 'email', 'phone', 'message', 'viewed', 'created_at'], 'safe'],
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
        $query = CastingUser::find();
        $query->from('casting_user cs');
        $query->select(["cs.*", "`c`.`title` AS 'casting_name'", "mc.name AS category"]);
        $query->leftJoin('casting c', 'c.id=cs.casting_id');
        $query->leftJoin('model_category mc', 'mc.id = c.category_id');
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $role = Yii::$app->user->identity->role;
        if($role == 'user'){
            $user_id = Yii::$app->user->id;
            $query->andWhere(['c.user_id'=>$user_id]);
        }

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'cs.id' => $this->id,
            'cs.casting_id' => $this->casting_id,
            'c.category_id' => $this->category_id,
        ]);

        $query->andFilterWhere(['like', 'cs.name', $this->name])
            ->andFilterWhere(['like', 'cs.email', $this->email])
            ->andFilterWhere(['like', 'cs.phone', $this->phone])
            ->andFilterWhere(['like', 'cs.message', $this->message])
            ->andFilterWhere(['like', 'cs.viewed', $this->viewed]);

        return $dataProvider;
    }
}
