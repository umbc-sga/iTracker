'use strict';

angular.module('itracker')
    .directive('allDepartments', ['apiService', function(apiService){
            return {
                restrict: 'C',
                scope: {
                    departments: '='
                },
                templateUrl: apiService.root+'/angular/dept.allDepartments'
            };
        }]);
