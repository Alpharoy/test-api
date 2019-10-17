<?php

namespace UTMS\Auth;

use App\Models\Admin\AdminUser;
use App\Models\Enterprise\EnterpriseUser;
use App\Models\Supplier\SupplierUser;
use App\Services\Auth\TokenService;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Urland\Exceptions\Client\ForbiddenException;
use Urland\Exceptions\Server\InternalServerException;

class TokenGuard implements Guard
{
    use GuardHelpers;

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    protected $userGroup;

    /**
     * The name of the token "column" in persistent storage.
     *
     * @var string
     */
    protected $headerTokenName;

    /**
     * Create a new authentication guard.
     *
     * @param \Illuminate\Contracts\Auth\UserProvider $provider
     * @param \Illuminate\Http\Request                $request
     * @param int                                     $userGroup
     *
     * @return void
     */
    public function __construct(UserProvider $provider, Request $request, $userGroup)
    {
        $this->request         = $request;
        $this->provider        = $provider;
        $this->userGroup       = $userGroup;
        $this->headerTokenName = 'X-Api-Token';
    }

    /**
     * Get the currently authenticated user.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Urland\Exceptions\Client\AuthenticationException
     * @throws \Urland\Exceptions\Client\ForbiddenException
     * @throws \Urland\Exceptions\Server\InternalServerException
     */
    public function user()
    {
        // If we've already retrieved the user for the current request we can just
        // return it back immediately. We do not want to fetch the user data on
        // every call to this method because that would be tremendously slow.
        if (!is_null($this->user)) {
            return $this->user;
        }

        $user = null;

        $tokenValue = $this->request->header($this->headerTokenName);
        $token      = TokenService::validateToken($tokenValue);

        if ($token->user_group !== $this->userGroup) {
            throw new ForbiddenException('接口调用错误');
        }

        // TODO: 禁止web的token调用app的接口

        switch ($token->user_group) {
            case cons('user.group.admin'):
                $user = AdminUser::where('user_uuid', $token->user_uuid)->first();
                break;
            case cons('user.group.enterprise'):
                $user = EnterpriseUser::where('user_uuid', $token->user_uuid)->first();
                break;
            case cons('user.group.supplier'):
                $user = SupplierUser::where('user_uuid', $token->user_uuid)->first();
                break;
            default:
                throw new InternalServerException('未定义用户组别');
        }

        $this->user = $user;

        return $user;
    }

    /**
     * Validate a user's credentials.
     *
     * @param array $credentials
     *
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        return false;
    }

    /**
     * Set the current request instance.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return $this
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;

        return $this;
    }

}
