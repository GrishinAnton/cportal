@extends('layouts.page')

@section('content_header')
    <h1 class="h1">Сотрудники</h1>
@stop

@section('content')
<div class="box">
    <div class="box-header">
        <h3 class="box-title">Список сотрудников</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table class="table table-hover table-bordered">
            <tbody>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Имя Фамилия</th>
                    <th>E-mail</th>
                    <th>Коэффициент</th>
                    <th>Закрыто часов</th>
                    <th>Штрафы</th>
                    <th>ЗП</th>
                    <th></th>
                </tr>
                @foreach($personal as $person)
                    <?php
                        $salary = $person->salary->first();
                        $fine = $person->times->sum('totaltime') - ($person->tasks->sum('estimated_time') * (isset($salary->coefficient) ? $salary->coefficient : 1.1));
                    ?>  
                    <tr>
                        <td>{{ $person->pers_id }}</td>
                        <td><a href = "/personal/{{ $person->pers_id }}">{{ $person->first_name }} {{ $person->last_name }}</a></td>
                        <td>{{ $person->email }}</td>
                        <td>{{ isset($salary->coefficient) ? $salary->coefficient : 1.1 }}</td>
                        <td>{{ $person->times->sum('totaltime') }}</td>
                        <td>
                             {{ $fine < 0 ? 0 : $fine }}
                        </td>
                        
                        @if ($salary)
                            <td>{{ $salary->edit_salary ? $salary->edit_salary : $salary->salary }}</td>
                        @else
                            <td>0</td>
                        @endif
                        <td>
                            <div class = "text-center">
                                <a href = "/personal/{{ $person->pers_id }}"><i class="fa fa-user-o"></i></a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        {{ $personal->links()  }}
    </div>
</div>
@stop
