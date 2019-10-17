<?php

namespace App\Http\Controllers\SupplierApi;

use App\Http\Controllers\Controller;
use App\Services\Initial\LogService;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
    public function __destruct()
    {
        $userUUID = '';
        $user     = Auth::user();
        if ($user) {
            $userUUID = $user->user_uuid;
        }
        LogService::store($userUUID, 'supplier.web');
    }
}