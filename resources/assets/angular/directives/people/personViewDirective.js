'use strict';

angular.module('itracker')
    .directive('personView', ['apiService', function(apiService){
            return {
                restrict: 'C',
                scope: {
                    person: '='
                },
                templateUrl: apiService.root+'/angular/people.personView'
            };
        }]);
