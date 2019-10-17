<?php

namespace App\Http\Controllers\SupplierApi\Project;

use App\Http\Controllers\SupplierApi\BaseController;
use App\Http\Requests\SupplierApi\Request;
use App\Http\Resources\SupplierApi\Project\ProjectResource;
use App\Models\Project\Project;
use App\Services\Project\ProjectService;
use App\Services\SqlBuildService;
use Illuminate\Support\Facades\Auth;

/**
 * 项目管理
 *
 * Class ProjectController
 *
 * @package App\Http\Controllers\SupplierApi\Project
 */
class ProjectController extends BaseController
{
    /**
     * 项目列表
     *
     * @param Request $request
     *
     * @return ProjectResource[]
     */
    public function index(Request $request)
    {
        $query  = Project::query();
        $inputs = $request->input();

        $query->where('supplier_uuid', Auth::user()->supplier_uuid);

        $query = SqlBuildService::buildLikeQuery($query, $inputs, [
            'project_name'       => 'project_name',
            'charge_person_name' => 'charge_person_name',
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
     * 项目详情
     *
     * @param \App\Http\Requests\SupplierApi\Request $request
     * @param                                        $projectUUID
     *
     * @return \App\Http\Resources\SupplierApi\Project\ProjectResource
     */
    public function show(Request $request, $projectUUID)
    {
        $project = $this->permission($projectUUID);
        return new ProjectResource($project);
    }

    /**
     * 修改项目服务费率
     *
     * @param \App\Http\Requests\SupplierApi\Request $request
     * @param                                        $projectUUID
     *
     * @return \App\Http\Resources\SupplierApi\Project\ProjectResource
     */
    public function update(Request $request, $projectUUID)
    {
        $project = $this->permission($projectUUID);
        $project = ProjectService::updateServiceCharge($project, $request->input('service_charge'));
        return new ProjectResource($project);
    }

    /**
     * 项目审核
     *
     * @param Request $request
     * @param         $projectUUID
     *
     * @return ProjectResource
     */
    public function changeAuditStatus(Request $request, $projectUUID)
    {
        $auditStatus   = $request->input('audit_status');
        $serviceCharge = $request->input('service_charge');
        $project       = $this->permission($projectUUID);
        $project       = ProjectService::changeAuditStatus($project, $auditStatus, $serviceCharge);
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
        $project = Project::where('project_uuid', $projectUUID)->where('supplier_uuid',
            Auth::user()->supplier_uuid)->firstOrFail();
        return $project;
    }
}