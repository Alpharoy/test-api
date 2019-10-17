<?php

namespace App\Console\Commands;

use App\Models\Admin\Admin;
use App\Models\Permission\Menu;
use App\Models\Permission\Role;
use App\Models\Permission\RoleMenu;
use App\Services\Admin\AdminService;
use Illuminate\Console\Command;

class Init extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '初始化项目';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        if (!$this->allowInitialize()) {
            $this->error('已有数据，无需初始化项目');
            return;
        }

        // 清空数据
        Admin::truncate();
        Role::truncate();
        Menu::truncate();

        // 建立节点
        $this->call('node:update');

        $nodeConfig = config('node');
        // 建立超级角色
        Role::create([
            'name'        => '超级角色',
            'description' => '拥有所有权限',
            'group'       => 0,
        ]);
        Menu::create([
            'parent_id'   => null,
            'name'        => '超级角色',
            'description' => '拥有所有权限',
            'group'       => 0,
        ]);
        RoleMenu::create([
            'role_id' => 1,
            'menu_id' => 1,
        ]);


        // 建立超级角色（只读）
        Role::create([
            'name'        => '超级角色（只读）',
            'description' => '拥有所有只读权限',
            'group'       => 0,
        ]);
        Menu::create([
            'parent_id'   => null,
            'name'        => '超级角色（只读）',
            'description' => '拥有所有只读权限',
            'group'       => 0,
        ]);
        RoleMenu::create([
            'role_id' => 2,
            'menu_id' => 2,
        ]);

        AdminService::store(['admin_name' => 'OJMS管理平台'], [
            'user_name'  => 'OJMS',
            'user_phone' => '18999999999',
            'password'   => '123456',
        ]);

        $this->info('初始化数据完成');
    }

    /**
     * 是否允许初始化
     *
     * @return bool
     */
    protected function allowInitialize()
    {
        if (Admin::withTrashed()->count() > 0) {
            $this->info('admins table must be empty.');
            return false;
        }

        if (Role::withTrashed()->count() > 0) {
            $this->info('roles table must be empty.');
            return false;
        }

        if (Menu::withTrashed()->count() > 0) {
            $this->info('menus table must be empty.');
            return false;
        }

        return true;
    }

}
