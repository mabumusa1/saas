<div class="card card-bordered">
    <div class="card-header bg-gray-200">
        <div class="card-title">
            <h5>{{__('Billing Contact')}}</h5>
        </div>
    </div>
    <div class="card-body">
        <form>
            <div class="mb-10">
                <label class="form-label">{{__('Billing Name')}}</label>
                <input id="billing-name" name="name" type="text" class="form-control" placeholder="{{$currentAccount->name}}" value="{{$currentAccount->name}}">
            </div>
            <div class="mb-10">
                <label class="form-label">{{__('Billing Email')}}</label>
                <input id="billing-email" name="email" type="email" class="form-control" placeholder="{{$currentAccount->email}}" value="{{$currentAccount->email}}">
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">{{__('Update Billing')}}</button>
            </div>                                
        </form>
    </div>
</div>
