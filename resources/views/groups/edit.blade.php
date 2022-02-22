<x-base-layout>
    <div class="container mb-8">
        <div class="row">
            <div class="col-3">
                <div class="card">

                    <div class="card-body">
                        <h5 class="card-title mb-10">Groups</h5>
                        @foreach ($groups as $grp)
                            <div class="mb-5">
                                @if ($grp->is($group))
                                    <span>
                                        <span class="d-block">{{ $grp->name }}</span>
                                        <span>{{ $grp->notes }}</span>
                                    </span>
                                @else
                                    <a href="{{ route('groups.edit', [$account->id, $grp->id]) }}">
                                        <span class="d-block">{{ $grp->name }}</span>
                                        <span>{{ $grp->notes }}</span>
                                    </a>
                                @endif
                            </div>
                        @endforeach
                        <a class="btn btn-primary btn-sm" href={{ route('groups.create', [$account->id, $grp->id])}}>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                              </svg>
                            Add Group</a>
                    </div>
                </div>
            </div>
            <div class="col-9">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-dark mb-8">Edit Group</h2>
                        <form action="{{ route('groups.update', compact('account', 'group')) }}" method="POST"
                            id="group-form" class="form mx-auto" novalidate="novalidate" autocomplete="off">

                            @csrf
                            @method('PUT')
                            <div class="mb-5">
                                <div class="mb-5">
                                    <label class="form-label">Name *</label>
                                    <input type="text" class="form-control" name="name" placeholder="Group Name"
                                        id="name" required value={{ $group->name }}>
                                </div>
                                <div class="">
                                    <label class="form-label">Notes</label>
                                    <textarea class="form-control" name="notes"
                                        placeholder="Description">{{ $group->notes }}</textarea>
                                </div>
                                <span class="text-muted ">URLs will be converted into clickable links</span>
                            </div>
                            <div class="mb-5">
                                <h5>Add Sites to this group</h5>
                                <div>
                                    <button type="button" class="btn btn-dark btn-sm" id="selectAll">Select all</button>
                                    <button type="button" class="btn btn-dark btn-sm" id="removeAll">Remove all</button>
                                </div>
                                <div class="mt-17">
                                    <div class="row">
                                        @foreach ($sites as $site)
                                            <div class="col-4 mb-15">
                                                <div class="form-check">
                                                    <input name="sites[]" class="form-check-input site" type="checkbox"
                                                        value="{{ $site->id }}"
                                                        {{ $group->hasSite($site) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        {{ $site->name }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6 mb-5">
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            id="btn-submit">Delete group</button>
                                    </div>
                                    <div class="col-6 mb-5 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary btn-sm" id="btn-submit">Update
                                            group</button>

                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('scripts')
        <script>
            document.querySelector('#selectAll').addEventListener('click', function() {
                document.querySelectorAll('.site').forEach(function(el) {
                    el.checked = true;
                })
            });
            document.querySelector('#removeAll').addEventListener('click', function() {
                document.querySelectorAll('.site').forEach(function(el) {
                    el.checked = false;
                })
            });
        </script>
    @endsection
</x-base-layout>
