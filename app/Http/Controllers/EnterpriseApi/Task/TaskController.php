<?php

namespace App\Http\Controllers\EnterpriseApi\Task;

use App\Http\Controllers\EnterpriseApi\BaseController;
use App\Http\Requests\EnterpriseApi\Request;
use App\Http\Requests\EnterpriseApi\Task\TaskCreateRequest;
use App\Http\Requests\EnterpriseApi\Task\TaskUpdateRequest;
use App\Http\Resources\EmptyResource;
use App\Http\Resources\EnterpriseApi\Task\TaskResource;
use App\Models\Task\Task;
use App\Services\SqlBuildService;
use App\Services\Supplier\TaskService;
use Illuminate\Support\Facades\Auth;

/**
 * 任务订单
 * Class TaskController
 *
 * @package App\Http\Controllers\EnterpriseApi\Task
 */
class TaskController extends BaseController
{

    /**
     * 任务列表
     *
     * @param \App\Http\Requests\EnterpriseApi\Request $request
     *
     * @return \App\Http\Resources\EnterpriseApi\Task\TaskResource[]
     */
    public function index(Request $request)
    {
        $query  = Task::query();
        $inputs = $request->input();

        $query->where('enterprise_uuid', Auth::user()->enterprise_uuid);

        $query = SqlBuildService::buildLikeQuery($query, $inputs, [
            'task_uuid'     => 'task_uuid',
            'task_name'     => 'task_name',
            'supplier_name' => 'supplier_name',
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
     * 新增任务订单
     *
     * @param \App\Http\Requests\EnterpriseApi\Task\TaskCreateRequest $request
     *
     * @return \App\Http\Resources\EnterpriseApi\Task\TaskResource
     */
    public function store(TaskCreateRequest $request)
    {
        $inputs                = $request->validated();
        $inputs['source_from'] = cons('common.source_from.insert');
        $task                  = TaskService::store(Auth::user()->enterprise_uuid, $inputs);
        return new TaskResource($task);
    }

    /**
     * 查看任务详情
     *
     * @param \App\Http\Requests\EnterpriseApi\Request $request
     * @param                                          $taskUUID
     *
     * @return \App\Http\Resources\EnterpriseApi\Task\TaskResource
     */
    public function show(Request $request, $taskUUID)
    {
        $task = $this->permission($taskUUID);
        return new TaskResource($task);
    }

    /**
     * 更新任务订单
     *
     * @param \App\Http\Requests\EnterpriseApi\Task\TaskUpdateRequest $request
     * @param                                                         $taskUUID
     *
     * @return \App\Http\Resources\EnterpriseApi\Task\TaskResource
     */
    public function update(TaskUpdateRequest $request, $taskUUID)
    {
        $task   = $this->permission($taskUUID);
        $inputs = $request->validated();
        TaskService::update($task, $inputs);
        return new TaskResource($task);
    }

    /**
     * 删除任务订单
     *
     * @param \App\Http\Requests\EnterpriseApi\Request $request
     * @param                                          $taskUUID
     *
     * @return \App\Http\Resources\EmptyResource
     * @throws \Exception
     */
    public function destroy(Request $request, $taskUUID)
    {
        $task = $this->permission($taskUUID);
        TaskService::delete($task);
        return new EmptyResource();
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
        $task = Task::where('task_uuid', $taskUUID)->where('enterprise_uuid',
            Auth::user()->enterprise_uuid)->firstOrFail();
        return $task;
    }
}