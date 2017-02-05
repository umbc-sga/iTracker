'use strict';

angular.module('itracker')
    .directive('projectTodo', ['apiService', function(apiService){
            return {
                restrict: 'C',
                scope: {
                    todos: '='
                },
                templateUrl: apiService.root+'/angular/proj.projectTodo'
            };
        }]);
