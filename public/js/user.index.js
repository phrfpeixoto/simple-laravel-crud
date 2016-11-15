"use strict";

(function(angular) {
    var app = angular.module('stateCrudApp', [], function($interpolateProvider){
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');

    });

    app.controller('userAuthController', ['$scope', '$http', function ($scope, $http) {

        $scope.users = [];
        $scope.usersLoaded = false;

        $scope.can = function(user_id, permission){
            var user_permissions = $scope.users[user_id]['permissions'],
                adminPermission = _.findWhere(user_permissions, {permission: 'admin'}),
                foundPermission = _.findWhere(user_permissions, {permission: permission});

            if(adminPermission && adminPermission['permission'] == 'admin'){
                return true;
            }
            else if(foundPermission && foundPermission['permission'] == permission){
                return true;
            }
            return false;
        };

        $scope.deleteUser = function(user_id){
            var state = $scope.states[user_id];
            $http.delete('/api/user/' + state.id).then(
                function success(response){
                    if(response.statusText != "OK") {
                        console.error(response);
                        return
                    }
                    delete $scope.users[user_id];
                }, function error(response){
                    console.error(response);
                }
            );
        };

        $scope.setPermission = function(user_id, permission, $event){
            $event.preventDefault();
            var promise = null

            if($scope.can(user_id, permission)){
                promise = $scope.unauthorize(user_id, permission);
            }
            else{
                promise = $scope.authorize(user_id, permission);
            }

            promise.then(
                function success(response){
                    if(response.statusText != "OK") {
                        console.error("Error changing user permissions");
                        console.error(response);
                        return;
                    }

                    $scope.users[user_id] = response.data.user;
                    $event.target.checked = $scope.can(user_id, permission);
                },
                function error(response){
                    console.error("Error changing user permissions");
                    console.error(response);
                }
            );
        };

        $scope.authorize = function(user_id, permission){
            return $http.patch('/api/user/authorize/' + user_id, {'permission': permission});
        };

        $scope.unauthorize = function(user_id, permission){
            return $http.patch('/api/user/unauthorize/' + user_id, {'permission': permission});
        };

        $http.get('/api/user').then(
            function success(response){
                if(response.statusText != "OK") {
                    console.error("Error fetching users from database. Reloading.", response);
                    window.location.reload();
                }

                $scope.users = _.indexBy(response.data.users, 'id');
                $scope.usersLoaded = true;
            },
            function error(response){
                console.error("Error fetching users from database. Reloading.", response);
                window.location.reload();
            }
        );
    }]);
})(window.angular);
