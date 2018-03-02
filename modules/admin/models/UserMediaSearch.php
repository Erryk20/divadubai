<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UserMedia;

/**
 * UserMediaSearch represents the model behind the search form about `app\models\UserMedia`.
 */
class UserMediaSearch extends UserMedia
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'info_user_id'], 'integer'],
            [['type', 'src'], 'safe'],
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
        $query = UserMedia::find();
        $query->from('user_media um');
        $query->select([
            'um.*',
            "CONCAT(
                '/images/user-media/', 
                IF(type IN ('catwalk', 'showreel'), 'movie-video.gif', src)
            ) AS src"
        ]);
        
//        "IF(type IN ('catwalk', 'showreel'), src, CONCAT('images/user-media/', src)) AS src"
//        movie-video

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'order' => SORT_ASC,
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
            'um.id' => $this->id,
            'um.info_user_id' => $this->info_user_id,
            'um.type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'um.src', $this->src]);

        return $dataProvider;
    }
}
