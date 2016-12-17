'use strict';

angular.module('itracker')
    .directive('loader', [function(){
        return {
            restrict: 'C',
            template: `<div class="loading"></div>`
        }
    }]);