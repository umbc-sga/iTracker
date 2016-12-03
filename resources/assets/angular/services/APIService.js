'use strict';

angular.module('itracker')
    .factory('apiService', ['$q', '$log', '$http', function($q, $log, $http) {
        let _apiVer = '/api/v1/';

        /**
         * Handles request and returns promise
         * @param resource URI Resource to access
         * @param method Method to access resource with
         * @param data Data object to pass to API
         * @returns {Promise}
         */
        let request = (resource = '', method = 'POST', data = {}) => {
            return $http({
                method: method,
                url: (_apiVer + resource).replace(/\/\//g, '/'),
                data: data
            });
        };

        return {
            request: request
        };
    }]);