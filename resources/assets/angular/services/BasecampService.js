'use strict';

angular.module('itracker')
    .factory('basecampService', ['$q', '$log', '$http', 'apiService', function($q, $log, $http, apiService) {
        /**
         * Handles request and returns promise
         * @param resource URI Resource to access
         * @param method Method to access resource with
         * @param data Data object to pass to API
         * @returns {Promise}
         */
        let request = (resource = '', method = 'POST', data = {}) => {
            return $q((resolve, reject) => {
                apiService.request(resource, method, data)
                    .then((response) => resolve(response), (response) => {
                        if (response.status == 429) {
                            $log.debug('Rate limited, retrying in 10 seconds', response);
                            return setTimeout(() => resolve(request(resource, method, data)), 10*1000);
                        }

                        reject(response);
                    })
            });
        };

        return {
            getProjects: () => request('/projects'),
            getPeopleInProject: (projectId) => request('/project/'+projectId+'/people'),
            getProjectTodos: (projectId) => request('/project/'+projectId+'/todos'),
            getProjectHistory: (projectId) => request('/project/'+projectId+'/history'),
            getProjectEvents: (projectId, page) => request('/project/'+projectId+'/events/'+page),
            getProject: (projectId) => request('/project/'+projectId),

            getPeople: () => request('/people'),
            getPerson: (personId) => request('/person/'+personId),
            getPersonProjects: (personId) => request('/person/'+personId+'/projects', ),
            getPersonProfile: (personId) => request('/person/'+personId+'/profile'),
            getPersonRoles: (personId) => request('/person/'+personId+'/roles'),
            getPersonDepartments: (personId) => request('/person/'+personId+'/departments'),
            getPersonEvents: (personId, page) => request('/person/'+personId+'/events/'+page),

            getGroups: () => request('/groups'),
            getGroup: (groupdId) => request('/group/'+groupdId),
            getDepartment: (deptName) => request('/dept/'+deptName),
            getDepartmentPersonWithRole: (roleId, deptId) => request('/dept/'+deptId+'/role/'+roleId),
            getDepartmentProjects: (deptId) => request('/dept/'+deptId+'/projects'),

            getRole: (roleId) => request('/role/'+roleId),
            changeRole: (person, dept, role) => request('/dept/'+dept+'/person/'+person+'/role/'+role, 'PUT')
        };
    }]);