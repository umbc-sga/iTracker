angular.module('itracker')
    .filter('departmentHref', function() {
        return function(input) {
            return (!!input) ? input.toLowerCase().replace(/\s+/g, '-').replace(/&/g, 'and') : '';
        }
    });