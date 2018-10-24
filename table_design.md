### TABLE: user  
| 列名 | 数据类型 | 主键 | 非空 | 默认值 | 备注
|---|---|---|---|---|---|
id | int | Y | Y | | AUTO INCREMENT
user_name | varchar(64) | | Y 
nick_name | varchar(64) | |  
register_time | datetime | | | NULL
identity | tinyint | | Y | 0 | 0 is student, 1 is manager
password | varchar(255) | | Y | | default is RANDOM
status | tinyint | | Y | 0 | 0 is normal, -1 is locked, 1 is deleted
is_update | tinyint | | Y |0 | 0 is will update , 1 is no update
is_show | tinyint | | Y | 0 | 0 is will show, 1 is no show

### TABLE: user_account
列名 | 数据类型 | 主键 | 非空 | 默认值 | 备注
---|---|---|---|---|---
id | int | Y | Y | | AUTO INCREMENT
user_id | int | | Y | | key
origin_oj | varchar(16) | | Y | | key
origin_id | varchar(100) | | Y 

### TBALE: category
列名 | 数据类型 | 主键 | 非空 | 默认值 | 备注
---|---|---|---|---|---
id | int | Y | Y | | AUTO INCREMENT
name | varchar(32) | | Y 

### TABLE: porblem
列名 | 数据类型 | 主键 | 非空 | 默认值 | 备注
---|---|---|---|---|---
id | int | Y | Y | | AUTO INCREMENT
origin_oj | varchar(16) | | Y | | key
origin_id | varchar(16) | | Y | | key
category_id | int | | Y | 1 | key
description | varchar(64) | | Y | '' 

### TABLE: problem_ac_time
列名 | 数据类型 | 主键 | 非空 | 默认值 | 备注
---|---|---|---|---|---
id | int | Y | Y | | AUTO INCREMENT
user_id | int | | Y | | key
problem_id | int | | Y | | key
finished_time | datetime | | Y

### TABLE: student_ac_num
列名 | 数据类型 | 主键 | 非空 | 默认值 | 备注
---|---|---|---|---|---
id | int | Y | Y | | AUTO INCREMENT
crawle_time | datetime | | Y 
user_id | int | | Y | | key
origin_oj | varchar(16) | | Y | | key
ac_num | int | | Y | 0 
