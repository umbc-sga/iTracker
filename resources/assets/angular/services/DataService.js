angular.module('itracker')
    .service('dataService', ['$q', '$log', 'basecampService', function($q, $log, basecampService) {

        let getPeople = () => {
            return basecampService.getPeople()
                .catch((err) => $log.error('Error while getting projects', err));
        };

        let getPersonInfo = function(personID) {
            return basecampService.getPersonInfo(personID)
                .catch((err) => $log.error('Error while getting person', personID, err));
        };

        let getPersonProj = function(personID) {
            return basecampService.getPersonProjects(personID)
                .catch((err) => $log.error('Error while getting person projects', personID, err));
        };

        let getPerson = function(personId){
            let person = {};
            basecampService.getPerson(personId).then((response) => {
                person = response.data;
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
            return person;
        };

        let getPersonEvents = function(personID, page) {
            return basecampService.getPersonEvents(personID, page)
                .catch((err) => $log.error('Error while getting person events', personID, err));
        };

        let getGroups = function(){
            return basecampService.getGroups()
                .catch((err) => $log.error('Error while getting groups', err));
        };

        let getGroup = function(groupId){
            return basecampService.getGroup(groupId)
                .catch((err) => $log.error('Error while getting group', groupId, err));
        };

        let getDepartmentProjects = function(id){
            return $q((resolve, reject) => {
                basecampService.getDepartmentProjects(id).then((response) => resolve(response.data), (response) => reject(response.data));
            });
        };

        let getProjects = function () {
            return basecampService.getProjects()
                .catch((err) => $log.error('Error while getting groups', err));
        };

        let getProject = function (id) {
            return basecampService.getProject(id)
                .catch((err) => $log.error('Error while getting project', id, err));
        };

        let getActiveTodoLists = function () {
            return basecampService.getActiveTodos()
                .catch((err) => $log.error('Error while getting active todos', err));
        };

        let getCompletedTodoLists = function () {
            return basecampService.getCompletedTodos()
                .catch((err) => $log.error('Error while getting completed todos', err));
        };

        let getProjectAccesses = function(id){
            return basecampService.getProjectAccesses(id)
                .catch((err) => $log.error('Error while getting project accesses', id, err));
        };

        let getPersonDepts = function(id){
            return basecampService.getPersonDepartments(id).then((response) => {
                return response.data;
            });
        };

        let getProjectEvents= function(id, page){
            return basecampService.getProjectEvents(id,page)
                .catch((err) => $log.error('Error while getting project events', id, err));
        };

        let getPersonRoles = function(id){
            return basecampService.getPersonRoles(id)
                .catch((err) => $log.error('Error while getting person roles', id, err));
        };

        let getRole = function(id){
            return basecampService.getRole(id)
                .catch((err) => $log.error('Error while getting role', id, err));
        };

        let getRolePerson = function(roleId, departmentId){
            return basecampService.getDepartmentPersonWithRole(roleId, departmentId)
                .catch((err) => $log.error('Error while getting department role', departmentId, err));
        };

        let changeRole = function(person, dept, role){
            return basecampService.changeRole(person, dept, role);
        };

        this.main = {
            people: [],
            projects: [],
            groups: [],
            projectCounts: {},
            activeTodoLists: [],
            completedTodoLists: [],
            activeTodoListsCompletedCount: 0,
            activeTodoListsRemainingCount: 0,
            completedTodoListsCompletedCount: 0,
            completedTodoListsRemainingCount: 0,
            emails: {}
        };

        /**
         * Get project counts
         *
         * @param projectId
         * @returns {{
         *     activeTodoListsCompletedCount,
         *     activeTodoListsRemainingCount,
         *     completedTodoListsCompletedCount,
         *     completedTodoListsRemainingCount,
         *     allTodoListsCompletedCount,
         *     allTodoListsCompletedCount,
         *     percentComplete
         * }}
         */
        this.getProjectCounts = function(projectId){
            let result = {
                activeTodoListsCompletedCount: 0,
                activeTodoListsRemainingCount: 0,
                completedTodoListsCompletedCount: 0,
                completedTodoListsRemainingCount: 0,
                allTodoListsCompletedCount: 0,
                percentComplete: 0
            };

            if(!(projectId != null)){
                return result;
            }

            // Return cached result if there is one
            if(this.main.projectCounts[projectId] != null){
                return this.main.projectCounts[projectId];
            }

            // Loop over active todo lists and count todo's
            for(let list of this.main.activeTodoLists)
                if(list.bucket.id === projectId) {
                    result.activeTodoListsCompletedCount += list.completed_count;
                    result.activeTodoListsRemainingCount += list.remaining_count;
                }


            for(let list of this.main.completedTodoLists)
                if(list.bucket.id === projectId) {
                    result.completedTodoListsCompletedCount += list.completed_count;
                    result.completedTodoListsRemainingCount += list.remaining_count;
                }

            // Only store result in cache if all data was fetched correctly so the numbers get updated
            // when todo lists are still being fetched
            if(this.main.projects.length && this.main.activeTodoLists.length && this.main.completedTodoLists.length){

                // Calculate some extra statistics
                result.allTodoListsCompletedCount = result.activeTodoListsCompletedCount + result.completedTodoListsCompletedCount;
                result.allTodoListsRemainingCount = result.activeTodoListsRemainingCount + result.completedTodoListsRemainingCount;
                result.percentComplete = result.allTodoListsCompletedCount * (100 / (result.allTodoListsCompletedCount + result.allTodoListsRemainingCount));

                // Store in cache
                this.main.projectCounts[projectId] = result;
            }

            return result;
        };

        this.getProjectPack = function(id){
            return getProject(id).then((response) => {
                let project = response.data;
                return {
                    id: project.id,
                    name: project.name,
                    status: project.archived ? 'Archived': 'Active',
                    description: project.description,
                    creator: project.creator.name,
                    events: project.calendar_events.count,
                    docs: project.documents.count,
                    created_ad: project.created_at,
                    updated_at: project.updated_at,
                };
            });
        };

        this.getPersonPack = function(id){
            return getPersonInfo(id).then((response) => {
                let person = response.data;
                //Remapped person
                return {
                    id: person.id,
                    name: person.name,
                    email: person.email_address,
                    todoCount: person.assigned_todos.count,
                    eventCount: person.events.count,
                    avatar_url: person.avatar_url,
                    bio: person.bio,
                    major: person.major,
                    classStanding: person.classStanding,
                    hometown: person.hometown,
                    fact: perosn.fact,
                    position: person.position,
                    activeProjects: person.activeProjects,
                    archivedProjects: person.archivedProjects,
                };
            });
        };

        this.bootstrap = () => {
            getProjects().then((response) => {
                let data = response.data;

                if (Array.isArray(data)) {
                    this.main.projects = data;
                    $log.debug('Projects:', data);

                    getActiveTodoLists().then((response) => {
                        let data = response.data;
                        if (Array.isArray(data)) {
                            this.main.activeTodoLists = data;
                            $log.debug('Active todo lists:', data);
                        }
                    });

                    getCompletedTodoLists().then((response) => {
                        let data = response.data;
                        if (Array.isArray(data)) {
                            this.main.completedTodoLists = data;
                            $log.debug('Completed todo lists:', data);
                        }
                    });
                }
            });

            getPeople().then((response) => {
                let data = response.data;
                if (Array.isArray(data)) {
                    for(let person of data){
                        this.main.emails[person.email] = person.id;
                        getPersonInfo(person.id).then((response) => {
                            let personInfo = response.data;

                            $log.debug('Person Info:', personInfo);

                            getPersonProj(person.id).then((response) => {
                                let personProject = response.data;
                                $log.debug('Person proj', personProject);

                                this.main.people.push( { 'info' : personInfo, 'proj' : personProject } );
                            });
                        });
                    }
                }
            });

            getGroups().then((response) => {
                let data = response.data;
                if (Array.isArray(data)) {
                    for(let group of data){
                        getGroup(group.id).then((response) => {
                            let groupInfo = response.data;
                            groupInfo.group_href = groupInfo.name.toLowerCase().replace(/\s+/g, '-').replace(/&/g, 'and');

                            $log.debug('Group Info:', groupInfo);
                            this.main.groups.push( groupInfo );
                        });
                    }
                }
            });
        };
    }]);