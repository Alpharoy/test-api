<?php

namespace App\Http\Controllers\EnterpriseApi\Project;

use App\Http\Controllers\EnterpriseApi\BaseController;
use App\Http\Requests\EnterpriseApi\Project\ProjectCreateRequest;
use App\Http\Requests\EnterpriseApi\Project\ProjectUpdateRequest;
use App\Http\Requests\EnterpriseApi\Request;
use App\Http\Resources\EmptyResource;
use App\Http\Resources\EnterpriseApi\Project\ProjectResource;
use App\Models\Project\Project;
use App\Services\Project\ProjectService;
use App\Services\SqlBuildService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

/**
 * 项目管理
 *
 * Class ProjectController
 *
 * @package App\Http\Controllers\EnterpriseApi\Project
 */
class ProjectController extends BaseController
{
    /**
     * 项目列表
     *
     * @param \App\Http\Requests\EnterpriseApi\Request $request
     *
     * @return \App\Http\Resources\EnterpriseApi\Project\ProjectResource[]
     * @throws \InvalidArgumentException
     */
    public function index(Request $request)
    {
        $query  = Project::query();
        $inputs = $request->input();

        $query->where('enterprise_uuid', Auth::user()->enterprise_uuid);

        $query = SqlBuildService::buildLikeQuery($query, $inputs, [
            'project_name'       => 'project_name',
            'charge_person_name' => 'charge_person_name',
            'supplier_name'      => 'supplier_name',
        ]);

        $query = SqlBuildService::buildTimeQuery($query, $inputs);

        $query = SqlBuildService::buildEqualQuery($query, $inputs, [
            'employment_type_code'  => 'employment_type_code',
            'industry_type_code'    => 'industry_type_code',
            'status'                => 'audit_status',
            'is_open'               => 'is_open',
            'is_industry_type_open' => 'is_industry_type_open',
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
     * @return \App\Http\Resources\EnterpriseApi\Project\ProjectResource
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function show($projectUUID)
    {
        $project = $this->permission($projectUUID);
        return new ProjectResource($project);
    }

    /**
     * 创建项目
     *
     * @param ProjectCreateRequest $request
     *
     * @return ProjectResource
     */
    public function store(ProjectCreateRequest $request)
    {
        $inputs       = $request->validated();
        $supplierUUID = Arr::pull($inputs, 'supplier_uuid');
        $project      = ProjectService::store(Auth::user()->enterprise_uuid, $supplierUUID, $inputs);
        return new ProjectResource($project);
    }

    /**
     * 修改项目
     *
     * @param ProjectUpdateRequest $request
     * @param                      $projectUUID
     *
     * @return ProjectResource
     */
    public function update(ProjectUpdateRequest $request, $projectUUID)
    {
        $inputs  = $request->validated();
        $project = $this->permission($projectUUID);
        if ($project->is_audit_passed) {
            // 如审核通过，部分信息不能修改
            $inputs = Arr::except($inputs,
                ['project_name', 'industry_type_code', 'employment_type_code', 'permission']);
        } else {
            // 状态更改为未审核，有可能是审核不通过后，继续修改提交信息，此时状态需要修改为未审核
            $inputs['status'] = cons('common.audit_status.unaudited');
        }
        $project = ProjectService::update($project, $inputs);
        return new ProjectResource($project);
    }

    /**
     * 删除项目
     *
     * @param \App\Http\Requests\EnterpriseApi\Request $request
     * @param                                          $projectUUID
     *
     * @return \App\Http\Resources\EmptyResource
     * @throws \Exception
     */
    public function destroy(Request $request, $projectUUID)
    {
        $project = $this->permission($projectUUID);
        ProjectService::delete($project);
        return new EmptyResource();
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
        $project = Project::where('project_uuid', $projectUUID)->where('enterprise_uuid',
            Auth::user()->enterprise_uuid)->firstOrFail();
        return $project;
    }
}