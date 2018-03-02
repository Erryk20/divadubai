/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  Sergiy
 * Created: 6 січ. 2018
 */

/**
* Переносить доступность профиля со старой бд
*/
UPDATE user_info ui
LEFT JOIN (
    SELECT 'old_cast' AS type, id,          CASE WHEN availability IN ('Not Available', '') THEN '0' WHEN availability = 'Available' THEN '1' WHEN availability = 'Blacklisted' THEN '-1' END AS availability
    FROM old_cast
    UNION
    SELECT 'old_digital' AS type, id,       CASE WHEN availability IN ('Not Available', '') THEN '0' WHEN availability = 'Available' THEN '1' WHEN availability = 'Blacklisted' THEN '-1' END AS availability
    FROM old_digital
    UNION
    SELECT 'old_directors' AS type, id,     CASE WHEN availability IN ('Not Available', '') THEN '0' WHEN availability = 'Available' THEN '1' WHEN availability = 'Blacklisted' THEN '-1' END AS availability
    FROM old_directors
    UNION
    SELECT 'old_entertainers' AS type, id,  CASE WHEN availability IN ('Not Available', '') THEN '0' WHEN availability = 'Available' THEN '1' WHEN availability = 'Blacklisted' THEN '-1' END AS availability
    FROM old_entertainers
    UNION
    SELECT 'old_events' AS type, id,        CASE WHEN availability IN ('Not Available', '') THEN '0' WHEN availability = 'Available' THEN '1' WHEN availability = 'Blacklisted' THEN '-1' END AS availability
    FROM old_events
    UNION
    SELECT 'old_host' AS type, id,          CASE WHEN availability IN ('Not Available', '') THEN '0' WHEN availability = 'Available' THEN '1' WHEN availability = 'Blacklisted' THEN '-1' END AS availability
    FROM old_host
    UNION
    SELECT 'old_location' AS type, id,      CASE WHEN availability IN ('Not Available', '') THEN '0' WHEN availability = 'Available' THEN '1' WHEN availability = 'Blacklisted' THEN '-1' END AS availability
    FROM old_location
    UNION
    SELECT 'old_stylist' AS type, id,       CASE WHEN availability IN ('Not Available', '') THEN '0' WHEN availability = 'Available' THEN '1' WHEN availability = 'Blacklisted' THEN '-1' END AS availability
    FROM old_stylist
    UNION
    SELECT 'old_ourwork' AS type, id,           CASE WHEN availability IN ('Not Available', '') THEN '0' WHEN availability = 'Available' THEN '1' WHEN availability = 'Blacklisted' THEN '-1' END AS availability
    FROM old_ourwork
    UNION
    SELECT 'old_photographers' AS type, id,     CASE WHEN availability IN ('Not Available', '') THEN '0' WHEN availability = 'Available' THEN '1' WHEN availability = 'Blacklisted' THEN '-1' END AS availability
    FROM old_photographers
    UNION
    SELECT 'old_production' AS type, id,        CASE WHEN availability IN ('Not Available', '') THEN '0' WHEN availability = 'Available' THEN '1' WHEN availability = 'Blacklisted' THEN '-1' END AS availability
    FROM old_production
    UNION
    SELECT 'old_promoters' AS type, id,         CASE WHEN availability IN ('Not Available', '') THEN '0' WHEN availability = 'Available' THEN '1' WHEN availability = 'Blacklisted' THEN '-1' END AS availability
    FROM old_promoters
    UNION
    SELECT 'old_model' AS type, id,             CASE WHEN availability IN ('Not Available', '') THEN '0' WHEN availability = 'Available' THEN '1' WHEN availability = 'Blacklisted' THEN '-1' END AS availability
    FROM old_model
) AS oll ON oll.id = ui.old_id AND oll.type = ui.old_table
SET ui.availability = oll.availability
WHERE oll.id IS NOT NULL

-- Вибирає та добавляє до користувача субкатегорію. використовуючи значення subcategory в таблиці user_info
INSERT INTO user_subcategory (info_user_id, subcategory_id)
SELECT ui.id, ms.id
FROM model_subcategry ms
LEFT JOIN user_info ui ON ui.category_id = ms.category_id AND ui.subcategory LIKE CONCAT('%', ms.slug, '%')
LEFT JOIN user_subcategory us ON us.info_user_id = ui.id AND us.subcategory_id = ms.id
WHERE ui.subcategory IS NOT NULL
AND us.id IS NULL
AND ui.old_table  IS NOT NULL
AND ui.subcategory != '[""]'

