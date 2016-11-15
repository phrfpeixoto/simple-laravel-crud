@extends('template')
@section('content')

    <div ng-app="stateCrudApp" ng-controller="userAuthController">

        <div id="loading" ng-if="!usersLoaded" class="row text-center">
            <div class="col-sm-12">
                <div><i class="fa fa-3x fa-refresh fa-spin"></i></div>
                <h2>{{trans('Loading Users')}}</h2>
            </div>
        </div>

        <div ng-if="usersLoaded">
            <div class="row">
                <div class="col-sm-12">
                    <h1>{{trans('System Users')}}</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <table class="table">
                        <thead>
                            <th>{{trans('User Name')}}</th>
                            <th>{{trans('E-Mail')}}</th>
                            <th>{{trans('Can Manage States')}}</th>
                            <th colspan="2">{{trans('Can Audit Logs')}}</th>
                        </thead>
                        <tbody>
                            <tr ng-repeat="user in users">
                                <td><% user.name %></td>
                                <td><% user.email %></td>
                                <td><input type="checkbox" ng-checked="can(user.id, 'manage-states')" ng-click="setPermission(user.id, 'manage-states', $event)"></td>
                                <td><input type="checkbox" ng-checked="can(user.id, 'audit')" ng-click="setPermission(user.id, 'audit', $event)"></td>
                                <td class="text-right">
                                    <button type="button" class="btn btn-link" ng-click="deleteUser(user.id)" title="{{trans('Delete')}}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @stop
    </div>
@section('javascripts')
    <script src="{{asset('js/user.index.js')}}"></script>
@stop