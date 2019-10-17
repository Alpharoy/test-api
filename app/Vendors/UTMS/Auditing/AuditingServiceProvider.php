<?php

namespace UTMS\Auditing;

use OwenIt\Auditing\Models\Audit;

class AuditingServiceProvider extends \OwenIt\Auditing\AuditingServiceProvider
{
    public function boot()
    {
        // 审计模块内容为空时，不生成审计内容
        Audit::creating(function (Audit $model) {
            if (empty($model->old_values) && empty($model->new_values)) {
                return false;
            }
        });
    }
}
