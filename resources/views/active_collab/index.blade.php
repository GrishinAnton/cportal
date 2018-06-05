@extends('layouts.page')

@section('content_header')
    <h1 class="h1">Выгрузка из Active Collab</h1>
@stop

@section('content')
    <div class="box">
        <div class="box-header flex flex_jc-sb">
            <h3 class="box-title">Выгрузка из Active Collab</h3>
        </div>
        <div class="box-header">
        </div>
        <div class="box-body">
            <a class="btn btn-primary" href="{{ route('web.activecollab.personal') }}" target="_blank">Персонал</a>
            <a class="btn btn-primary" href="{{ route('web.activecollab.projects') }}" target="_blank">Проекты</a>
            <a class="btn btn-primary" href="{{ route('web.activecollab.tasks') }}" target="_blank">Задачи</a>
            <a class="btn btn-primary" href="{{ route('web.activecollab.time-records') }}" target="_blank">Затреканное время</a>

            <a class="btn btn-primary" href="{{ route('web.activecollab.time-records.all') }}" target="_blank">Затреканное время (с отчисткой)</a>
        </div>
    </div>
@stop
