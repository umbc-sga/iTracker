'use strict';

angular.module('itracker')
    .directive('projectAtAGlance', [function(){
            return {
                restrict: 'C',
                scope: {
                    project: '=',
                    readMore: '='
                },
                templateUrl: '/angular/proj.projectAtAGlance'
            };
        }]);