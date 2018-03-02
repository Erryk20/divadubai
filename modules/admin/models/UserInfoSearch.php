<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UserInfo;

/**
 * UserInfoSearch represents the model behind the search form about `app\models\UserInfo`.
 */
class UserInfoSearch extends UserInfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'user_id', 'category_id', 'address', 'weight', 'collar', 'chest', 'prepend_phone', 'categories_key',
                    'id', 'old_id', 'id2',  'phone', 'category2_id', 'subcategory_id', 'servCatName', 'add_management', 'subcategory_key'
                ], 
                'integer'
            ],
            [
                [
                    'gender', 'name', 'last_name', 'birth', 'nationality', 'country', 'waist', 'hips', 'shoe', 'email', 'city', 'ethnicity', 'height', 'suit', 'pant', 'hair', 'hair_length', 'eye', 'language', 'visa_status', 'specialization', 'type', 'categories',
                    'gender2',  'name2', 'active', 'subcategory', 'bio', 'facebook', 'twitter', 'instagram', 'youtube', 'snapchat'
                ], 
                'safe'
            ],
        ];
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
        $get = Yii::$app->request->get();
        
        if($get && isset($get['sort'])){
            $params['sort'] = $get['sort'];
        }
        
        if($get && isset($get['UserInfoSearch'])){ //&& isset($params['UserInfoSearch'])
            if(isset($params['UserInfoSearch'])){
                $UserInfoSearch = array_merge($params['UserInfoSearch'], array_diff($get['UserInfoSearch'], array('', NULL, false)));
            }else{
                $UserInfoSearch = array_diff($get['UserInfoSearch'], array('', NULL, false));
            }
            
            $params['UserInfoSearch'] = $UserInfoSearch;
        } 
        
        $this->load($params);
        
        $yearNow = (int)date('Y', time());
        
        $query = UserInfo::find();
        
        $query->select([
            "ui.id",
            "ui.old_id",
            "ui.type",
            "ui.height",
            "ui.waist",
            "ui.hips",
            "ui.shoe",
//            "uc.active",
            "ui.availability",
            "ui.status",
            "ui.active",
            "ui.birth",
            "ui.phone",
            "ui.email",
            "ui.user_id",
            "ui.name",
            "ui.last_name",
            "({$yearNow} - DATE_FORMAT(FROM_UNIXTIME(birth), '%Y')) AS ages",
            "c.name AS category",
            "ui.gender",
            "ui.nationality",
            "ui.country",
            "ui.city",
            "ui.ethnicity",
            "ui.visa_status",
            "ui.specialization",
            "
                (
                    SELECT CONCAT('{', GROUP_CONCAT(CONCAT('\"',mc.id, '\"', ':', '\"', mc.`name`, '\"') SEPARATOR ', '), '}') AS categories
                    FROM user_category uc
                    LEFT JOIN model_category mc ON mc.id = uc.category_id
                    WHERE info_user_id = ui.id
                    GROUP BY info_user_id
                ) AS categories
            ",
            "IFNULL(
                (
                    SELECT src
                    FROM user_media
                    WHERE info_user_id = ui.id
                    AND `type` IN ('image', 'polaroid')
                    ORDER BY `order`
                    LIMIT 1
                ), 
                'diva-logo.png'
            ) AS logo",
        ]);
        $query->from('user_info ui');
        $query->leftJoin('model_category c', 'ui.category_id = c.id');
        $query->leftJoin('user u', 'ui.user_id = u.id');
        $query->leftJoin('user_category uc', 'uc.info_user_id = ui.id');
        $query->groupBy('ui.id');
                
        if($this->categories_key){
            $query->andFilterWhere(['uc.category_id' => $this->categories_key]);
            $query->orFilterWhere(['c.parent_id' => $this->categories_key]);
        }
    
        
        if($this->category_id || $this->category2_id){
            $query->where(['uc.category_id' => $this->category2_id ? $this->category2_id : $this->category_id]);
        }
        
        if($this->subcategory_id){
            $query->leftJoin('user_subcategory us', 'us.info_user_id = ui.id');
            $query->andFilterWhere(['us.subcategory_id'=> array_keys($this->subcategory_id)]);
        }
        
        if($this->phone){
            $query->andFilterWhere(['ui.phone'=> "{$this->prepend_phone}/{$this->phone}"]);
        }
        
        if(!empty($this->specialization)){
            $specialization = array_keys($this->specialization);
            $query->andWhere(['REGEXP', 'ui.specialization', "(".implode('|', $specialization).")"]);
        }
        
        if(!empty($this->city)){
            $query->andWhere(['REGEXP', 'ui.city', "(".implode('|', $this->city).")"]);
        }
        
        if(!empty($this->ethnicity)){
            $query->andWhere(['REGEXP', 'ui.ethnicity', "(".implode('|', $this->ethnicity).")"]);
        }
        
        if(!empty($this->language)){
            $query->andWhere(['REGEXP', 'ui.language', "(".implode('|', $this->language).")"]);
        }
        
        
        if(!empty($this->birth)){
            list($from, $to) = explode('-', $this->birth);
            $query->andWhere(['!=', 'ui.birth', 0]);
            $query->andHaving(['>=', 'ages', $from]);
            $query->andHaving(['<=', 'ages', $to]);
        }
        
        if(!empty($this->height)){
            list($from, $to) = explode('-', $this->height);
            $query->andWhere(['!=', 'ui.height', 0]);
            $query->andWhere(['>', 'height', $from]);
            $query->andWhere(['<', 'height', $to]);
        }
        
        
        if(!empty($this->waist)){
            $waist = explode('-', $this->waist);
            if(count($waist) == 2){
                list($from, $to) = $waist;
                $query->andWhere(['!=', 'ui.waist', 0]);
                $query->andWhere(['>', 'waist', $from]);
                $query->andWhere(['<', 'waist', $to]);
            }else{
                $query->andWhere(['waist'=>$waist]);
            }
        }
        
        
        if(!empty($this->hips)){
            list($from, $to) = explode('-', $this->hips);
            $query->andWhere(['!=', 'ui.hips', 0]);
            $query->andWhere(['>', 'hips', $from]);
            $query->andWhere(['<', 'hips', $to]);
        }
        
        if(!empty($this->shoe)){
            list($from, $to) = explode('-', $this->shoe);
            $query->andWhere(['!=', 'ui.shoe', 0]);
            $query->andWhere(['>', 'shoe', $from]);
            $query->andWhere(['<', 'shoe', $to]);
        }
        
        $query->andFilterWhere([
            'ui.id' => $this->id2,
            'ui.gender' => $this->gender2,

        ]);
        
        $query->andFilterWhere(['like', 'ui.name', $this->name2]);
        
        if(!isset($params['sort'])){
            $query->orderBy('ui.created_at DESC');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
//            'pagination' => false,
             'pagination' => [
                 'pagesize' => 200,
//                'route' => '...',
//                'params' => $params
            ]
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ui.id' => $this->id,
            'ui.old_id' => $this->old_id,
            'ui.user_id' => $this->user_id,
            'ui.gender' => $this->gender,
            'ui.address' => $this->address,
            'ui.weight' => $this->weight,
            'ui.collar' => $this->collar,
            'ui.chest' => $this->chest,
            'ui.type' => $this->type,
            'ui.active' => $this->active,
        ]);
        
        
        $query->andFilterWhere(['like', 'ui.name', $this->name])
            ->andFilterWhere(['like', 'ui.last_name', $this->last_name])
            ->andFilterWhere(['like', 'ui.bio', $this->bio])
            ->andFilterWhere(['like', 'ui.facebook', $this->facebook])
            ->andFilterWhere(['like', 'ui.twitter', $this->twitter])
            ->andFilterWhere(['like', 'ui.instagram', $this->instagram])
            ->andFilterWhere(['like', 'ui.youtube', $this->youtube])
            ->andFilterWhere(['like', 'ui.snapchat', $this->snapchat])
            ->andFilterWhere(['like', 'ui.gender', $this->gender])
            ->andFilterWhere(['like', 'ui.nationality', $this->nationality])
            ->andFilterWhere(['like', 'ui.country', $this->country])
            ->andFilterWhere(['like', 'ui.suit', $this->suit])
            ->andFilterWhere(['like', 'ui.pant', $this->pant])
            ->andFilterWhere(['like', 'ui.hair', $this->hair])
            ->andFilterWhere(['like', 'ui.hair_length', $this->hair_length])
            ->andFilterWhere(['like', 'ui.eye', $this->eye])
            ->andFilterWhere(['like', 'ui.visa_status', $this->visa_status])
            ->andFilterWhere(['like', 'u.subcategory', $this->subcategory])
            ->andFilterWhere(['like', 'ui.email', $this->email]);
                
        return $dataProvider;
    }
}
