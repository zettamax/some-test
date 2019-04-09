SELECT `t`.`name`,
       `t`.`products_count`,
       `t`.`min_price`,
       `t`.`max_price`,
       `p`.`name_max`,
       `t`.`descr_max_len`,
       `p`.`descr_max`
FROM
  (SELECT `categories`.`name` AS name,
          count(`categories`.`id`) AS products_count,
          min(`products`.`price`) AS min_price,
          max(`products`.`price`) AS max_price,
          max(length(`products`.`description`)) AS descr_max_len,
          `categories`.`id`AS category_id
   FROM `categories`
   JOIN `products` ON `categories`.`id` = `products`.`category_id`
   GROUP BY `products`.`category_id`) t
JOIN
  (SELECT length(`description`) description_len,
          `description` AS descr_max,
          `name` AS name_max,
          `category_id`
   FROM `products`) p ON `p`.`category_id` = `t`.`category_id`
AND `t`.`descr_max_len` = `p`.`description_len`;