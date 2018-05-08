@extends('layouts.page')

@section('title', 'Проекты')

@section('content_header')
    <h1>Проекты</h1>
@stop

@section('content')
<div class="box">
    <div class="box-header">
        <h3 class="box-title">Список проектов</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table class="table table-hover table-bordered">
            <tbody>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Название</th>
                    <th>Бюджет</th>
                    <th>Затраты</th>
                    <th>Часы</th>
                    <th>Всего затрат</th>
                    <th>Всего часов</th>
                    <th>Остаток</th>
                    <th>Средняя стоимость часа</th>
                </tr>
                @foreach($projects as $project)
                    <?php 
                        $balance = $project->budget - $project->fullInfoCosts->sum('project_cost');
                    ?>
                    <tr>
                        <td>{{ $project->project_id }}</td>
                        <td><a href = "/projects/{{ $project->project_id }}">{{ $project->name }}</a></td>
                        <td>{{ $project->budget }}</td>
                        <td>{{ $project->costs->sum('project_cost') }}</td>
                        <td>{{ $project->costs->sum('hours') }}</td>
                        <td>{{ $project->fullInfoCosts->sum('project_cost') }}</td>
                        <td>{{ $project->fullInfoCosts->sum('hours') }}</td>
                        <td>{{ $balance }}</td>
                        @if ($project->fullInfoCosts->sum('hours'))
                            <td>{{ $balance / $project->fullInfoCosts->sum('hours') }}</td>
                        @else
                            <td>{{ $balance }}</td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.box-body -->
    <div class="box-footer clearfix">
        <div class="pagination pagination-sm no-margin pull-right">
            {{ $projects->links()  }}
        </div>
    </div>
</div>
@stop