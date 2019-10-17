<?php

namespace App\Http\Controllers\AdminApi\Project;

use App\Http\Controllers\AdminApi\BaseController;
use App\Http\Requests\AdminApi\Request;
use App\Http\Resources\AdminApi\Project\ProjectResource;
use App\Models\Project\Project;
use App\Services\SqlBuildService;

/**
 * 项目管理
 *
 * Class ProjectController
 *
 * @package App\Http\Controllers\AdminApi\Project
 */
class ProjectController extends BaseController
{
    /**
     * 项目列表
     *
     * @param \App\Http\Requests\AdminApi\Request $request
     *
     * @return \App\Http\Resources\AdminApi\Project\ProjectResource[]
     */
    public function index(Request $request)
    {
        $query  = Project::query();
        $inputs = $request->input();

        $query = SqlBuildService::buildLikeQuery($query, $inputs, [
            'project_name'    => 'project_name',
            'supplier_name'   => 'supplier_name',
            'enterprise_name' => 'enterprise_name',
        ]);

        $query = SqlBuildService::buildTimeQuery($query, $inputs);

        $query = SqlBuildService::buildEqualQuery($query, $inputs, [
            'employment_type_code' => 'employment_type_code',
            'industry_type_code'   => 'industry_type_code',
            'status'               => 'audit_status',
        ]);

        $query->orderBy('id', 'desc');
        $projects = $query->paginate();
        return ProjectResource::collection($projects);
    }

    /**
     * 获取项目信息
     *
     * @param string $projectUUID
     *
     * @return \App\Http\Resources\AdminApi\Project\ProjectResource
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function show($projectUUID)
    {
        $project = $this->permission($projectUUID);
        return new ProjectResource($project);
    }

    /**
     * 资源权限
     *
     * @param $projectUUID
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function permission($projectUUID)
    {
        $project = Project::where('project_uuid', $projectUUID)->firstOrFail();
        return $project;
    }
}