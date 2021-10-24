<x-app-layout>
    <div id="sitesApp">
        <sites :sites='@json($sites)' :groups='@json($groups)' create-site-route="{{route('sites.create')}}"></sites>
    </div>
</x-app-layout>
