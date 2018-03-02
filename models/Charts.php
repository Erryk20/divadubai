<?php

namespace app\models;

use Yii;


/**
 * ContactForm is the model behind the contact form.
 */
class Charts
{
    public static function getGender(){
        $query = "
            SELECT m.type,  CONCAT('[', GROUP_CONCAT(CONCAT('[\"', m.gender, '\",', m.count, ']')), ']') AS 'gender'
            FROM (
                SELECT 'Models' AS 'type', ui.gender, COUNT(uc.id) AS 'count'
                FROM user_category uc
                LEFT JOIN user_info ui ON ui.id = uc.info_user_id
                WHERE uc.category_id = 4
                GROUP BY ui.gender
            ) m
            UNION
            SELECT m.type,  CONCAT('[', GROUP_CONCAT(CONCAT('[\"', m.gender, '\",', m.count, ']')), ']') AS 'gender'
            FROM (
                SELECT 'Cast' AS 'type', ui.gender, COUNT(uc.id) AS 'count'
                FROM user_category uc
                LEFT JOIN user_info ui ON ui.id = uc.info_user_id
                WHERE uc.category_id = 8
                GROUP BY ui.gender
            ) m
            UNION
            SELECT m.type,  CONCAT('[', GROUP_CONCAT(CONCAT('[\"', m.gender, '\",', m.count, ']')), ']') AS 'gender'
            FROM (
                SELECT 'Entertainers' AS 'type', ui.gender, COUNT(uc.id) AS 'count'
                FROM user_category uc
                LEFT JOIN user_info ui ON ui.id = uc.info_user_id
                WHERE uc.category_id = 15
                GROUP BY ui.gender
            ) m
            UNION
            SELECT m.type,  CONCAT('[', GROUP_CONCAT(CONCAT('[\"', m.gender, '\",', m.count, ']')), ']') AS 'gender'
            FROM (
                SELECT 'Stylist' AS 'type', ui.gender, COUNT(uc.id) AS 'count'
                FROM user_category uc
                LEFT JOIN user_info ui ON ui.id = uc.info_user_id
                WHERE uc.category_id = 19
                GROUP BY ui.gender
            ) m
            UNION
            SELECT m.type,  CONCAT('[', GROUP_CONCAT(CONCAT('[\"', m.gender, '\",', m.count, ']')), ']') AS 'gender'
            FROM (
                SELECT 'Promoters' AS 'type', ui.gender, COUNT(uc.id) AS 'count'
                FROM user_category uc
                LEFT JOIN user_info ui ON ui.id = uc.info_user_id
                WHERE uc.category_id = 38
                GROUP BY ui.gender
            ) m
        ";
        
        $list = Yii::$app->db->createCommand($query)->queryAll();
        
        $result = [];
        
        $i = 0;
        foreach ($list as $key => $value) {
            if(($key%3) == 0) {$i++;}
            
            $result[$i][$value['type']] = json_decode($value['gender'], true);
        }
        
        return $result;
    }
    
    
    
    public static function getTotal(){
        $query = "
            SELECT m.type, 
                CONCAT('[', GROUP_CONCAT(CONCAT('\"', m.name, '\"') SEPARATOR ','),']') AS list, 
                'Total' AS 'name1', CONCAT('[', GROUP_CONCAT(m.Total SEPARATOR ','), ']') AS Total , 
                'Approved' AS 'name2', CONCAT('[', GROUP_CONCAT(m.Approved SEPARATOR ','), ']') AS Approved
            FROM (
                SELECT 'Total Records' AS 'type', mc.`name`, COUNT(uc.id) AS Total, COUNT(CASE WHEN uc.active = '1' THEN 1 END) AS Approved
                FROM model_category mc
                LEFT JOIN user_category uc ON uc.category_id = mc.id
                WHERE mc.`type` = 'site'
                GROUP BY mc.id
                ORDER BY mc.`name` ASC
            ) m
            UNION
            SELECT m.type, 
                CONCAT('[', GROUP_CONCAT(CONCAT('\"', m.name, '\"') SEPARATOR ','),']') AS list, 
                'Total No. of Jobs' AS 'name1', CONCAT('[', GROUP_CONCAT(m.total SEPARATOR ','), ']') AS Total , 
                'Applied' AS 'name2', CONCAT('[', GROUP_CONCAT(m.approved SEPARATOR ','), ']') AS Approved
            FROM (
                SELECT 'Total Jobs' AS 'type', mc.`name`, COUNT(uc.id) AS total, COUNT(CASE WHEN uc.active = '1' THEN 1 END) AS approved
                FROM menu_category mc
                LEFT JOIN user_category uc ON uc.category_id = mc.category_id
                WHERE mc.menu IN ('model-management', 'event', 'production', 'promotions-activations')
                GROUP BY mc.menu
                ORDER BY mc.menu ASC
            ) m
        ";
        
        $list = Yii::$app->db->createCommand($query)->queryAll();
        
        
        $result = [];
        foreach ($list as $value) {
            $result[$value['type']]['list'] = json_decode($value['list'], true);
            $result[$value['type']]['Total'] = json_decode($value['Total'], true);
            $result[$value['type']]['Approved'] = json_decode($value['Approved'], true);
            $result[$value['type']]['name1'] = $value['name1'];
            $result[$value['type']]['name2'] = $value['name2'];
        }
        return $result;
    }
    
    
    
