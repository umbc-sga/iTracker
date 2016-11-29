'use strict';

angular.module('itracker')
    .directive('projectAtAGlance', [function(){
            return {
                restrict: 'C',
                scope: {
                    project: '='
                },
                templateUrl: '/angular/projectAtAGlance'
            };
        }]);