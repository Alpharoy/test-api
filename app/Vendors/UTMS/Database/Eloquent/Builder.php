<?php

namespace UTMS\Database\Eloquent;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Pagination\Paginator;

class Builder extends EloquentBuilder
{
    /**
     * Paginate the given query.
     *
     * @param  int      $perPage
     * @param  array    $columns
     * @param  string   $pageName
     * @param  int|null $page
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     *
     */
    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        $page = $page ?: Paginator::resolveCurrentPage($pageName);

        $perPage = $perPage ?: $this->resolveCurrentPerPage('per_page');

        $results = ($total = $this->toBase()->getCountForPagination())
            ? $this->forPage($page, $perPage)->get($columns)
            : $this->model->newCollection();

        return $this->paginator($results, $total, $perPage, $page, [
            'path'     => Paginator::resolveCurrentPath(),
            'pageName' => $pageName,
        ]);
    }

    /**
     * Resolve the current per page.
     *
     * @param string $perPageName
     *
     * @return int
     */
    private function resolveCurrentPerPage($perPageName)
    {
        $perPage = app('request')->input($perPageName);

        if (filter_var($perPage, FILTER_VALIDATE_INT) !== false) {
            return (int)max(1, min(50, $perPage));
        }

        return $this->model->getPerPage();
    }
}