@extends('layouts.page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="h1">Проект</h1>
@stop

@section('content')
@if($dates->isNotEmpty())
<div class="box">
<div class="box-header with-border">
    <h3 class="box-title">
        {{ $project->name }}
    </h3>
    <div class = "pull-left"> 
        <form method = "post">
            
        </form>
    </div>
</div>
<!-- /.box-header -->
<div class="box-body">  
    <form method = "get">
        <select style = "margin-bottom: 5px" name="date" onchange="this.form.submit()">
            @foreach($dates as $date)
                @if(Request::filled('date'))
                    @if(Request::get('date') == $date->year_month)
                        <option selected value = "{{ $date->year_month }}">{{ $date->rus_date }}</option>
                    @else
                        <option value = "{{ $date->year_month }}">{{ $date->rus_date }}</option>
                    @endif
                @else
                    @if(date('Y-m') == $date->year_month)
                        <option selected value = "{{ $date->year_month }}">{{ $date->rus_date }}</option>
                    @else
                        <option value = "{{ $date->year_month }}">{{ $date->rus_date }}</option>
                    @endif
                @endif
            @endforeach
        </select>
    </form>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Списано</th>
                <th>Имя Фамилия сотрудника</th>
            </tr>
        </thead>
        <tbody>
            @foreach($project->costs as $cost)
                <?php
                    if ($loop->first) {
                        $money = $cost->project_cost;
                    } else {
                        $money += $cost->project_cost;
                    }
                ?>
                <tr>
                    <td>{{ $cost->id }}</td>
                    <td>{{ $cost->project_cost }}</td>
                    <td>{{ $cost->pers->first_name }} {{ $cost->pers->last_name }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan = "1">Итого:</td>
                <td colspan = "1">{{ $money }}</td>
            </tr>
        </tbody>
    </table>
</div>
@else
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">
                {{ $project->name }}
            </h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">  
            <h2>Списаний по проекту <b>{{ $project->name }}</b> не было</h2>
        </div>

    </div>

@endif
@stop
