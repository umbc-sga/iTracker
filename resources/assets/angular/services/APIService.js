'use strict';

angular.module('itracker')
    .factory('apiService', ['$q', '$log', '$http', function($q, $log, $http) {
        let _base = document
            .getElementsByTagName('base')[0]
            .getAttribute('href')
            .replace(new RegExp(`^https?:\/\/${location.host}`),'');

        let _apiVer = _base.replace(/\/+$/,'')+'/api/v1/';

        /**
         * Handles request and returns promise
         * @param resource URI Resource to access
         * @param method Method to access resource with
         * @param data Data object to pass to API
         * @param headers object Headers to use with request
         * @returns {Promise}
         */
        let request = (resource = '', method = 'POST', data = {}, headers = null) => {
            return $http({
                method: method,
                url: (_apiVer + resource).replace(/\/\//g, '/'),
                data: data,
                headers: headers ? headers : {
                    'Content-Type': 'application/json'
                }
            });
        };

        return {
            request: request,
            root: _base
        };
    }]);