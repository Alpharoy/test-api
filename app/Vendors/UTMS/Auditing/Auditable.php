<?php

namespace UTMS\Auditing;


trait Auditable
{
    use \OwenIt\Auditing\Auditable;

    /**
     * 重写Audit,以加入自定义类型
     *
     * @param array $data
     *
     * @return array
     */
    public function transformAudit(array $data): array
    {
        $data['site_uuid'] = $this->resolveSite();
        return $data;
    }

    /**
     * @return string
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function resolveSite()
    {

        return global_data(cons('misc.global_data.site_uuid'));
    }
}
