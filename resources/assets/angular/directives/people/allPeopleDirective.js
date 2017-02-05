'use strict';

angular.module('itracker')
    .directive('allPeople', ['apiService', function(apiService){
            return {
                restrict: 'C',
                scope: {
                    people: '='
                },
                templateUrl: apiService.root+'/angular/people.allPeople'
            };
        }]);
