<?php
/**
 * 响应码配置
 * ======
 * 尽量遵守约定：0-未知状态 | 1-成功操作 | 大于1都为消极操作
 * ======
 * @author 洪波
 * @version 19.11.21
 */
return [
    0 => '未知状态',
    1 => '操作成功',
    2 => '操作失败',
    //==== 公共部分 ====
    102 => '操作结果无变化',
    103 => '操作失败：参数类型错误，或者缺失',
    104 => '操作失败：身份验证失败，或者权限不足',
    105 => '操作失败：因安全策略，系统拒绝操作',
    106 => '操作失败：要操作的数据或者目标不存在'
];