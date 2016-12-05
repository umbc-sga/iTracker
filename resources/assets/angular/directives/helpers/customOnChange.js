'use strict';

angular.module('itracker')
    .directive('customOnChange', [function() {
        return {
            restrict: 'A',
            link: function (scope, element, attrs) {
                let onChangeHandler = scope.$eval(attrs.customOnChange);
                element.bind('change', onChangeHandler);
            }
        };
    }]);