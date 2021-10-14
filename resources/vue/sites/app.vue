<template>
    <div class="card card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">Sites</h3>
            <div class="card-toolbar">
                <a href="#" class="btn btn-light me-2 mb-2">Add Group</a>
                <a href="#" class="btn btn-light me-2 mb-2">Accept Transfer</a>
                <a href="#" class="btn btn-primary me-2 mb-2">Add Site</a>
            </div>
        </div>
      <div class="card-body text-center"  v-if="!hasSites">
            <h3 class="mb-3">You do not have any active sites</h3>
            <a :href="addSiteRoute" class="mt-2 btn btn-primary">Add Site</a>
        </div>
        <div class="card-body" v-else>
            <div class="row">
                <div class="col">
                    <div class="d-flex align-items-center">
                        <!--begin::Input group-->
                        <div class="position-relative w-md-400px me-md-2">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                            <span class="svg-icon svg-icon-3 svg-icon-gray-500 position-absolute top-50 translate-middle ms-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black"></rect>
                                    <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black"></path>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <input type="text" class="form-control form-control-solid ps-10" name="search" value="" placeholder="Search">
                        </div>
                        <!--end::Input group-->
                        <!--begin:Action-->
                        <div class="d-flex align-items-center">
                            <button type="submit" class="btn btn-primary me-5">Search</button>
                            <a class="btn btn-light"><i class="fas fa-filter"></i></a>
                        </div>
                        <!--end:Action-->
                    </div>
					<div class="collapse show">
						<div class="separator separator-dashed mt-9 mb-6"></div>
						<div class="row g-8 mb-8">
							<div class="col-xxl-4">
								<!-- Environments -->
								<div class="rounded border p-10">
									<label class="fs-6 form-label fw-bolder text-dark mb-10">Environments</label>
									<div class="form-check form-check-solid form-switch fv-row mb-10">
										<input class="form-check-input w-45px h-30px" type="checkbox" id="showEnvironments" checked="checked" v-model="showEnvironments">
										<label class="form-check-label" for="showEnvironments">Show</label>
									</div>								
									<div class="mb-10">
										<div class="form-check form-check-custom form-check-solid">
											<input class="form-check-input" type="checkbox" id="developmentCheck" v-model="environmentsFilter" value="DEV">
											<label class="form-check-label" for="developmentCheck">Development</label>
										</div>
									</div>
									<div class="mb-10">
										<div class="form-check form-check-custom form-check-solid">
											<input class="form-check-input" type="checkbox" id="stagingCheck" v-model="environmentsFilter" value="STG">
											<label class="form-check-label" for="stagingCheck">Staging</label>
										</div>
									</div>									
									<div class="mb-10">
										<div class="form-check form-check-custom form-check-solid">
											<input class="form-check-input" type="checkbox" id="productionCheck" v-model="environmentsFilter" value="PRD">
											<label class="form-check-label" for="productionCheck">Production</label>
										</div>
									</div>									
								</div>								
							</div>
							<div class="col-xxl-8">
								<!-- Groups -->
								<div class="rounded border p-10">
									<label class="fs-6 form-label fw-bolder text-dark mb-10">Groups</label>
									<div class="mb-10">
										<div class="form-check form-check-custom form-check-solid">
											<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
											<label class="form-check-label" for="flexCheckDefault">Default checkbox</label>
										</div>
									</div>
									<div class="mb-10">
										<div class="form-check form-check-custom form-check-solid">
											<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
											<label class="form-check-label" for="flexCheckDefault">Default checkbox</label>
										</div>
									</div>									
									<div class="mb-10">
										<div class="form-check form-check-custom form-check-solid">
											<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
											<label class="form-check-label" for="flexCheckDefault">Default checkbox</label>
										</div>
									</div>									
								</div>								
							</div>
						</div>
					</div>
                </div>
            </div>            
        <div class="table-responsive">
        <table class="table table-row-dashed table-row-gray-500 gy-7">
            <thead>
                <tr class="fw-bolder fs-6 text-gray-800">
                    <th>Site Name</th>
                    <th>Group</th>
                    <th>PHP</th>
                    <th>Storage</th>
                    <th>Bandwidth</th>
                    <th>Visits</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <template v-for="site in filteredSites">
                    <tr class="fw-bolder table-light" :key="'site' + site.id">
                        <td>{{ site.name }}</td>
                        <td>
                            <template v-for="group in site.groups">
                                <span class="badge badge-secondary" :key="'group' + group.id">{{group.name}}</span>
                            </template>
                        </td>
                        <td></td>
                        <td>{{site.storage}}</td>
                        <td>{{site.bandwidth}}</td>
                        <td>{{site.visits}}</td>
                        <td>
                            <button type="button" class="btn btn-primary me-2 mb-2" data-toggle="tooltip" title="Delete Site">
                                <i class="icon-xl fas fa-trash"></i>
                            </button>                            
                        </td>
                    </tr>
                    <template v-if="showEnvironments">
                    <tr v-for="environment in site.environments" :key="'env' + environment.id">
                        <td>
                            <div class="row">
                                    <div class="col-md-2">
                                        <span :class="getClass(environment.type)">{{environment.type}}</span>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="col-md-4">
                                            <p class="fw-bolder">{{environment.name}}</p>
                                        </div>
                                        <div class="col-md-8">
                                            <a :href="'https://' + environment.name + '.steercampaign.com'">{{environment.name}}.steercampaign.com</a>
                                        </div>
                                    </div>
                            </div>
                        </td>
                        <td></td>
                        <td>{{environment.php}}</td>
                        <td>{{environment.storage}}</td>
                        <td>{{environment.bandwidth}}</td>
                        <td>{{environment.visits}}</td>
                        <td>
                            <button type="button" class="btn btn-primary me-2 mb-2" data-toggle="tooltip" title="Delete Site">
                                <i class="icon-xl fas fa-database"></i>
                            </button>
                            <button type="button" class="btn btn-primary me-2 mb-2" data-toggle="tooltip" title="Delete Site">
                                <i class="icon-xl fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>

                    </template>
                </template>
            </tbody>
        </table>  
        </div>            
        </div>
    </div>
</template>


<script>
const default_layout = "default";
export default {
  props: ['sites', 'createSiteRoute'],
  computed: {
      hasSites() {
          return (this.sites.length > 0)
      },
	  filteredSites() {
          if(this.environmentsFilter.length === 0){
              return this.sites;
          }else if(this.environmentsFilter.length > 0){
                let filteredSites = [];
                let tempSites = this.sites;
                tempSites.forEach(site => {
                    let filteredEnvs = [];
                    site.environments.forEach(environment => {
                        if(this.environmentsFilter.includes(environment.type)){
                            filteredEnvs.push(environment);
                        }

                    })
                    site.environments = filteredEnvs;
                    filteredSites.push(site)
                });                
              return filteredSites;
          }
	  }
  },
  data() {
	  return {
		  search: '', 
          showEnvironments: true,
          environmentsFilter: []
	  }
  },
  methods: {
      getClass(environmentType){
          switch (environmentType) {
              case 'PRD':
                  return 'badge badge-success'
                break;
              case 'STG':
                  return 'badge badge-warning'
                break;
              case 'DEV':
                  return 'badge badge-light'
                break;
          }
      }
  },
};
</script>