'use strict';

angular.module('itracker')
    .directive('projectTodo', [function(){
            return {
                restrict: 'C',
                scope: {
                    todos: '='
                },
                templateUrl: '/angular/proj.projectTodo'
            };
        }]);
