<div class="card card-bordered">
    <div class="card-header bg-gray-200">
        <div class="card-title">
            <h5>{{__('Billing Contact')}}</h5>
        </div>
    </div>
    <div class="card-body">
        <form method="post" action="{{ route('billing.info.update', $currentAccount->id) }}">
            @csrf
            @method('PUT')
            <div class="mb-10">
                <label class="form-label">{{__('Billing Name')}}</label>
                <input id="billing-name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="{{$currentAccount->name}}" value="{{$currentAccount->name}}" required>
                @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-10">
                <label class="form-label">{{__('Billing Email')}}</label>
                <input id="billing-email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{$currentAccount->email}}" value="{{$currentAccount->email}}">
                @error('email')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary me-2 mb-2">{{__('Update Billing')}}</button>
            </div>
        </form>
    </div>
</div>
