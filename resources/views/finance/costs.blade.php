@extends('layouts.page')

@section('content_header')
    <h1 class="h1">Издержки</h1>
@stop

@section('content')
    <costs date="{{ date('Y') }}"></costs>
@stop
