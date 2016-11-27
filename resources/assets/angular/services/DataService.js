'use strict';

angular.module('itracker')
    .factory('dataService', ['$q', '$log', 'retrievalService', function($q, $log, retrievalService) {
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
        let getProjectCounts = (projectId) => {
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

        let getProjectPack = (id) => {
            return retrievalService.getProject(id).then((response) => {
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

        let getPersonPack = (id) => {
            return retrievalService.getPersonInfo(id).then((response) => {
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

        let bootstrap = () => {
            retrievalService.getProjects().then((response) => {
                let projects = response.data;
                if (Array.isArray(projects)) {
                    this.main.projects = projects;
                    $log.debug('Projects:', projects);

                    retrievalService.getActiveTodoLists().then((response) => {
                        let data = response.data;
                        if (Array.isArray(data)) {
                            this.main.activeTodoLists = data;
                            $log.debug('Active todo lists:', data);
                        }
                    });

                    retrievalService.getCompletedTodoLists().then((response) => {
                        let data = response.data;
                        if (Array.isArray(data)) {
                            this.main.completedTodoLists = data;
                            $log.debug('Completed todo lists:', data);
                        }
                    });
                }
            });

            retrievalService.getPeople().then((response) => {
                let people = response.data;

                if (Array.isArray(people)) {
                    $log.debug('People: ', people);

                    for(let person of people){
                        this.main.emails[person.email] = person.id;
                        this.main.people.push( { 'info' : person } );

                        /*
                        retrievalService.getPersonInfo(person.id).then((response) => {
                            let personInfo = response.data;

                            $log.debug('Person Info:', personInfo);

                            retrievalService.getPersonProj(person.id).then((response) => {
                                let personProject = response.data;
                                $log.debug('Person proj', personProject);

                                this.main.people.push( { 'info' : personInfo, 'proj' : personProject } );
                            });
                        });
                        */
                    }
                }
            });

            retrievalService.getGroups().then((response) => {
                let groups = response.data;

                if (Array.isArray(groups)) {
                    $log.debug('Groups:', groups);

                    for(let group of groups){
                        group.group_href = group.name.toLowerCase().replace(/\s+/g, '-').replace(/&/g, 'and');
                        this.main.groups.push( group );
                    }
                }
            });
        };

        return {
            getProjectCounts: getProjectCounts,
            getProjectPack: getProjectPack,
            getPersonPack: getPersonPack,
            bootstrap: bootstrap,
            main: this.main
        }
    }]);