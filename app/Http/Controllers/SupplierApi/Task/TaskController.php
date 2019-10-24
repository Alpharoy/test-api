<?php

namespace App\Http\Controllers\SupplierApi\Task;

use App\Http\Controllers\SupplierApi\BaseController;
use App\Http\Requests\SupplierApi\Request;
use App\Http\Requests\SupplierApi\Task\UpdateHandlerRequest;
use App\Http\Resources\SupplierApi\Task\TaskResource;
use App\Models\Task\Task;
use App\Services\SqlBuildService;
use App\Services\Supplier\TaskService;
use Illuminate\Support\Facades\Auth;

/**
 * 任务订单
 * Class TaskController
 *
 * @package App\Http\Controllers\SupplierApi\Task
 */
class TaskController extends BaseController
{
    /**
     * 任务列表
     *
     * @param \App\Http\Requests\SupplierApi\Request $request
     *
     * @return \App\Http\Resources\SupplierApi\Task\TaskResource[]
     */
    public function index(Request $request)
    {
        $query  = Task::query();
        $inputs = $request->input();

        $query->where('supplier_uuid', Auth::user()->supplier_uuid);

        $query = SqlBuildService::buildLikeQuery($query, $inputs, [
            'task_uuid'       => 'task_uuid',
            'task_name'       => 'task_name',
            'enterprise_name' => 'enterprise_name',
        ]);

        $query = SqlBuildService::buildTimeQuery($query, $inputs);

        $query = SqlBuildService::buildEqualQuery($query, $inputs, [
            'industry_type_code' => 'industry_type_code',
            'status'             => 'task_status',
        ]);

        $query->orderBy('id', 'desc');
        $tasks = $query->paginate();
        return TaskResource::collection($tasks);
    }

    /**
     * 查看任务详情
     *
     * @param \App\Http\Requests\SupplierApi\Request $request
     * @param                                        $taskUUID
     *
     * @return \App\Http\Resources\SupplierApi\Task\TaskResource
     */
    public function show(Request $request, $taskUUID)
    {
        $task = $this->permission($taskUUID);
        return new TaskResource($task);
    }

    /**
     * 更新任务订单
     *
     * @param \App\Http\Requests\SupplierApi\Task\UpdateHandlerRequest   $request
     * @param                                                            $taskUUID
     *
     * @return \App\Http\Resources\SupplierApi\Task\TaskResource
     */
    public function update(UpdateHandlerRequest $request, $taskUUID)
    {
        $task   = $this->permission($taskUUID);
        $inputs = $request->validated();
        TaskService::update($task, $inputs);
        return new TaskResource($task);
    }

    /**
     * 接单
     *
     * @param \App\Http\Requests\SupplierApi\Task\UpdateHandlerRequest $request
     * @param                                                          $taskUUID
     *
     * @return \App\Http\Resources\SupplierApi\Task\TaskResource
     */
    public function accept(UpdateHandlerRequest $request, $taskUUID)
    {
        $inputs = $request->validated();
        $task   = $this->permission($taskUUID);
        // 先切换到接单状态再切换到派单状态
        $task = TaskService::accept($task);
        $task = TaskService::assign($task, $inputs);
        return new TaskResource($task);
    }

    /**
     * 拒绝接单
     *
     * @param \App\Http\Requests\SupplierApi\Request $request
     * @param                                        $taskUUID
     *
     * @return \App\Http\Resources\SupplierApi\Task\TaskResource
     */
    public function reject(Request $request, $taskUUID)
    {
        $task = $this->permission($taskUUID);
        $task = TaskService::reject($task);
        return new TaskResource($task);
    }

    /**
     * 资源权限
     *
     * @param $taskUUID
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    protected function permission($taskUUID)
    {
        $task = Task::where('task_uuid', $taskUUID)->where('supplier_uuid', Auth::user()->supplier_uuid)->firstOrFail();
        return $task;
    }
}