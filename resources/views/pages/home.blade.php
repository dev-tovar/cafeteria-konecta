@extends('../layout')
@section('components_page')
@include('../pages.includes.menu')
@include('../pages.includes.bar')
<v-main class="pb-0" style="background: #f3f3f3;">
    <router-view></router-view>
</v-main>
@endsection