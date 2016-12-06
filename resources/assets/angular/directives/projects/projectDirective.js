'use strict';

angular.module('itracker')
    .directive('project', ['$routeParams', '$log', 'basecampService', 'dataService', 'apiService',
        function($routeParams, $log, basecampService, dataService, apiService){
            return {
                restrict: 'C',
                scope: {
                    'token': '@'
                },
                controller: ['$scope', ($scope) => {
                    let projectId = $routeParams.projectId;

                    $scope.project = {};

                    $scope.data = dataService.main;
                    $scope.canEdit = false;

                    $scope.loaded = false;
                    $scope.todoLoaded = false;
                    $scope.historyLoaded = false;

                    $scope.uploadImage = (event) => {
                        if(event.target.files.length < 1)
                            return;

                        let file = event.target.files[0];

                        let data = new FormData();

                        data.append('_method', 'POST');
                        data.append('_token', $scope.token);
                        data.append('image', file);

                        apiService.request('project/'+$scope.project.id+'/picture', 'POST', data, {
                            //Headers
                            'Content-Type': undefined
                        })
                            .then((response) => {
                                if(response.data)
                                    $scope.bootstrap();
                            })
                            .catch((response) => $log.error(response.data))
                    };

                    let getProject = () =>
                        basecampService.getProject(projectId)
                            .then((response) => {
                                let project = $scope.project = response.data;

                                if(project.departments && $scope.data.user)
                                    for(let org of $scope.data.user.organizations)
                                        if (org.organization.api_id == project.departments[0])
                                            $scope.canEdit = true;

                                let completed_ratio = project.dock.todoset.data.completed_ratio.split('/');
                                $scope.project.ratio = completed_ratio[1] == 0 ? -1 : (completed_ratio[0] / completed_ratio[1])*100;


                            })
                            .catch((response) => $log.error(response))
                            .finally(()=>$scope.loaded = true);

                    let getProjectTodos = () =>
                        basecampService.getProjectTodos(projectId)
                            .then((response) => {
                                let lists = response.data;

                                for(let list of lists){
                                    let ratio = list.completed_ratio.split('/');
                                    list.ratio = Math.floor((ratio[0]/ratio[1])*100);
                                }

                                $scope.project.todo = lists;
                            })
                            .catch((response) => $log.error(response))
                            .finally(() => $scope.todoLoaded = true);

                    let getProjectHistory = () =>
                        basecampService.getProjectHistory(projectId)
                            .then((response) => {
                                let timeline = [];

                                for(let moment of response.data){
                                    let obj = {
                                        type: moment.type,
                                        action: '',
                                        description: moment.description,
                                        updated_at: moment.updated_at,
                                        created_at: moment.created_at,
                                        url: moment.url,
                                        creator: moment.creator
                                    };

                                    switch(moment.type){
                                        case 'Upload':
                                            obj.action = 'uploaded '+moment.filename;
                                            break;
                                        case 'Todo':
                                            obj.action = (moment.completed ? 'completed' : '') + moment.content;
                                            break;
                                        default:
                                            break;
                                    }

                                    timeline.push(obj);
                                }

                                $scope.project.history = timeline;
                            })
                            .catch((response) => $log.error(response))
                            .finally(() => $scope.historyLoaded = true);


                    $scope.bootstrap = () => {
                        $scope.loaded = false;
                        $scope.todoLoaded = false;
                        $scope.historyLoaded = false;
                        getProject().then(() => {
                            getProjectTodos();
                            getProjectHistory();
                        });
                    };

                    $scope.bootstrap();
                }],
                templateUrl: '/angular/proj.project',
                link: function(scope, element, attrs){
                    scope.upload = () => {
                        $(element).find(' input[type=file]').trigger('click');
                    }
                }
            };
        }]);
