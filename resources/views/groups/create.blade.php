<x-base-layout>
    <div class="container mb-8">
        <div class="card">
            <div class="card-body">
                <h2 class="text-dark mb-8">Create Group</h2>
                <form action="{{ route('groups.store', $account) }}" method="POST" id="group-form" class="form w-lg-500px mx-auto" novalidate="novalidate" autocomplete="off">
                    @csrf
                    <div class="mb-5">
                        <label class="form-label">Name *</label>
                        <input type="text" class="form-control" name="name" placeholder="Group Name" id="name" required>
                    </div>
                    <div class="mb-5">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" name="notes" placeholder="Description"></textarea>
                    </div>
                    <div class="mb-5 d-flex justify-content-end">
                        <a class="btn btn-secondary btn-color-gray-700 btn-flex btn-active-primary h-40px border-0 fw-bolder px-4 px-lg-6 me-2 me-lg-3" href="{{ url()->previous() }}">Cancel</a>
                        <button type="submit" class="btn btn-primary" id="btn-submit">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-base-layout>
