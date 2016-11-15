"use strict";

(function(angular) {
    var app = angular.module('stateCrudApp', [], function($interpolateProvider){
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');

    });

    app.controller('stateCrudController', ['$scope', '$http', function ($scope, $http) {

        $scope.states = [];
        $scope.statesLoaded = false;

        $scope.stateID = 0;
        $scope.state = {
            'name':  '',
            'short_name': ''
        };

        $scope.cancelButton = function(){
            $scope.stateID = 0;
            $scope.state.name = null;
            $scope.state.short_name = null;
        };

        $scope.okButton = function(){
            if($scope.stateID != 0){
                $scope.updateState();
            }
            else{
                $scope.storeState();
            }
        };

        $scope.editState = function(state_id){
            var state = $scope.states[state_id];
            $scope.stateID = state.id;
            $scope.state.name = state.name;
            $scope.state.short_name = state.short_name;
        };

        $scope.deleteState = function(state_id){
            var state = $scope.states[state_id];
            $http.delete('/api/state/' + state.id).then(
                function success(response){
                    if(response.statusText != "OK") {
                        console.error(response);
                        return
                    }
                    delete $scope.states[state_id];
                }, function error(response){
                    console.error(response);
                }
            );
        };

        $scope.updateState = function(){
            if($scope.stateID == 0){
                console.error('Cannot update state. No edition is in place');
            }

            $http.patch('/api/state/' + $scope.stateID, {
                'name': $scope.state.name,
                'short_name': $scope.state.short_name
            }).then(
                function success(response){
                    if(response.statusText != "OK") {
                        console.error(response);
                        return
                    }

                    console.log(response);

                    var state = response.data.state;
                    $scope.states[state.id] = state;

                    $scope.cancelButton();

                }, function error(response){
                    console.error(response);
                }
            );
        };

        $scope.storeState = function(){
            $http.post('/api/state', {
                'name': $scope.state.name,
                'short_name': $scope.state.short_name
            }).then(
                function success(response){
                    if(response.statusText != "OK") {
                        console.error(response);
                        return
                    }

                    var state = response.data.state;
                    $scope.states[state.id] = state;

                    $scope.cancelButton();

                }, function error(response){
                    console.error(response);
                }
            );
        };

        $http.get('/api/state').then(
            function success(response){
                if(response.statusText != "OK") {
                    console.error("Error fetching states from database. Reloading.", response);
                    window.location.reload();
                }

                $scope.states = _.indexBy(response.data.states, 'id');
                $scope.statesLoaded = true;
            },
            function error(response){
                console.error("Error fetching states from database. Reloading.", response);
                window.location.reload();
            }
        );
    }]);
})(window.angular);
