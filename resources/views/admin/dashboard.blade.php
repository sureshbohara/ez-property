@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<main class="page-content">
    <x-breadcrumb :title="'Dashboard'" :subTitle="'Admin Dashboard'" :breadcrumbItems="['Home', 'Main']" />
    @include('partials.admin.analytics')
    @include('partials.admin.second_section')

</main>
@endsection
