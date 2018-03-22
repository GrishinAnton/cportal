@extends('layouts.page')

@section('title', 'Издержки')

@section('content_header')
    <h1>Издержки</h1>
@stop

@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">
            Издержки
        </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th></th>
                    @foreach($costs as $cost)
                        <th>{{ $cost->rus_date }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Издержки</td>
                    @foreach($costs as $cost)
                        <td>
                            <form method = "post">
                                {{ csrf_field() }}  
                                {{ method_field('PUT') }}
                                <center>
                                    <p><input class="form-control" style = "width:70px;" value = "{{ $cost->cost }}" name = "cost" type = "text"></p>
                                    <p><button type = "submit" name = "date" value = "{{ $cost->rus_date }}" class = "btn btn-primary">Изменить</button></p>
                                </center>
                            </form>
                        </td>
                    @endforeach    
                </tr>
            </tbody>
        </table>
    </div>
@stop
