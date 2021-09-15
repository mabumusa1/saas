<?php

namespace App\DataTables;

use App\Models\Site;
use Illuminate\Support\Str;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SitesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->only(['id', 'name', 'groups', 'environments', 'php', 'bandwidth', 'storage', 'action'])
            ->setRowId(function ($site) {
                return 'site_'.$site->id;
            })
            ->setRowData([
                'data-id' => function ($site) {
                    return 'site_'.$site->id;
                },
                'data-name' => function ($site) {
                    return 'site_'.$site->name;
                },
            ])
            ->addColumn('name', '<p class="fw-bolder">{{$name}}</p>')
            ->addColumn('groups', function (Site $site) {
                return $site->groups->map(function ($group) {
                    return "<span class=\"badge badge-primary\">{$group->name}</span>";
                })->implode('<br/>');
            })
            ->addColumn('php', '')
            ->addColumn('bandwidth', function (Site $site) {
                return "<p class=\"fw-bolder\">{$site->bandwidth}</p>";
            })
            ->addColumn('storage', function (Site $site) {
                return "<p class=\"fw-bolder\">{$site->storage}</p>";
            })
            ->addColumn('action', function (Site $site) {
                return view('sites.actions', compact('site'));
            })
            ->rawColumns(['name', 'groups', 'bandwidth', 'storage', 'action'])
            ->skipTotalRecords()
            ->skipPaging();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Site $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Site $model)
    {
        return $model->newQuery()->with(['environments', 'groups']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('sites-table')
                    ->columns($this->getColumns())
                    ->autoWidth(true)
                    ->minifiedAjax()
                    ->scrollY(true)
                    ->dom('frtip')
                    ->ordering(false)
                    ->paging(false)
                    ->parameters([
                        'initComplete' => $this->initCompleteCallback(),
                    ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('name')->title('name')->searchable(true)->orderable(false)->footer('title')->exportable(false)->printable(false),
            Column::make('groups')->title('groups')->searchable(false)->orderable(false)->footer('title')->exportable(false)->printable(false),
            Column::make('php')->title('php')->searchable(false)->orderable(false)->footer('title')->exportable(false)->printable(false),
            Column::make('bandwidth')->title('bandwidth')->searchable(false)->orderable(false)->footer('title')->exportable(false)->printable(false),
            Column::make('storage')->title('storage')->searchable(false)->orderable(false)->footer('title')->exportable(false)->printable(false),
            Column::make('action')->title('action')->searchable(false)->orderable(false)->footer('title')->exportable(false)->printable(false),
        ];
    }

    protected function initCompleteCallback()
    {
        return <<<'JS'
            function(row, data, dataIndex)
            {
                $("#sites-table_filter").detach().appendTo('#sites-search-bar');
                data.data.forEach(site => {
                    site.environments.forEach(environment => {
                        var template = Handlebars.compile($("#details-template").html());
                        switch (environment.type) {
                            case 'PRD':
                                environment.badgeClass = "success";
                                break;
                            case 'STG':
                                environment.badgeClass = "warning";
                                break;
                            case 'DEV':
                                environment.badgeClass = "danger";
                                break;
                        }
                        $(template(environment)).insertAfter($(`#${site.DT_RowId}`))
                    })
                });
            }
        JS;
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Sites_'.date('YmdHis');
    }
}
