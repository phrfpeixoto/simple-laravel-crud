@extends('template')
@section('content')

    <div class="row">
        <div class="col-sm-12">
            <h2>{{trans('General Logs')}}</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="text-right">
                <a href="{{route('home')}}" class="btn btn-link"><i class="fa fa-backward"></i> {{trans('State List')}}</a>
            </div>
            <table class="table">
                <thead>
                    <th>{{trans('Date')}}</th>
                    <th>{{trans('Record')}}</th>
                </thead>
                <tbody>
                    @foreach($records as $record)
                    <tr>
                        <td>{{$record->created_at}}</td>
                        <td>{{$record->entry}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop