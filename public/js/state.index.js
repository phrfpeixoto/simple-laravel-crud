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

        // $scope.samples = [ { "lithology": { "value": "CLAYSTONE", "label": "Argilito", "order": 1, "acr": "AGT", "$order": 2, "name": "Litologia" }, "percentage": { "value": "P40", "label": "40%", "order": 6, "int_value": 40, "acr": "40%", "$order": 7, "name": "Percentual" }, "color": { "value": "BROWN", "label": "Marrom", "order": 4, "acr": "MAR", "name": "Cor" }, "tint": { "value": "REDISH", "label": "Avermelhado", "order": 6, "acr": "AVM", "name": "Tonalidade" }, "structure": { "value": "BIOTURBATED", "label": "Bioturbado", "order": 3, "acr": "BTB", "name": "Estrutura" }, "main_composition": { "value": "BIOCLASTIC", "label": "Bioclástico", "order": 4, "acr": "BIO", "name": "Composição Principal" }, "sec_composition": { "value": "BITUMINOUS", "label": "Betuminoso", "order": 3, "acr": "BET", "name": "Composição Secundária" } }, { "lithology": { "value": "SHALE", "label": "Folhelho", "order": 2, "acr": "FLH", "$order": 3, "name": "Litologia" }, "percentage": { "value": "P40", "label": "40%", "order": 6, "int_value": 40, "acr": "40%", "$order": 7, "name": "Percentual" }, "color": { "value": "BROWN", "label": "Marrom", "order": 4, "acr": "MAR", "name": "Cor" }, "tint": { "value": "YELLOWISH", "label": "Amarelado", "order": 4, "acr": "AMR", "name": "Tonalidade" }, "structure": { "value": "RECRYSTALIZED", "label": "Recristalizado", "order": 6, "acr": "RCR", "name": "Estrutura" }, "cohesion": { "value": "SEMIHARD", "label": "Semiduro", "order": 6, "acr": "SDR", "$order": 3, "name": "Coesão" }, "main_composition": { "value": "CLAYEY", "label": "Argiloso", "order": 2, "acr": "ARG", "name": "Composição Principal" }, "sec_composition": { "value": "METAMFRAGMENTS", "label": "Frag. de Metarmórficas", "order": 14, "acr": "FMT", "name": "Composição Secundária" } }, { "lithology": { "value": "SILTSTONE", "label": "Siltito", "order": 3, "acr": "SLT", "$order": 4, "name": "Litologia" }, "percentage": { "value": "P20", "label": "20%", "order": 4, "int_value": 20, "acr": "20%", "$order": 5, "name": "Percentual" } } ];
        // $scope.parameters = {};
        // $scope.filteredParameters = {};
        // $scope.parametersLoaded = false;
        // $scope.descriptionInput = {};
        // $scope.noReturnInterval = false;
        // $scope.validSample = false;
        // $scope.validSampleSet = false;
        // $scope.editingSample = null;
        //
        // $scope.config = {
        //     create: false,
        //     valueField: 'value',
        //     labelField: 'label',
        //     sortField: 'order',
        //     delimiter: '|',
        //     dropdownParent: 'body',
        //     maxItems: 1,
        //     closeAfterSelect: true,
        //     allowEmptyOption: true,
        //     searchField: ['value', 'label']
        // };
        //
        // $scope.getUsedLitho = function(){
        //     return _.map($scope.samples, function(s){
        //
        //         var litho = s.lithology.value, editingLitho = null;
        //
        //         if($scope.editingSample != null){
        //             editingLitho = $scope.samples[$scope.editingSample]['lithology'].value;
        //
        //             if(editingLitho == litho){
        //                 litho = null
        //             }
        //         }
        //
        //         return litho;
        //     });
        // };
        //
        // $scope.getUsedPercentage = function(){
        //     var sum = sumPercentage($scope.samples);
        //
        //     if($scope.editingSample != null){
        //         sum -= $scope.samples[$scope.editingSample]['percentage']['int_value'];
        //     }
        //
        //     return sum;
        // };
        //
        // $scope.getAvailableLithologyValues = function(){
        //     if(!$scope.parametersLoaded){
        //         return [];
        //     }
        //
        //     var usedLitho = $scope.getUsedLitho();
        //
        //     return _.filter($scope.parameters.lithology.values, function(v){
        //         return !_.contains(usedLitho, v.value);
        //     });
        // };
        //
        // $scope.getAvailablePercentageValues = function(){
        //     if(!$scope.parametersLoaded){
        //         return [];
        //     }
        //
        //     var sum = $scope.getUsedPercentage();
        //
        //     return _.filter($scope.parameters.percentage.values, function(v){
        //         return v.int_value + sum <= 100;
        //     });
        // };
        //
        // $scope.filterSelectizeOptions = function(rule, callback){
        //     var filtered = {};
        //
        //     //Filter the majority of parameters
        //     _.each($scope.parameters, function(param_data, parameter){
        //         filtered[parameter] = angular.copy(param_data);
        //
        //         if(!rule.parameters.hasOwnProperty(parameter)){
        //             return;
        //         }
        //
        //         var accepted_values = rule.parameters[parameter], values = [];
        //
        //         if(!accepted_values.length){
        //             filtered[parameter].values = [];
        //         }
        //         else{
        //             values = _.filter(param_data.values, function(v){
        //                 return _.contains(accepted_values, v.value);
        //             });
        //             filtered[parameter].values = values;
        //         }
        //     });
        //
        //     //Filter the main parameters: Lithology and Percentage. This happens accordingly with described samples
        //     filtered['lithology'].values = $scope.getAvailableLithologyValues();
        //     filtered['percentage'].values = $scope.getAvailablePercentageValues();
        //
        //     $scope.filteredParameters = filtered;
        //
        //     if(callback && typeof callback === 'function'){
        //         callback();
        //     }
        // };
        //
        // $scope.showAvailableLithologies = function(){
        //     return _.map($scope.getAvailableLithologyValues(), function(i){
        //         return i.value
        //     });
        // };
        //
        // $scope.showAvailablePercentage = function(){
        //     return _.map($scope.getAvailablePercentageValues(), function(i){
        //         return i.value
        //     });
        // };
        //
        // $scope.selectizeValueChanged = function(parameter){
        //     var value = $scope.descriptionInput[parameter] || '',
        //         rule = RuleSet.for(value);
        //
        //     if(parameter === 'lithology'){
        //         $scope.filterSelectizeOptions(rule);
        //     }
        //
        //     $scope.validateInputs();
        // };
        //
        // $scope.validateInputs = function(){
        //     $scope.validSample = $scope.descriptionInput['lithology'] && $scope.descriptionInput['percentage'];
        // };
        //
        // $scope.addSample = function(){
        //     var sample = {};
        //     _.each($scope.parameters, function(parameter_obj, parameter_name){
        //         parameter_obj = angular.copy(parameter_obj);
        //         var value = $scope.descriptionInput[parameter_name];
        //
        //         sample[parameter_name] = _.findWhere(parameter_obj.values, {value: value});
        //         if(sample[parameter_name]){
        //             sample[parameter_name]['name'] = parameter_obj.name;
        //         }
        //     });
        //
        //     $scope.samples.push(sample);
        //
        //     $scope.clearSample();
        //
        //     $scope.validSampleSet = false;
        //     if($scope.getUsedPercentage() == 100){
        //         $scope.validSampleSet = true;
        //     }
        // };
        //
        // $scope.editSample = function(sample_id){
        //     $scope.editingSample = sample_id;
        //
        //     var sample = $scope.samples[sample_id];
        //     sample.showPopover = false;
        //
        //     console.log(sample);
        //
        //     $scope.filterSelectizeOptions(RuleSet.for(sample['lithology'].value), function(){
        //         _.each(sample, function(value, parameter){
        //             if(value){
        //                 $scope.descriptionInput[parameter] = value.value;
        //             }
        //         });
        //
        //         $scope.validateInputs();
        //     });
        // };
        //
        // $scope.clearSample = function(){
        //     $scope.editingSample = null;
        //     $scope.descriptionInput = {};
        //
        //     _.each(angular.element("selectize.parameter-input"), function(each){
        //         $(each)[0].selectize.setValue(null);
        //     });
        //
        //
        // };
        //
        // $scope.deleteSample = function(sample_id){
        //     if(!Number.isInteger(sample_id)){
        //         sample_id = $scope.editingSample;
        //     }
        //
        //     if(sample_id != null && sample_id in $scope.samples){
        //         $scope.samples.splice(sample_id, 1);
        //         $scope.clearSample();
        //         return
        //     }
        //     $scope.alertModal("Delete Sample Error", "Error deleting sample: No edition is in place");
        // };
        //
        // $scope.updateSample = function(){
        //     var sample = {};
        //     _.each($scope.parameters, function(parameter_obj, parameter_name){
        //         parameter_obj = angular.copy(parameter_obj);
        //         var value = $scope.descriptionInput[parameter_name];
        //
        //         sample[parameter_name] = _.findWhere(parameter_obj.values, {value: value});
        //         if(sample[parameter_name]){
        //             sample[parameter_name]['name'] = parameter_obj.name;
        //         }
        //     });
        //
        //     console.log(sample);
        //
        //     $scope.samples[$scope.editingSample] = sample;
        //
        //     console.log($scope.samples);
        //
        //     $scope.clearSample();
        // };
        //
        // $scope.alertModal = function(title, message) {
        //     $uibModal.open({
        //         controller: 'ModalInstanceCtrl',
        //         controllerAs: '$ctrl',
        //         templateUrl: 'alert_modal.html',
        //         resolve: {
        //             modalTitle: function(){ return title; },
        //             modalMessage: function(){ return message; }
        //         }
        //     });
        // };
        //
        // $scope.showPopover = function(sample){
        //     sample.showPopover = true;
        // };
        //
        // $scope.calculatePercentage = function(value){
        //     var traces_progress_percentage = 4
        //     if(value == 0){
        //         return traces_progress_percentage
        //     }
        //
        //     var remaining = 100 - (noTracesFilter($scope.samples, true).length * traces_progress_percentage);
        //
        //     value = (value * remaining) / 100;
        //
        //     return value;
        // };

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
