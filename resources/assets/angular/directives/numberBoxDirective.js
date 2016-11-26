'use strict';

angular.module('itracker')
    .directive('numberBox', [
        function(){
        return {
            restrict: 'C',
            scope: {
                title: '@',
                color: '@',
                url: '@',
                icon: '@',
                str: '@',
                description: '@'
            },
            templateUrl: '/angular/numberBox'
        };
    }]);
