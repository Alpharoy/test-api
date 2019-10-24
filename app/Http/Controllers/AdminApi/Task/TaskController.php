<?php

namespace App\Http\Controllers\AdminApi\Task;

use App\Http\Controllers\AdminApi\BaseController;
use App\Http\Requests\AdminApi\Request;
use App\Http\Resources\AdminApi\Task\TaskResource;
use App\Models\Task\Task;
use App\Services\SqlBuildService;

/**
 * 任务订单
 * Class TaskController
 *
 * @package App\Http\Controllers\AdminApi\Task
 */
class TaskController extends BaseController
{

    /**
     * 任务列表
     *
     * @param \App\Http\Requests\AdminApi\Request $request
     *
     * @return \App\Http\Resources\AdminApi\Task\TaskResource[]
     */
    public function index(Request $request)
    {
        $query  = Task::query();
        $inputs = $request->input();

        $query = SqlBuildService::buildLikeQuery($query, $inputs, [
            'task_uuid'       => 'task_uuid',
            'task_name'       => 'task_name',
            'supplier_name'   => 'supplier_name',
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
     * @param \App\Http\Requests\AdminApi\Request $request
     * @param                                     $taskUUID
     *
     * @return \App\Http\Resources\AdminApi\Task\TaskResource
     */
    public function show(Request $request, $taskUUID)
    {
        $task = $this->permission($taskUUID);
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
        $task = Task::where('task_uuid', $taskUUID)->firstOrFail();
        return $task;
    }
}