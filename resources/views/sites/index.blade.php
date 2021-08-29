<x-app-layout>
    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">{{__('Sites')}}</h3>
            <div class="card-toolbar">
                <a href="#" class="btn btn-light me-2 mb-2">{{__('Accept Transfer')}}</a>
                <a href="{{route('sites.create')}}" class="btn btn-primary me-2 mb-2">{{__('Add Site')}}</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <div class="mb-10">
                        <input type="text" class="form-control form-control-solid" placeholder="Search">
                    </div>                    
                </div>
                <div class="col">
                    <a href="{{route('groups.create')}}">{{__('Add Group')}}</a>
                </div>
            </div>
            <table class="table table-row-dashed table-row-gray-300 gy-7">
                <thead>
                    <tr class="fw-bolder fs-6 text-gray-800">
                        <th>{{__('Site Name')}}</th>
                        <th>{{__('PHP')}}</th>
                        <th>{{__('Group')}}</th>
                        <th>{{__('Storage')}}</th>
                        <th>{{__('Bandwidth')}}</th>
                        <th>{{__('Visits')}}</th>
                        <th>{{__('Actions')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sites as $site)
                    <tr class="fw-bolder">
                        <td>{{$site->name}}</td>
                        <td></td>
                        <td>{{$site->groups->implode('name', ', ')}}</td>
                        <td>{{$site->storage}}</td>
                        <td>{{$site->bandwidth}}</td>
                        <td>{{$site->visits}}</td>
                        <td>
                            <!--begin::Trigger-->
                            <button type="button" class="btn btn-primary btn-active-light-primary rotate"
                                data-kt-menu-trigger="click"
                                data-kt-menu-placement="bottom-start"
                                data-kt-menu-flip="top-start">
                                <i class="bi bi-three-dots"></i>
                            </button>
                            <!--end::Trigger-->
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-200px py-4"
                                data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">
                                        Delete Site
                                    </a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                        </td>
                    </tr>
                    @foreach ($site->environments as $environment)
                    <tr>
                        <td>
                            <p>
                            @switch($environment->type)
                                @case('PRD')
                                    <span class="badge badge-success">{{$environment->type}}</span>
                                    @break
                                @case('STG')
                                    <span class="badge badge-warning">{{$environment->type}}</span>
                                    @break
                                @case('DEV')
                                    <span class="badge badge-light">{{$environment->type}}</span>
                                    @break
                            @endswitch
                            {{$environment->name}}</p>
                            <a href="https://{{$environment->name}}.steercampaign.com">{{$environment->name}}.steercampaign.com</a>
                        </td>
                        <td>{{$environment->php}}</td>
                        <td></td>
                        <td>{{$environment->storage}}</td>
                        <td>{{$environment->bandwidth}}</td>
                        <td>{{$environment->visits}}</td>
                        <td>
                            <!--begin::Trigger-->
                            <button type="button" class="btn btn-primary btn-active-light-primary rotate"
                                data-kt-menu-trigger="click"
                                data-kt-menu-placement="bottom-start"
                                data-kt-menu-flip="top-start">
                                <i class="bi bi-three-dots"></i>
                            </button>
                            <!--end::Trigger-->
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-200px py-4"
                                data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">
                                        Backup
                                    </a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">
                                        Purge Cache
                                    </a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">
                                        Delete Environment
                                    </a>
                                </div>
                                <!--end::Menu item-->

                            </div>

                        </td>
                    </tr>
                    @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>    
</x-app-layout>