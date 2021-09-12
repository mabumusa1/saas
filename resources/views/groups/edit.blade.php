<x-app-layout>
    <form class="form" id="kt_form_1" method="POST" action="{{ route('groups.update', $group->id) }}">
        @csrf
        @method('PUT')
        <h1 class="my-4">Edit Group</h1>
        <div class="form-group row">
            <div class="mb-10">
                <label for="name" class="required form-label">Name</label>
                <input type="text" class="form-control form-control-white" name="name" value="{{ $group->name }}" placeholder="Name"/>
            </div>

            <div class="mb-10">
                <label for="notes" class="required form-label">Notes</label>
                <textarea type="text" class="form-control form-control-white" name="notes">{{ $group->notes }}</textarea>
            </div>
        </div>

        <div class="separator separator-dashed my-10"></div>
        
        <div class="container">
            <div class="row">
            <h2 class="my-4">Add sites to this group</h2>
            <div class="col-lg-12">
                <input hidden name="selectAllCheckbox" class="form-check-input" type="checkbox" id="check_ungrouped"/>
                <button type="button" id="selectAll" class="btn btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary">Select All</button>
                <button type="button" id="removeAll" class="btn btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary">Remove All</button>
            </div>
            <span class="badge badge-light-primary">UNGROUPED SITES</span>
              <div class="col-sm">
                <div class="my-10">
                    <input class="form-check-input" type="checkbox" id="check_ungrouped" {{ $group->ungrouped_sites ? $group->ungrouped_sites['ungrouped_sites_1'] ? 'checked' : '' : ''}} value="ungrouped_sites_1" name="ungrouped_sites[]" />
                    <label class="form-check-label" for="check_ungrouped">
                        Check 1
                    </label>
                </div>
                <div class="my-10">
                    <input class="form-check-input" type="checkbox" id="check_ungrouped" {{ $group->ungrouped_sites ? $group->ungrouped_sites['ungrouped_sites_2'] ? 'checked' : '' : ''}} value="ungrouped_sites_2" name="ungrouped_sites[]" />
                    <label class="form-check-label" for="check_ungrouped">
                        Check 4
                    </label>
                </div>
                <div class="my-10">
                    <input class="form-check-input" type="checkbox" id="check_ungrouped" {{ $group->ungrouped_sites ? $group->ungrouped_sites['ungrouped_sites_3'] ? 'checked' : '' : ''}} value="ungrouped_sites_3" name="ungrouped_sites[]" />
                    <label class="form-check-label" for="check_ungrouped">
                        Check 7
                    </label>
                </div>
                <div class="my-10">
                    <input class="form-check-input" type="checkbox" id="check_ungrouped" {{ $group->ungrouped_sites ? $group->ungrouped_sites['ungrouped_sites_4'] ? 'checked' : '' : ''}} value="ungrouped_sites_4" name="ungrouped_sites[]" />
                    <label class="form-check-label" for="check_ungrouped">
                        Check 10
                    </label>
                </div>
              </div>
              <div class="col-sm">
                <div class="my-10">
                    <input class="form-check-input" type="checkbox" id="check_ungrouped" {{ $group->ungrouped_sites ? $group->ungrouped_sites['ungrouped_sites_5'] ? 'checked' : '' : ''}} value="ungrouped_sites_5" name="ungrouped_sites[]" />
                    <label class="form-check-label" for="check_ungrouped">
                        Check 2
                    </label>
                </div>
                <div class="my-10">
                    <input class="form-check-input" type="checkbox" id="check_ungrouped" {{ $group->ungrouped_sites ? $group->ungrouped_sites['ungrouped_sites_6'] ? 'checked' : '' : ''}} value="ungrouped_sites_6" name="ungrouped_sites[]" />
                    <label class="form-check-label" for="check_ungrouped">
                        Check 5
                    </label>
                </div>
                <div class="my-10">
                    <input class="form-check-input" type="checkbox" id="check_ungrouped" {{ $group->ungrouped_sites ? $group->ungrouped_sites['ungrouped_sites_7'] ? 'checked' : '' : ''}} value="ungrouped_sites_7" name="ungrouped_sites[]" />
                    <label class="form-check-label" for="check_ungrouped">
                        Check 8
                    </label>
                </div>
              </div>
              <div class="col-sm">
                <div class="my-10">
                    <input class="form-check-input" type="checkbox" id="check_ungrouped" {{ $group->ungrouped_sites ? $group->ungrouped_sites['ungrouped_sites_8'] ? 'checked' : '' : ''}} value="ungrouped_sites_8" name="ungrouped_sites[]" />
                    <label class="form-check-label" for="check_ungrouped">
                        Check 3
                    </label>
                </div>
                <div class="my-10">
                    <input class="form-check-input" type="checkbox" id="check_ungrouped" {{ $group->ungrouped_sites ? $group->ungrouped_sites['ungrouped_sites_9'] ? 'checked' : '' : ''}} value="ungrouped_sites_9" name="ungrouped_sites[]" />
                    <label class="form-check-label" for="check_ungrouped">
                        Check 6
                    </label>
                </div>
                <div class="my-10">
                    <input class="form-check-input" type="checkbox" id="check_ungrouped" {{ $group->ungrouped_sites ? $group->ungrouped_sites['ungrouped_sites_10'] ? 'checked' : '': '' }} value="ungrouped_sites_10" name="ungrouped_sites[]" />
                    <label class="form-check-label" for="check_ungrouped">
                        Check 9
                    </label>
                </div>
              </div>
            </div>
          </div>
        
          <div class="separator separator-dashed my-10"></div>
        
          <div class="container">
            <div class="row">
            <h2 class="my-4">Edit Group</h2>
            <span class="badge badge-light-primary">GROUPED SITES</span>
              <div class="col-sm">
                <div class="my-10">
                    <input class="form-check-input" type="checkbox" id="check_grouped" {{ $group->grouped_sites ? $group->grouped_sites['grouped_sites_1'] ? 'checked' : '' : '' }} value="grouped_sites_1" name="grouped_sites[]" />
                    <label class="form-check-label" for="check_grouped">
                        Check 1
                    </label>
                </div>
                <div class="my-10">
                    <input class="form-check-input" type="checkbox" id="check_grouped" {{ $group->grouped_sites ? $group->grouped_sites['grouped_sites_2'] ? 'checked' : '' : '' }} value="grouped_sites_2" name="grouped_sites[]" />
                    <label class="form-check-label" for="check_grouped">
                        Check 2
                    </label>
                </div>
                <div class="my-10">
                    <input class="form-check-input" type="checkbox" id="check_grouped" {{ $group->grouped_sites ? $group->grouped_sites['grouped_sites_3'] ? 'checked' : '' : '' }} value="grouped_sites_3" name="grouped_sites[]" />
                    <label class="form-check-label" for="check_grouped">
                        Check 3
                    </label>
                </div>
              </div>
            </div>
          </div>
       
        <div class="row">
            <div class="col-lg-10 ml-lg-auto mt-10">
                <form action="{{ route('groups.destroy', $group->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger font-weight-bold mr-2">
                        Delete group
                    </button> 
                </form>
                
            </div>
            <div class="col-lg-2 ml-lg-auto mt-10">
                <button type="submit" class="btn btn-primary font-weight-bold mr-2">Update</button>
            </div>
        </div>
    </form>
</x-app-layout>

<script>

$("#selectAll").click(function(){
    var allCheckbox = $("input[type='checkbox']");
    allCheckbox.prop('checked', true);
    allCheckbox.change(function() {
        $('input:checkbox').prop('checked', this.checked);
    })
});

$("#removeAll").click(function(){
    var allCheckbox = $("input[type='checkbox']");
    allCheckbox.prop('checked', false);
    allCheckbox.change(function() {
        $('input:checkbox').prop('checked', this.checked);
    })
});

</script>