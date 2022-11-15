@foreach ($currentAccount->sites as $site )
    <div class="row">
        <div class="col-8">
            <h3>{{ $site->subscription?->displayName }}
                @if($site->subscription?->canceled())
                    <span class="badge badge-warning">{{ __('Scheduled for deletion') }}</span>
                @else
                    <span class="badge badge-success">{{ \Str::title($site->subscription?->period) }}</span>
                @endif
            </h3>
            <p class="text-muted mb-2 mt-2">{{ __('Subscription Started on: :start', ['start' => $site->subscription?->created_at->format('Y-m-d')]) }}</p>
            @if($site->subscription?->canceled())
                <p class="text-muted mb-2 mt-2">{{ __('Subscription ends on: :end', ['end' => $site->subscription?->ends_at->format('Y-m-d')]) }}</p>
            @endif
            <p class="mb-2"><a href="{{ route('installs.show', [$currentAccount, $site, $site->installs()?->first()]) }}">{{ __('Assoicated with :site', ['site' => $site->subscription?->site->name]) }}</a></p>
        </div>
        <div class="col-4">
            @if(!$site->subscription?->canceled())
                <a class="btn-delete btn btn-outline btn-outline-danger btn-active-light-danger btn-icon-danger" data-target=".delete_form{{ $site->id }}">
                    {!! get_svg_icon('icons/duotune/general/gen040.svg') !!}
                    {{ __('Delete') }}
                </a>
                <form
                action="{{ route('sites.destroy', [$currentAccount->id, $site->id]) }}"
                class="delete_form{{ $site->id }}" method="post">
                @csrf
                @method('DELETE')
                </form>
            @endif
        </div>
    </div>
    <hr class="mb-5 mt-5" />
@endforeach

@push('scripts')
<script>
var deleteBtn = document.querySelectorAll('.btn-delete');
deleteBtn.forEach(function(button) {
    button.addEventListener('click', function(e) {
        Swal.fire({
            title: 'Are you sure?',
            text: "By deleting this subscription you will delete the site and end the subscription, you will not be charged for it after the end of the billing period",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.querySelector(button.getAttribute('data-target')).submit();
            }
        })
    });
})
</script>
@endpush
