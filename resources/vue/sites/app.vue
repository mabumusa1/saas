<template>
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
                <template v-for="site in sites">
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
            </tbody>
        </table>  
    </div>
</template>


<script>
const default_layout = "default";
export default {
  props: ['sitesRoute'],
  computed: {},
  data() {
      return {
          sites:null
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
  mounted() {
    axios.get(this.sitesRoute, {headers: {'vue-app': 'true'}}).then(response => this.sites = response.data)
  }
};
</script>