    public static function getSubcategories($category_id){
        $query = "
            SELECT CONCAT('{\"name\":\"', name, '\",', '\"y\":', countUser, '}') AS result
            FROM (
                SELECT ms.`name`, COUNT(us.id) AS 'countUser'
                FROM model_subcategry ms
                LEFT JOIN user_subcategory us ON us.subcategory_id = ms.id
                WHERE category_id = :category_id
                GROUP BY ms.id
            ) m
        ";
        
        $list =  Yii::$app->db->createCommand($query, [':category_id'=>$category_id])->queryAll();
        
        $result = [];
        foreach ($list as $value) {
            $result[] = json_decode($value['result'], TRUE);
        }
        
        return $result;
    }
    
    
    
    public static function getTotalNumbers(){
        $query = "
            SELECT CONCAT('{\"name\":\"', mc.`name`, '\",\"data\":[', COUNT(uc.id), ']}') AS 'result'
            FROM user_category uc
            LEFT JOIN model_category mc ON mc.id = uc.category_id
            WHERE uc.category_id IN (4,38)
            GROUP BY uc.category_id
        ";
        
        $list =  Yii::$app->db->createCommand($query)->queryAll();
        
        $result = [];
        foreach ($list as $value) {
            $result[] = json_decode($value['result'], TRUE);
        }
        return $result;
    }
    
    public static function getYearProgression(){
        $date = new \DateTime();
        $date->modify('-1 year');
        $yearAgoTime = strtotime( "{$date->format('Y-m')}-01 +1 month" );
        $yearAgo = date('Y-m-d', $yearAgoTime);
        
        $listMonth = [
            date('F', $yearAgoTime),
            date('F', (strtotime( "{$yearAgo} +1 month" ))),
            date('F', (strtotime( "{$yearAgo} +2 month" ))),
            date('F', (strtotime( "{$yearAgo} +3 month" ))),
            date('F', (strtotime( "{$yearAgo} +4 month" ))),
            date('F', (strtotime( "{$yearAgo} +5 month" ))),
            date('F', (strtotime( "{$yearAgo} +6 month" ))),
            date('F', (strtotime( "{$yearAgo} +7 month" ))),
            date('F', (strtotime( "{$yearAgo} +8 month" ))),
            date('F', (strtotime( "{$yearAgo} +9 month" ))),
            date('F', (strtotime( "{$yearAgo} +10 month" ))),
            date('F', (strtotime( "{$yearAgo} +11 month" ))),
        ];
            
        $listZero = [0,0,0,0,0,0,0,0,0,0,0,0];
        
        $query = "
            SELECT 'Year Progression Graph' AS 'tite',
                CONCAT('{\"name\":\"Registration\", \"data\":{', GROUP_CONCAT(CONCAT('\"', ui.month, '\":', ui.Registration) SEPARATOR ','), '}}') AS 'Registration',
                CONCAT('{\"name\":\"Modernize\", \"data\":{', GROUP_CONCAT(CONCAT('\"', ui.month, '\":', ui.Modernize) SEPARATOR ','), '}}') AS 'Modernize',
                CONCAT('{\"name\":\"Deleted\", \"data\":{', GROUP_CONCAT(CONCAT('\"', ui.month, '\":', ui.Deleted) SEPARATOR ','), '}}') AS 'Deleted'
            FROM (
                SELECT DATE_FORMAT(FROM_UNIXTIME(created_at), '%M') AS 'month', 
                    SUM(IF(status = '1', 1, 0)) AS 'Registration',  
                    SUM(IF(status = '0', 1, 0)) AS 'Modernize',
                    SUM(IF(status = '-1', 1, 0)) AS 'Deleted'
                FROM user_info
                WHERE created_at > :yearAgo
                GROUP BY month
            ) ui
        ";
        
        $request =  Yii::$app->db->createCommand($query, [':yearAgo'=>$yearAgoTime])->queryOne();
        
        $result = [];
        $result['tite'] = $request['tite'];

        $result['categories'] = $listMonth;

        $data = json_decode($request['Registration'], TRUE);
        $result['data'][0] = ['name'=>'Registration','data'=> $listZero];
        $result['data'][0]['data'] = self::setData($data, $listMonth);
        
        
        $data = json_decode($request['Modernize'], TRUE);
        $result['data'][1] = ['name'=>'Modernize','data'=> $listZero];
        $result['data'][1]['data'] = self::setData($data, $listMonth);
        
        
        $data = json_decode($request['Deleted'], TRUE);
        $result['data'][2] = ['name'=>'Deleted','data'=> $listZero];
        $result['data'][2]['data'] = self::setData($data, $listMonth);
       
        return $result;
    }
    
