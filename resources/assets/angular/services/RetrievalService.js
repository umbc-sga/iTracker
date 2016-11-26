angular.module('itracker')
    .service('retrievalService', ['$q', 'basecampService', function($q, basecampService) {
        this.getPeople = () => {
            return basecampService.getPeople()
                .catch((err) => $log.error('Error while getting projects', err));
        };

        this.getPersonInfo = function(personID) {
            return basecampService.getPersonInfo(personID)
                .catch((err) => $log.error('Error while getting person', personID, err));
        };

        this.getPersonProj = function(personID) {
            return basecampService.getPersonProjects(personID)
                .catch((err) => $log.error('Error while getting person projects', personID, err));
        };

        this.getPerson = function(personId){
            basecampService.getPerson(personId).then((response) => {
                return response.data;
            });
            /*$scope.getPersonInfo(personId).success(function (data, status, headers, config) {
             person = data;
             $scope.getExtraPersonInfo(personId).success(function(data, status, headers, config) {
             person.bio = data.bio;
             person.major = data.major;
             person.classStanding = data.classStanding;
             person.hometown = data.hometown;
             person.fact = data.fact;
             person.position = data.position;
             })
             });*/
        };

        this.getPersonEvents = function(personID, page) {
            return basecampService.getPersonEvents(personID, page)
                .catch((err) => $log.error('Error while getting person events', personID, err));
        };

        this.getGroups = function(){
            return basecampService.getGroups()
                .catch((err) => $log.error('Error while getting groups', err));
        };

        this.getGroup = function(groupId){
            return basecampService.getGroup(groupId)
                .catch((err) => $log.error('Error while getting group', groupId, err));
        };

        this.getDepartmentProjects = function(id){
            return $q((resolve, reject) => {
                basecampService.getDepartmentProjects(id).then((response) => resolve(response.data), (response) => reject(response.data));
            });
        };

        this.getProjects = function () {
            return basecampService.getProjects()
                .catch((err) => $log.error('Error while getting groups', err));
        };

        this.getProject = function (id) {
            return basecampService.getProject(id)
                .catch((err) => $log.error('Error while getting project', id, err));
        };

        this.getActiveTodoLists = function () {
            return basecampService.getActiveTodos()
                .catch((err) => $log.error('Error while getting active todos', err));
        };

        this.getCompletedTodoLists = function () {
            return basecampService.getCompletedTodos()
                .catch((err) => $log.error('Error while getting completed todos', err));
        };

        this.getProjectAccesses = function(id){
            return basecampService.getProjectAccesses(id)
                .catch((err) => $log.error('Error while getting project accesses', id, err));
        };

        this.getPersonDepts = function(id){
            return basecampService.getPersonDepartments(id).then((response) => {
                return response.data;
            });
        };

        this.getProjectEvents= function(id, page){
            return basecampService.getProjectEvents(id,page)
                .catch((err) => $log.error('Error while getting project events', id, err));
        };

        this.getPersonRoles = function(id){
            return basecampService.getPersonRoles(id)
                .catch((err) => $log.error('Error while getting person roles', id, err));
        };

        this.getRole = function(id){
            return basecampService.getRole(id)
                .catch((err) => $log.error('Error while getting role', id, err));
        };

        this.getRolePerson = function(roleId, departmentId){
            return basecampService.getDepartmentPersonWithRole(roleId, departmentId)
                .catch((err) => $log.error('Error while getting department role', departmentId, err));
        };

        this.changeRole = function(person, dept, role){
            return basecampService.changeRole(person, dept, role);
        };

    }]);