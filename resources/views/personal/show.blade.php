@extends('layouts.page')

@section('title', ''.$first->first_name.' '.$first->last_name.'')

@section('content_header')
    <h1 class="h1">{{ $first->first_name }} {{ $first->last_name }}</h1>
@stop

@section('content')
@if($first->times->isNotEmpty())
    <div class="box">
        <div class="box-header flex flex_jc-sb">
            <h3 class="box-title">
                {{ $first->first_name }} {{ $first->last_name }}
            </h3>
            <div class="col-2 flex flex_jc-fe">
                <form method = "post" action = "/personal/{{ $first->pers_id }}/is-active/store">
                    {{ csrf_field() }}
                    @if ($first->is_active)
                        <button name = "is_active" value = "0" type = "submit" class = "btn btn-danger">Уволить</button>
                    @else
                        <button name = "is_active" value = "1" type = "submit" class = "btn btn-success">Восстановить</button>
                    @endif
                </form>
            </div>
        </div>
        <div class="box-body box-body_personal-select-group flex flex_jc-fs">    
            <div class="input-group mb-3 mr-4">
                <form method = "get">
                    <label for="mounth">Месяц</label>
                    <select class="custom-select" id="mounth" name="date"  onchange="this.form.submit()">
                        @foreach($dates as $key => $date)
                            <option {{ Request::get('date') == $key ? 'selected' : '' }} value = "{{ $key }}">{{ $date }}</option>
                        @endforeach
                    </select>
                </form>
            </div>

            <personal-position :personal-id = "{{ $first->pers_id }}"></personal-position>          
        </div>
        <?php
            $coefficient = isset($salary->coefficient) ? $salary->coefficient : 1.1;
        ?>
    </div>
    <div class="box">
        <table class="table table-striped">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Часы
                </h3>
            </div>
            <tbody>
                <tr>
                    <th style="width: 10px">Название задачи</th>
                    <th>Закрыто</th>
                    <th>Оценка</th>
                    <th>%</th>
                    <th>Штраф</th>
                    <th>Проект</th>
                </tr>
                @foreach($first->times as $time)
                    <?php
                        if($loop->first){
                            $close = $time->totaltime;
                            $value = $time->tasks->estimated_time;
                            $fine = 
                                $time->tasks->estimated_time > 0 ? 
                                    $time->totaltime - ($time->tasks->estimated_time * $coefficient) > 0 ? 
                                        $time->totaltime - ($time->tasks->estimated_time * $coefficient) 
                                    : 0 
                                : 0;
                        }else{
                            $close += $time->totaltime; 
                            $value += $time->tasks->estimated_time;
                            $fine += 
                                $time->tasks->estimated_time > 0 ? 
                                    $time->totaltime - ($time->tasks->estimated_time * $coefficient) > 0 ? 
                                        $time->totaltime - ($time->tasks->estimated_time * $coefficient) 
                                    : 0 
                                : 0;
                        }
                    ?>
                    <tr>
                        <td>{{ $time->tasks->name }}</td>
                        <td>{{ $time->totaltime }}</td>
                        @if($time->tasks->estimated_time != 0)
                            <td>{{ $time->tasks->estimated_time }}</td>
                        @else
                            <td style = "background:red"><a style = "color:black" href = "{{ $time->tasks->permalink }}">{{ $time->totaltime }}</a></td>
                        @endif
                        <td>
                            @if (round($time->tasks->estimated_time / $time->totaltime, 2) * 100 > 100)
                                <span class="badge badge-danger">{{ round($time->tasks->estimated_time / $time->totaltime, 2) * 100 }} %</span>
                            @else
                                <span class="badge badge-success">{{ round($time->tasks->estimated_time / $time->totaltime, 2) * 100 }} %</span>
                            @endif
                        </td>
                        
                        @if($time->tasks->estimated_time > 0)
                            <td>{{ 
                                $time->totaltime - ($time->tasks->estimated_time * $coefficient) > 0 ? 
                                    $time->totaltime - ($time->tasks->estimated_time * $coefficient) 
                                : 0 
                                }}</td>
                        @else
                            <td>0</td>
                        @endif
                        <td>{{ $time->tasks->projects->name }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan = "1">Итого:</td>
                    <td colspan = "1">{{ $close }}</td>
                    <td colspan = "1">{{ $value }}</td>
                    <td colspan = "1"><span class="badge bg-red">{{ round($value / $close, 2) * 100 }} %</span></td>
                    <td colspan = "1">{{ $fine }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>        
        
        
    <salary date = "{{ Request::filled('date') ? Request::get('date') : date('Y-m') }}" :personal-id="{{ $first->pers_id }}" penalty-time="{{ $fine }}" close-hours="{{ $close }}"></salary>

    @else
        <div class="box">
            <div class="box-header flex flex_jc-sb">
            
                <h3 class="box-title">
                    {{ $first->first_name }} {{ $first->last_name }}
                </h3>

                <div class="col-2 flex flex_jc-fe">
                    <form method = "post" action = "/personal/{{ $first->pers_id }}/is-active/store">
                        {{ csrf_field() }}
                        @if ($first->is_active)
                            <button name = "is_active" value = "0" type = "submit" class = "btn btn-danger">Деактивировать</button>
                        @else
                            <button name = "is_active" value = "1" type = "submit" class = "btn btn-success">Активировать</button>
                        @endif
                    </form>
                </div>
            </div>
            <div class="box-body box-body_personal-select-group flex flex_jc-fs">    
                <div class="input-group mb-3 mr-4">
                    <form method = "get">
                        <label for="mounth">Месяц</label>
                        <select class="custom-select" id="mounth" name="date"  onchange="this.form.submit()">
                            @foreach($dates as $key => $date)
                                    <option {{ Request::get('date') == $key ? 'selected' : '' }} value = "{{ $key }}">{{ $date }}</option>
                                @endforeach
                        </select>
                    </form>
                </div>

                <personal-position :personal-id = "{{ $first->pers_id }}"></personal-position>          
            </div>
        </div>

        <salary date="{{ Request::filled('date') ? Request::get('date') : date('Y-m') }}" :personal-id="{{ $first->pers_id }}" penalty-time="0" close-hours="0" :no-costs="false"></salary>
    @endif
@stop
