@extends('backend.layout.sidenav-layout')
@section('page_title', 'Customer List')
@section('content')
    @include('backend.components.customer.customer_list')
    @include('backend.components.customer.customer_delete')
    @include('backend.components.customer.customer_create')
    @include('backend.components.customer.customer_update')
@endsection
