@extends('backend.layout.sidenav-layout')
@section('title', 'Profile' .  (Auth::user() ? ' - ' . Auth::user()->firstName : ' [User not authenticated]'))
@section('content')
    @include('backend.components.dashboard.profile_form')
@endsection

