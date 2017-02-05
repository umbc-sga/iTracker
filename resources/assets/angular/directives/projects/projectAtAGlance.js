'use strict';

angular.module('itracker')
    .directive('projectAtAGlance', ['apiService', function(apiService){
            return {
                restrict: 'C',
                scope: {
                    project: '=',
                    readMore: '='
                },
                templateUrl: apiService.root+'/angular/proj.projectAtAGlance'
            };
        }]);