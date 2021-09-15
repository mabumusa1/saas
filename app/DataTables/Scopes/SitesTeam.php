<?php

namespace App\DataTables\Scopes;

use Auth;
use Yajra\DataTables\Contracts\DataTableScope;

class SitesTeam implements DataTableScope
{
    /**
     * Apply a query scope.
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder $query
     * @return mixed
     */
    public function apply($query)
    {
        return $query->where('team_id', Auth::user()->currentTeam->id);
    }
}