    public static function setData($data, $listMonth){
        if($data){
            foreach ($listMonth as $key => $value) {
                $result[$key] = 0;
                if(in_array($value, array_keys($data['data']))){
                    $result[$key] = $data['data'][$value];
                }
            }
        }
        return $result;
    }




//    -- UNION
//            -- (
//            --     SELECT 'Year Progression Graph For Award' AS 'tite',
//            --         CONCAT('[', GROUP_CONCAT(CONCAT('\"',ui.month, '\"') SEPARATOR ','), ']') AS 'categories',
//            --         CONCAT('{\"name\":\"Registration\", \"data\":[', GROUP_CONCAT(ui.Registration SEPARATOR ','), ']}') AS 'Registration',
//            --         CONCAT('{\"name\":\"Modernize\", \"data\":[', GROUP_CONCAT(ui.Modernize SEPARATOR ','), ']}') AS 'Modernize',
//            --         CONCAT('{\"name\":\"Deleted\", \"data\":[', GROUP_CONCAT(ui.Deleted SEPARATOR ','), ']}') AS 'Deleted'
//            --     FROM (
//            --         SELECT DATE_FORMAT(FROM_UNIXTIME(created_at), '%M') AS 'month', 
//            --             SUM(IF(status = '1', 1, 0)) AS 'Registration',  
//            --             SUM(IF(status = '0', 1, 0)) AS 'Modernize',
//            --             SUM(IF(status = '-1', 1, 0)) AS 'Deleted'
//            --         FROM user_info
//            --         WHERE created_at > :yearAgo AND category_id = 14
//            --         GROUP BY month
//            --     ) ui
//            -- )
//            UNION
//            (
//                SELECT 'Year Progression Graph For Cast' AS 'tite',
//                    CONCAT('[', GROUP_CONCAT(CONCAT('\"',ui.month, '\"') SEPARATOR ','), ']') AS 'categories',
//                    CONCAT('{\"name\":\"Registration\", \"data\":[', GROUP_CONCAT(ui.Registration SEPARATOR ','), ']}') AS 'Registration',
//                    CONCAT('{\"name\":\"Modernize\", \"data\":[', GROUP_CONCAT(ui.Modernize SEPARATOR ','), ']}') AS 'Modernize',
//                    CONCAT('{\"name\":\"Deleted\", \"data\":[', GROUP_CONCAT(ui.Deleted SEPARATOR ','), ']}') AS 'Deleted'
//                FROM (
//                    SELECT DATE_FORMAT(FROM_UNIXTIME(created_at), '%M') AS 'month', 
//                        SUM(IF(status = '1', 1, 0)) AS 'Registration',  
//                        SUM(IF(status = '0', 1, 0)) AS 'Modernize',
//                        SUM(IF(status = '-1', 1, 0)) AS 'Deleted'
//                    FROM user_info
//                    WHERE created_at > :yearAgo AND category_id = 8
//                    GROUP BY month
//                ) ui
//            )
//            UNION
//            (
//                SELECT 'Year Progression Events' AS 'tite',
//                    CONCAT('[', GROUP_CONCAT(CONCAT('\"',ui.month, '\"') SEPARATOR ','), ']') AS 'categories',
//                    CONCAT('{\"name\":\"Registration\", \"data\":[', GROUP_CONCAT(ui.Registration SEPARATOR ','), ']}') AS 'Registration',
//                    CONCAT('{\"name\":\"Modernize\", \"data\":[', GROUP_CONCAT(ui.Modernize SEPARATOR ','), ']}') AS 'Modernize',
//                    CONCAT('{\"name\":\"Deleted\", \"data\":[', GROUP_CONCAT(ui.Deleted SEPARATOR ','), ']}') AS 'Deleted'
//                FROM (
//                    SELECT DATE_FORMAT(FROM_UNIXTIME(ui.created_at), '%M') AS 'month', 
//                        SUM(IF(ui.status = '1', 1, 0)) AS 'Registration',  
//                        SUM(IF(ui.status = '0', 1, 0)) AS 'Modernize',
//                        SUM(IF(ui.status = '-1', 1, 0)) AS 'Deleted'
//                    FROM user_info ui
//                    LEFT JOIN user_category uc ON uc.info_user_id = ui.id
//                    LEFT JOIN model_category mc ON mc.id = uc.category_id
//                    WHERE ui.created_at > :yearAgo AND (mc.id = 7 OR mc.parent_id = 7)
//                ) ui
//            )
//            UNION
//            (
//                SELECT 'Year Progression Directors' AS 'tite',
//                    CONCAT('[', GROUP_CONCAT(CONCAT('\"',ui.month, '\"') SEPARATOR ','), ']') AS 'categories',
//                    CONCAT('{\"name\":\"Registration\", \"data\":[', GROUP_CONCAT(ui.Registration SEPARATOR ','), ']}') AS 'Registration',
//                    CONCAT('{\"name\":\"Modernize\", \"data\":[', GROUP_CONCAT(ui.Modernize SEPARATOR ','), ']}') AS 'Modernize',
//                    CONCAT('{\"name\":\"Deleted\", \"data\":[', GROUP_CONCAT(ui.Deleted SEPARATOR ','), ']}') AS 'Deleted'
//                FROM (
//                    SELECT DATE_FORMAT(FROM_UNIXTIME(ui.created_at), '%M') AS 'month', 
//                        SUM(IF(ui.status = '1', 1, 0)) AS 'Registration',  
//                        SUM(IF(ui.status = '0', 1, 0)) AS 'Modernize',
//                        SUM(IF(ui.status = '-1', 1, 0)) AS 'Deleted'
//                    FROM user_info ui
//                    LEFT JOIN user_category uc ON uc.info_user_id = ui.id
//                    LEFT JOIN model_category mc ON mc.id = uc.category_id
//                    WHERE ui.created_at > :yearAgo AND (mc.id = 13 OR mc.parent_id = 13)
//                ) ui
//            )
//            UNION
//            (
//                SELECT 'Year Progression Digital Marketing (Influencers)' AS 'tite',
//                    CONCAT('[', GROUP_CONCAT(CONCAT('\"',ui.month, '\"') SEPARATOR ','), ']') AS 'categories',
//                    CONCAT('{\"name\":\"Registration\", \"data\":[', GROUP_CONCAT(ui.Registration SEPARATOR ','), ']}') AS 'Registration',
//                    CONCAT('{\"name\":\"Modernize\", \"data\":[', GROUP_CONCAT(ui.Modernize SEPARATOR ','), ']}') AS 'Modernize',
//                    CONCAT('{\"name\":\"Deleted\", \"data\":[', GROUP_CONCAT(ui.Deleted SEPARATOR ','), ']}') AS 'Deleted'
//                FROM (
//                    SELECT DATE_FORMAT(FROM_UNIXTIME(ui.created_at), '%M') AS 'month', 
//                        SUM(IF(ui.status = '1', 1, 0)) AS 'Registration',  
//                        SUM(IF(ui.status = '0', 1, 0)) AS 'Modernize',
//                        SUM(IF(ui.status = '-1', 1, 0)) AS 'Deleted'
//                    FROM user_info ui
//                    LEFT JOIN user_category uc ON uc.info_user_id = ui.id
//                    WHERE ui.created_at > :yearAgo AND (uc.category_id  = 12)
//                ) ui
//            )
//            UNION
//            (
//                SELECT 'Year Progression Entertainers' AS 'tite',
//                    CONCAT('[', GROUP_CONCAT(CONCAT('\"',ui.month, '\"') SEPARATOR ','), ']') AS 'categories',
//                    CONCAT('{\"name\":\"Registration\", \"data\":[', GROUP_CONCAT(ui.Registration SEPARATOR ','), ']}') AS 'Registration',
//                    CONCAT('{\"name\":\"Modernize\", \"data\":[', GROUP_CONCAT(ui.Modernize SEPARATOR ','), ']}') AS 'Modernize',
//                    CONCAT('{\"name\":\"Deleted\", \"data\":[', GROUP_CONCAT(ui.Deleted SEPARATOR ','), ']}') AS 'Deleted'
//                FROM (
//                    SELECT DATE_FORMAT(FROM_UNIXTIME(ui.created_at), '%M') AS 'month', 
//                        SUM(IF(ui.status = '1', 1, 0)) AS 'Registration',  
//                        SUM(IF(ui.status = '0', 1, 0)) AS 'Modernize',
//                        SUM(IF(ui.status = '-1', 1, 0)) AS 'Deleted'
//                    FROM user_info ui
//                    LEFT JOIN user_category uc ON uc.info_user_id = ui.id
//                    WHERE ui.created_at > :yearAgo AND (uc.category_id = 15)
//                ) ui
//            )
//            UNION
//            (
//                SELECT 'Year Progression Locations' AS 'tite',
//                    CONCAT('[', GROUP_CONCAT(CONCAT('\"',ui.month, '\"') SEPARATOR ','), ']') AS 'categories',
//                    CONCAT('{\"name\":\"Registration\", \"data\":[', GROUP_CONCAT(ui.Registration SEPARATOR ','), ']}') AS 'Registration',
//                    CONCAT('{\"name\":\"Modernize\", \"data\":[', GROUP_CONCAT(ui.Modernize SEPARATOR ','), ']}') AS 'Modernize',
//                    CONCAT('{\"name\":\"Deleted\", \"data\":[', GROUP_CONCAT(ui.Deleted SEPARATOR ','), ']}') AS 'Deleted'
//                FROM (
//                    SELECT DATE_FORMAT(FROM_UNIXTIME(ui.created_at), '%M') AS 'month', 
//                        SUM(IF(ui.status = '1', 1, 0)) AS 'Registration',  
//                        SUM(IF(ui.status = '0', 1, 0)) AS 'Modernize',
//                        SUM(IF(ui.status = '-1', 1, 0)) AS 'Deleted'
//                    FROM user_info ui
//                    LEFT JOIN user_category uc ON uc.info_user_id = ui.id
//                    WHERE ui.created_at > :yearAgo AND (uc.category_id = 24)
//                ) ui
//            )
//            UNION
//            (
//                SELECT 'Year Progression Models' AS 'tite',
//                    CONCAT('[', GROUP_CONCAT(CONCAT('\"',ui.month, '\"') SEPARATOR ','), ']') AS 'categories',
//                    CONCAT('{\"name\":\"Registration\", \"data\":[', GROUP_CONCAT(ui.Registration SEPARATOR ','), ']}') AS 'Registration',
//                    CONCAT('{\"name\":\"Modernize\", \"data\":[', GROUP_CONCAT(ui.Modernize SEPARATOR ','), ']}') AS 'Modernize',
//                    CONCAT('{\"name\":\"Deleted\", \"data\":[', GROUP_CONCAT(ui.Deleted SEPARATOR ','), ']}') AS 'Deleted'
//                FROM (
//                    SELECT DATE_FORMAT(FROM_UNIXTIME(ui.created_at), '%M') AS 'month', 
//                        SUM(IF(ui.status = '1', 1, 0)) AS 'Registration',  
//                        SUM(IF(ui.status = '0', 1, 0)) AS 'Modernize',
//                        SUM(IF(ui.status = '-1', 1, 0)) AS 'Deleted'
//                    FROM user_info ui
//                    LEFT JOIN user_category uc ON uc.info_user_id = ui.id
//                    WHERE ui.created_at > :yearAgo AND (uc.category_id = 4)
//                ) ui
//            )
//            UNION
//            (
//                SELECT 'Year Progression Our works' AS 'tite',
//                    CONCAT('[', GROUP_CONCAT(CONCAT('\"',ui.month, '\"') SEPARATOR ','), ']') AS 'categories',
//                    CONCAT('{\"name\":\"Registration\", \"data\":[', GROUP_CONCAT(ui.Registration SEPARATOR ','), ']}') AS 'Registration',
//                    CONCAT('{\"name\":\"Modernize\", \"data\":[', GROUP_CONCAT(ui.Modernize SEPARATOR ','), ']}') AS 'Modernize',
//                    CONCAT('{\"name\":\"Deleted\", \"data\":[', GROUP_CONCAT(ui.Deleted SEPARATOR ','), ']}') AS 'Deleted'
//                FROM (
//                    SELECT DATE_FORMAT(FROM_UNIXTIME(ui.created_at), '%M') AS 'month', 
//                        SUM(IF(ui.status = '1', 1, 0)) AS 'Registration',  
//                        SUM(IF(ui.status = '0', 1, 0)) AS 'Modernize',
//                        SUM(IF(ui.status = '-1', 1, 0)) AS 'Deleted'
//                    FROM user_info ui
//                    LEFT JOIN user_category uc ON uc.info_user_id = ui.id
//                    WHERE ui.created_at > :yearAgo AND (uc.category_id = 42)
//                ) ui
//            )
//            UNION
//            (
//                SELECT 'Year Progression Photographers' AS 'tite',
//                    CONCAT('[', GROUP_CONCAT(CONCAT('\"',ui.month, '\"') SEPARATOR ','), ']') AS 'categories',
//                    CONCAT('{\"name\":\"Registration\", \"data\":[', GROUP_CONCAT(ui.Registration SEPARATOR ','), ']}') AS 'Registration',
//                    CONCAT('{\"name\":\"Modernize\", \"data\":[', GROUP_CONCAT(ui.Modernize SEPARATOR ','), ']}') AS 'Modernize',
//                    CONCAT('{\"name\":\"Deleted\", \"data\":[', GROUP_CONCAT(ui.Deleted SEPARATOR ','), ']}') AS 'Deleted'
//                FROM (
//                    SELECT DATE_FORMAT(FROM_UNIXTIME(ui.created_at), '%M') AS 'month', 
//                        SUM(IF(ui.status = '1', 1, 0)) AS 'Registration',  
//                        SUM(IF(ui.status = '0', 1, 0)) AS 'Modernize',
//                        SUM(IF(ui.status = '-1', 1, 0)) AS 'Deleted'
//                    FROM user_info ui
//                    LEFT JOIN user_category uc ON uc.info_user_id = ui.id
//                    WHERE ui.created_at > :yearAgo AND (uc.category_id = 17)
//                ) ui
//            )
//            UNION
//            (
//                SELECT 'Year Progression Stylist' AS 'tite',
//                    CONCAT('[', GROUP_CONCAT(CONCAT('\"',ui.month, '\"') SEPARATOR ','), ']') AS 'categories',
//                    CONCAT('{\"name\":\"Registration\", \"data\":[', GROUP_CONCAT(ui.Registration SEPARATOR ','), ']}') AS 'Registration',
//                    CONCAT('{\"name\":\"Modernize\", \"data\":[', GROUP_CONCAT(ui.Modernize SEPARATOR ','), ']}') AS 'Modernize',
//                    CONCAT('{\"name\":\"Deleted\", \"data\":[', GROUP_CONCAT(ui.Deleted SEPARATOR ','), ']}') AS 'Deleted'
//                FROM (
//                    SELECT DATE_FORMAT(FROM_UNIXTIME(ui.created_at), '%M') AS 'month', 
//                        SUM(IF(ui.status = '1', 1, 0)) AS 'Registration',  
//                        SUM(IF(ui.status = '0', 1, 0)) AS 'Modernize',
//                        SUM(IF(ui.status = '-1', 1, 0)) AS 'Deleted'
//                    FROM user_info ui
//                    LEFT JOIN user_category uc ON uc.info_user_id = ui.id
//                    WHERE ui.created_at > :yearAgo AND (uc.category_id = 19)
//                ) ui
//            )
    
  
}