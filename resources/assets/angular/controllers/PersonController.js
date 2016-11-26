'use strict';

angular.module('itracker')
    .controller('PersonController', ['$scope','$http', '$routeParams',
        function ($scope, $http, $routeParams) {
        $scope.events = [];

        $scope.getPersonInfo($routeParams.personId).success(function(data, status, headers, config) {
            $scope.person = data;
            $scope.getExtraPersonInfo($scope.person.id).success(function(data, status, headers, config) {
                $scope.person.bio = data.bio;
                $scope.person.major = data.major;
                $scope.person.classStanding = data.classStanding;
                $scope.person.hometown = data.hometown;
                $scope.person.fact = data.fact;
                $scope.person.position = data.position;
            })
        });

        $scope.depts = $scope.getPersonDepts($routeParams.personId);
        $scope.projs = [];
        $scope.getPersonProj($routeParams.personId).success(function(data, status, headers, config) {
            angular.forEach(data, function(proj){
                if(!proj.template){
                    $scope.getProject(proj.id).success(function(data, status, headers, config) {
                        $scope.projs.push(data);
                    })
                }
            })
        });

        $scope.prettyDate = function(dateTime){
            var dateStr = dateTime.substring(0,dateTime.indexOf('T'));
            var year = dateStr.substring(0,dateStr.indexOf('-'));
            var rest = dateStr.substring(dateStr.indexOf('-') + 1);

            var month = monthNames[parseInt(rest.substring(0,rest.indexOf('-'))) - 1];
            rest = rest.substring(rest.indexOf('-') + 1);
            var day = rest;
            var prettyDate = day + ' ' + month + ' ' + year;
            return prettyDate;
        };

        $scope.page = 1;
        $scope.more = true;
        $scope.limit = 10;
        $scope.pull = true;
        $scope.getEventSet = function(){
            if($scope.pull && $scope.limit >= $scope.events.length){
                var curDate = '';
                $scope.getPersonEvents($routeParams.personId, $scope.page).success(function (data, status, headers, config) {
                    if(data.length < 50){
                        $scope.pull = false;
                    }
                    angular.forEach(data,function (event){
                        // alert(JSON.stringify(event));
                        if(event.bucket.type == 'Project'){
                            event.summary += " in <a href=\"/itracker/projects/" + event.bucket.id + "/\">" + event.bucket.name + "</a>";
                        }
                        event.created_at = $scope.prettyDate(event.created_at);
                        event.updated_at = $scope.prettyDate(event.updated_at);

                        var date = event.created_at;
                        if (date === curDate) {
                            event.created_at = '';
                        }

                        curDate = date;
                        $scope.events.push(event);
                    });
                    $scope.page++;
                    if($scope.limit >= $scope.events.length){
                        $scope.more = false;
                    }
                })
            }else if($scope.limit >= $scope.events.length){
                $scope.more = false;
            }
        };
        $scope.getEventSet();

    }]);