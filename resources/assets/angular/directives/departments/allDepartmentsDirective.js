'use strict';

angular.module('itracker')
    .directive('allDepartments', [function(){
            return {
                restrict: 'C',
                scope: {
                    departments: '='
                },
                templateUrl: '/angular/dept.allDepartments'
            };
        }]);
