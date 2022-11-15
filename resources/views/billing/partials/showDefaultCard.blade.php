<div class="card card-bordered border-gray-600 border-dotted">
    <div class="card-body">
        <div class="mb-10">
                <!--begin::Card info-->
                <div class="fw-bold text-gray-600 d-flex align-items-center">
                    <img src="{{ asset("skin/media/svg/card-logos/$currentAccount->pm_type.svg") }}" class="w-35px ms-2" alt="">
                    <!--end::Card info-->
                    <!--begin::Card expiry-->
                    <div class="fw-bold text-gray-600">{{ __('Card ends with') }} {{$currentAccount->pm_last_four}}</div>
                    <!--end::Card expiry-->
                </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="d-flex justify-content-end">
            <form method="post" action="{{ route('billing.destroy', $currentAccount) }}">
                @csrf
                @method('DELETE')
                <button href="{{ route('billing.index', $currentAccount->id) }}" class="btn btn-danger me-2 mb-2" type="submit">{{__('Delete Card')}}</button>
            </form>
            <a href="{{ route('billing.index', [$currentAccount->id, 'update' => true]) }}" class="btn btn-primary me-2 mb-2">{{__('Update Card')}}</a>
        </div>
    </div>
</div>
