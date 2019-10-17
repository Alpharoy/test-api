<?php

namespace UTMS\Auditing\Resolvers;

class UserResolver implements \OwenIt\Auditing\Contracts\UserResolver
{
    /**
     * {@inheritdoc}
     */
    public static function resolve()
    {
        return \Auth::user();
    }
}
