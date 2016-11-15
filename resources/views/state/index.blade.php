@extends('template')
@section('content')

<div ng-app="stateCrudApp" ng-controller="stateCrudController">

    <div id="loading" ng-if="!statesLoaded" class="row text-center">
        <div class="col-sm-12">
            <div><i class="fa fa-3x fa-refresh fa-spin"></i></div>
            <h2>{{trans('Loading Brazilian States')}}</h2>
        </div>
    </div>

    <div ng-if="statesLoaded">
        <div class="row">
            <div class="col-sm-12">
                <h1>{{trans('Brazilian States')}}</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">

                <table class="table">
                    <thead>
                        <th>{{trans('Short Name')}}</th>
                        <th colspan="2">{{trans('Name')}}</th>

                    </thead>
                    <tbody>
                        <tr ng-repeat="state in states" ng-class="{'bg-info': stateID == state.id}">
                            <td><% state.short_name %></td>
                            <td><% state.name %></td>
                            <td class="text-right">
                                <div class="btn-group" role="group">
                                    @can('manage', App\State::class)
                                    <button type="button" class="btn btn-link" ng-click="editState(state.id)" title="{{trans('Edit')}}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-link" ng-click="deleteState(state.id)" title="{{trans('Delete')}}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    @endcan
                                    @can('audit', App\State::class)
                                    <a href="/state/<% state.id %>" class="btn btn-link" title="{{trans('Logs')}}">
                                        <i class="fa fa-database"></i>
                                    </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @can('manage', App\State::class)
        <div class="row">
            <div class="col-sm-12">
                <form class="form-inline">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="{{trans('Name')}}" ng-model="state.name" />
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="{{trans('Short Name')}}" ng-model="state.short_name" />
                    </div>
                    <button class="btn btn-danger" ng-click="cancelButton()">{{trans('Cancel')}}</button>
                    <button type="button" ng-click="okButton(state_name)" class="btn btn-primary">{{trans('OK')}}</button>
                </form>
            </div>
        </div>
        @endcan
    </div>
    @stop
</div>
@section('javascripts')
<script src="{{asset('js/state.index.js')}}"></script>
@stop