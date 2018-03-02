<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Upload;

/**
 * UploadSearch represents the model behind the search form about `app\models\Upload`.
 */
class UploadSearch extends Upload
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_vimeo', 'status', 'duration', 'created_at', 'updated_at'], 'integer'],
            [['name', 'description', 'preview', 'stream', 'created_time', 'privacy', 'download'], 'safe'],
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
        $query = Upload::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'updated_at' => 'DESC',
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_vimeo' => $this->id_vimeo,
            'status' => $this->status,
            'duration' => $this->duration,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'preview', $this->preview])
            ->andFilterWhere(['like', 'stream', $this->stream])
            ->andFilterWhere(['like', 'created_time', $this->created_time])
            ->andFilterWhere(['like', 'privacy', $this->privacy])
            ->andFilterWhere(['like', 'download', $this->download]);

        return $dataProvider;
    }
}
