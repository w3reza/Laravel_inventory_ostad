@extends('backend.layout.sidenav-layout')
@section('page_title', 'Product List')
@section('content')
    @include('backend.components.product.product_list')
    @include('backend.components.product.product_delete')
    @include('backend.components.product.product_create')
    @include('backend.components.product.product_update')
@endsection
