@extends('backend.layout.sidenav-layout')
@section('page_title', 'Category List')
@section('content')
    @include('backend.components.category.category_list')
    @include('backend.components.category.category_delete')
    @include('backend.components.category.category_create')
    @include('backend.components.category.category_update')
@endsection
