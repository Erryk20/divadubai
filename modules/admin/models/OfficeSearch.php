<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ContentImages;

/**
 * ContentImagesSearch represents the model behind the search form about `app\models\ContentImages`.
 */
class OfficeSearch extends ContentImages
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'content_id'], 'integer'],
            [['src', 'title'], 'safe'],
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
        $target_id = Yii::$app->request->get('target_id');
        $type = Yii::$app->request->get('type');
        
        $query = ContentImages::find();
        $query->where(['content_id' => $this->content_id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'content_id' => $this->content_id,
        ]);

        $query->andFilterWhere(['like', 'src', $this->src]);
        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