-- Вибирає з темпової таблиці subcategory яких немає в usre_subcategory та добавляє їх
INSERT INTO model_subcategry (category_id, name, slug)
SELECT ts.category_id, concat(upper(mid(ts.subcategory,1,1)), mid(ts.subcategory,2)), ts.subcategory
FROM temp_subcategory ts
LEFT JOIN model_subcategry ms ON ms.category_id = ts.category_id AND ms.slug = ts.subcategory 
WHERE ms.id IS NULL
GROUP BY ts.category_id, ts.subcategory

-- ДОбавляє в таблицю user_subcategory недостаючі subcategy з таблиці temp_subcategory
INSERT INTO user_subcategory (info_user_id, subcategory_id)
SELECT ts.info_user_id, ms.id
FROM temp_subcategory ts
LEFT JOIN model_subcategry ms ON ms.category_id = ts.category_id AND ts.subcategory = ms.slug
LEFT JOIN user_subcategory us ON us.info_user_id = ts.info_user_id AND ms.id = us.subcategory_id
WHERE us.id IS NULL


-- Сортування користувачів для моделів
SELECT ui.`id`, ui.`old_id`, ui.`subcategory`, ui.`gender`, ui.`name`, '#', ms.`name`,
    SUM(
        CASE WHEN ms.slug = 'international' THEN 64 
            WHEN ms.slug = 'model 1' THEN 32 
            WHEN ms.slug = 'model 2' THEN 16 
            WHEN ms.slug = 'new face' THEN 8
            WHEN ms.slug = 'celebrity' THEN 4
            WHEN ms.slug = 'direct booking' THEN 2
            WHEN ms.slug = 'portfolio' THEN 1
       END
    ) AS sort

FROM `user_info` ui

LEFT JOIN user_category  uc ON uc.info_user_id = ui.id 
LEFT JOIN model_category mc ON mc.id = uc.category_id

LEFT JOIN model_subcategry ms ON ms.category_id = uc.category_id AND ms.slug IN ('portfolio', 'international', 'model 1', 'model 2', 'New Face', 'celebrity', 'Direct Booking')
LEFT JOIN user_subcategory us ON us.info_user_id = ui.id 

WHERE ui.`gender`='female' AND ui.`active`= '1' 
AND ui.`availability` IN ('1', '0')
AND us.subcategory_id = ms.id
AND old_id IS NOT NULL
GROUP BY ui.id
ORDER BY ui.availability DESC, sort DESC, ui.`name` ASC



-- AND `availability`='1' 

-- 1
-- AND `subcategory` LIKE '%international%'

-- 2
-- AND `subcategory` LIKE '%model 1%'
-- AND `subcategory` NOT LIKE '%international%'

--3
-- AND `subcategory` LIKE '%model 2%'
-- AND `subcategory` NOT LIKE '%international%'
-- AND `subcategory` NOT LIKE '%model 1%'

-- --4
-- AND `subcategory` LIKE '%New Face%'
-- AND `subcategory` NOT LIKE '%international%'
-- AND `subcategory` NOT LIKE '%model 1%'
-- AND `subcategory` NOT LIKE '%model 2%'
-- 
-- --5
-- AND `subcategory` LIKE '%celebrity%'
-- AND `subcategory` NOT LIKE '%international%'
-- AND `subcategory` NOT LIKE '%model 1%'
-- AND `subcategory` NOT LIKE '%model 2%'
-- AND `subcategory` NOT LIKE '%New Face%'
-- 
-- --6
-- AND `subcategory` LIKE '%Direct Booking%'
-- AND `subcategory` NOT LIKE '%international%'
-- AND `subcategory` NOT LIKE '%model 1%'
-- AND `subcategory` NOT LIKE '%model 2%'
-- AND `subcategory` NOT LIKE '%New Face%'
-- AND `subcategory` NOT LIKE '%celebrity%'
-- 
-- --7
-- AND `subcategory` LIKE '%portfolio%'
-- AND `subcategory` NOT LIKE '%international%'
-- AND `subcategory` NOT LIKE '%model 1%'
-- AND `subcategory` NOT LIKE '%model 2%'
-- AND `subcategory` NOT LIKE '%New Face%'
-- AND `subcategory` NOT LIKE '%celebrity%'
-- AND `subcategory` NOT LIKE '%Direct Booking%'


-- AND `availability`='0' 

--8
-- AND `subcategory` LIKE '%international%'

-- --9
-- AND `subcategory` LIKE '%model 1%'
-- AND `subcategory` NOT LIKE '%international%'

--10
-- AND `subcategory` LIKE '%model 2%'
-- AND `subcategory` NOT LIKE '%international%'
-- AND `subcategory` NOT LIKE '%model 1%'

--11
-- AND `subcategory` LIKE 'New Face%'
-- AND `subcategory` NOT LIKE '%international%'
-- AND `subcategory` NOT LIKE '%model 1%'
-- AND `subcategory` NOT LIKE '%model 2%'

-- ORDER BY `name`
