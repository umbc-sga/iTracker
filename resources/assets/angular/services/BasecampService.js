'use strict';

angular.module('itracker')
    .factory('basecampService', ['$q', '$http', function($q, $http) {
        let _apiVer = '/api/v1/';

        /**
         * Handles request and returns promise
         * @param resource URI Resource to access
         * @param method Method to access resource with
         * @param data Data object to pass to API
         * @returns {Promise}
         */
        let request = (resource = '', method = 'POST', data = {}) => {
            return $q((resolve, reject) => {
                $http({
                    method: method,
                    url: (_apiVer+resource).replace(/\/\//g, '/'),
                    data: data
                }).then((response) => resolve(response), (response) => reject(response));
            });
        };

        return {
            groups: () => {},
            people: () => {},
            projects: () => {},
            getProjects: () => request('/projects', 'POST'),
            getProjectAccesses: (projectId) => request('/project/'+projectId+'/accesses'),
            getProject: (projectId) => request('/project/'+projectId, 'POST'),
            getPeople: () => request('/people', 'POST'),
            getPerson: (personId) => request('/person/'+personId, 'POST'),
            getPersonProjects: (personId) => request('/person/'+personId+'/projects', 'POST'),
            getPersonInfo: (personId) => request('/person/'+personId+'/info', 'POST'),
            getPersonRoles: (personId) => request('/person/'+personId+'/roles', 'POST'),
            getPersonDepartments: (personId) => request('/person/'+personId+'/departments', 'POST'),
            getPersonEvents: (personId, page) => request('/person/'+personId+'/events/'+page, 'POST'),
            getGroups: () => request('/groups', 'POST'),
            getGroup: (groupdId) => request('/group/'+groupdId, 'POST'),
            getDepartment: (deptId) => request('/dept/'+deptId),
            getDepartmentPersonWithRole: (roleId, deptId) => request('/dept/'+deptId+'/role/'+roleId),
            getDepartmentProjects: (deptId) => request('/dept/'+deptId+'/projects'),
            getActiveTodos: () => request('/todos/active'),
            getCompletedTodos: () => request('/todos/completed'),
            getRole: (roleId) => request('/role/'+roleId),

            changeRole: (person, dept, role) => request('/dept/'+dept+'/person/'+person+'/role/'+role, 'PUT')
        };
    }]);