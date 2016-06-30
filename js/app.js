var monthNames = ["January", "February", "March", "April", "May", "June",
  "July", "August", "September", "October", "November", "December"
];

function replace_All(str, find, replace){
    while(str.indexOf(find) != -1){
        str = str.replace(find, replace);
    }
    return str;
}

/*  This work is licensed under Creative Commons GNU LGPL License.

    License: http://creativecommons.org/licenses/LGPL/2.1/
   Version: 0.9
    Author:  Stefan Goessner/2006
    Web:     http://goessner.net/ 
*/
function xml2json(xml, tab) {
   var X = {
      toObj: function(xml) {
         var o = {};
         if (xml.nodeType==1) {   // element node ..
            if (xml.attributes.length)   // element with attributes  ..
               for (var i=0; i<xml.attributes.length; i++)
                  o["@"+xml.attributes[i].nodeName] = (xml.attributes[i].nodeValue||"").toString();
            if (xml.firstChild) { // element has child nodes ..
               var textChild=0, cdataChild=0, hasElementChild=false;
               for (var n=xml.firstChild; n; n=n.nextSibling) {
                  if (n.nodeType==1) hasElementChild = true;
                  else if (n.nodeType==3 && n.nodeValue.match(/[^ \f\n\r\t\v]/)) textChild++; // non-whitespace text
                  else if (n.nodeType==4) cdataChild++; // cdata section node
               }
               if (hasElementChild) {
                  if (textChild < 2 && cdataChild < 2) { // structured element with evtl. a single text or/and cdata node ..
                     X.removeWhite(xml);
                     for (var n=xml.firstChild; n; n=n.nextSibling) {
                        if (n.nodeType == 3)  // text node
                           o["#text"] = X.escape(n.nodeValue);
                        else if (n.nodeType == 4)  // cdata node
                           o["#cdata"] = X.escape(n.nodeValue);
                        else if (o[n.nodeName]) {  // multiple occurence of element ..
                           if (o[n.nodeName] instanceof Array)
                              o[n.nodeName][o[n.nodeName].length] = X.toObj(n);
                           else
                              o[n.nodeName] = [o[n.nodeName], X.toObj(n)];
                        }
                        else  // first occurence of element..
                           o[n.nodeName] = X.toObj(n);
                     }
                  }
                  else { // mixed content
                     if (!xml.attributes.length)
                        o = X.escape(X.innerXml(xml));
                     else
                        o["#text"] = X.escape(X.innerXml(xml));
                  }
               }
               else if (textChild) { // pure text
                  if (!xml.attributes.length)
                     o = X.escape(X.innerXml(xml));
                  else
                     o["#text"] = X.escape(X.innerXml(xml));
               }
               else if (cdataChild) { // cdata
                  if (cdataChild > 1)
                     o = X.escape(X.innerXml(xml));
                  else
                     for (var n=xml.firstChild; n; n=n.nextSibling)
                        o["#cdata"] = X.escape(n.nodeValue);
               }
            }
            if (!xml.attributes.length && !xml.firstChild) o = null;
         }
         else if (xml.nodeType==9) { // document.node
            o = X.toObj(xml.documentElement);
         }
         else
            alert("unhandled node type: " + xml.nodeType);
         return o;
      },
      toJson: function(o, name, ind) {
         var json = name ? ("\""+name+"\"") : "";
         if (o instanceof Array) {
            for (var i=0,n=o.length; i<n; i++)
               o[i] = X.toJson(o[i], "", ind+"\t");
            json += (name?":[":"[") + (o.length > 1 ? ("\n"+ind+"\t"+o.join(",\n"+ind+"\t")+"\n"+ind) : o.join("")) + "]";
         }
         else if (o == null)
            json += (name&&":") + "null";
         else if (typeof(o) == "object") {
            var arr = [];
            for (var m in o)
               arr[arr.length] = X.toJson(o[m], m, ind+"\t");
            json += (name?":{":"{") + (arr.length > 1 ? ("\n"+ind+"\t"+arr.join(",\n"+ind+"\t")+"\n"+ind) : arr.join("")) + "}";
         }
         else if (typeof(o) == "string")
            json += (name&&":") + "\"" + o.toString() + "\"";
         else
            json += (name&&":") + o.toString();
         return json;
      },
      innerXml: function(node) {
         var s = ""
         if ("innerHTML" in node)
            s = node.innerHTML;
         else {
            var asXml = function(n) {
               var s = "";
               if (n.nodeType == 1) {
                  s += "<" + n.nodeName;
                  for (var i=0; i<n.attributes.length;i++)
                     s += " " + n.attributes[i].nodeName + "=\"" + (n.attributes[i].nodeValue||"").toString() + "\"";
                  if (n.firstChild) {
                     s += ">";
                     for (var c=n.firstChild; c; c=c.nextSibling)
                        s += asXml(c);
                     s += "</"+n.nodeName+">";
                  }
                  else
                     s += "/>";
               }
               else if (n.nodeType == 3)
                  s += n.nodeValue;
               else if (n.nodeType == 4)
                  s += "<![CDATA[" + n.nodeValue + "]]>";
               return s;
            };
            for (var c=node.firstChild; c; c=c.nextSibling)
               s += asXml(c);
         }
         return s;
      },
      escape: function(txt) {
         return txt.replace(/[\\]/g, "\\\\")
                   .replace(/[\"]/g, '\\"')
                   .replace(/[\n]/g, '\\n')
                   .replace(/[\r]/g, '\\r');
      },
      removeWhite: function(e) {
         e.normalize();
         for (var n = e.firstChild; n; ) {
            if (n.nodeType == 3) {  // text node
               if (!n.nodeValue.match(/[^ \f\n\r\t\v]/)) { // pure whitespace text node
                  var nxt = n.nextSibling;
                  e.removeChild(n);
                  n = nxt;
               }
               else
                  n = n.nextSibling;
            }
            else if (n.nodeType == 1) {  // element node
               X.removeWhite(n);
               n = n.nextSibling;
            }
            else                      // any other node
               n = n.nextSibling;
         }
         return e;
      }
   };
   if (xml.nodeType == 9) // document node
      xml = xml.documentElement;
   var json = X.toJson(X.toObj(X.removeWhite(xml)), xml.nodeName, "\t");
   return "{\n" + tab + (tab ? json.replace(/\t/g, tab) : json.replace(/\t|\n/g, "")) + "\n}";
}


angular.module('basecamp', ['ngSanitize'])

    .config(['$routeProvider','$locationProvider', function ($routeProvider, $locationProvider) {
        $routeProvider
            .when('/', {
                templateUrl: 'templates/home.html',
                controller: 'HomeController'
            })
            .when('/people/by-dept/', {
                templateUrl: 'templates/people-by-dept.html',
                controller: 'PeopleByDeptController'
            })
            .when('/people/by-name/', {
                templateUrl: 'templates/people-by-name.html',
                controller: 'PeopleByNameController'
            })
            .when('/people/:personId/', {
                templateUrl: 'templates/person.html',
                controller: 'PersonController'
            })
            .when('/projects/by-name/', {
                templateUrl: 'templates/projects-by-name.html',
                controller: 'ProjectsByNameController'
            })
            .when('/projects/by-dept/', {
                templateUrl: 'templates/projects-by-dept.html',
                controller: 'ProjectsByDeptController'
            })
            .when('/projects-old/:projectId/', {
                templateUrl: 'templates/project-orig.html',
                controller: 'ProjectController'
            })
            .when('/projects/:projectId/', {
                templateUrl: 'templates/project.html',
                controller: 'ProjectController'
            })
            .when('/projects/:projectId/todolists/:todoListId', {
                templateUrl: 'templates/todo-list.html',
                controller: 'TodoListController'
            })
            .otherwise({
                templateUrl: 'templates/404-error.html',
                controller: 'ErrorController'
            });
            //.when('/projects/:projectName', {})
            
            //.when('/departments/members', {})
            //.when('/departmenet/projects', {})
            //.when('/departments/:departmentName', {})

        $locationProvider.html5Mode(true);
    }])

    .value('basecamp.config', {
        debug: false // Set to false to disable logging to console
    })

/**
 * Main controller that holds some global data
 *
 * Fetches and stores some initial data in the main property to display global statistics
 */
    .controller('MainController', ['$scope', '$http', 'basecamp.config', function ($scope, $http, basecampConfig) {

        /**
         * Container for some global data
         */
        $scope.main = {
            people: [],
            projects: [],
            groups: [],
            projectCounts: {},
            activeTodoLists: [],
            completedTodoLists: [],
            activeTodoListsCompletedCount: 0,
            activeTodoListsRemainingCount: 0,
            completedTodoListsCompletedCount: 0,
            completedTodoListsRemainingCount: 0
        };

        /**
         * Get all people
         *
         * Returns promise so additional callbacks can be attached
         */
        $scope.getPeople = function () {
            // var rawPeople = $http.get('get.php?url=people.json');
            // var finalPeople = [];
            // for (var i = 0; i <= rawPeople.length; i++) {
            //     var personInfo = $http.get('get.php?url=people/' + rawPeople[i]["id"] +'.json');
            //     var personProj = $http.get('get.php?url=people/' + rawPeople[i]["id"] +'/projects.json');
            //     finalPeople.push( { "info" : personInfo, "projects" : personProj } );
            // }
            // return finalPeople;
            return $http.get('get.php?url=people.json')
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting projects: ' + data);
                })
        }

        

        $scope.getPersonInfo = function(personID) {
            return $http.get('get.php?url=people/' + personID +'.json')
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting projects: ' + data);
                })
        }

        $scope.getPersonProj = function(personID) {
            return $http.get('get.php?url=people/' + personID +'/projects.json')
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting projects: ' + data);
                })
        }

        $scope.getGroups = function(){
            return $http.get('get.php?url=groups.json')
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting groups: ' + data);
                })
        }

        $scope.getGroup = function(groupId){
            return $http.get('get.php?url=groups/' + groupId + '.json')
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting group : ' + groupId + data);
                })
        }
        /**
         * Get all projects
         *
         * Returns promise so additional callbacks can be attached
         */
        $scope.getProjects = function () {
            return $http.get('get.php?url=projects.json')
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting projects: ' + data);
                })
        }

        $scope.getProject = function (id) {
            return $http.get('get.php?url=projects/' + id + '.json')
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting projects: ' + data);
                })
        }

        /**
         * Get all active todo lists
         *
         * Returns promise so additional callbacks can be attached
         */
        $scope.getActiveTodoLists = function () {
            return $http.get('get.php?url=todolists.json')
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting active todo lists: ' + data);
                });
        }

        /**
         * Get all completed todo lists
         *
         * Returns promise so additional callbacks can be attached
         */
        $scope.getCompletedTodoLists = function () {
            return $http.get('get.php?url=todolists/completed.json')
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting completed todo lists: ' + data);
                })
        }

        $scope.getPersonPack = function(id){
            var per = {};
            $scope.getPersonInfo(id).success(function(data, status, headers, config) {
                per.id = data.id;
                per.name = data.name;
                per.email = data.email_address;
                per.assigned = data.assigned_todos.count;
                per.avatar_url = data.avatar_url;
                per.active = 0;
                per.archive = 0;

                $scope.getPersonProj(id).success(function(data, status, headers, config) {
                    angular.forEach(data, function(proj){
                    	if (!proj.template) {
	                        if(!proj.trashed) {
	                            per.active++;
	                        }else{
	                            per.archive++;
	                        }
	                    }
                    })
                })
            })
            return per;
        }

        $scope.getProjectPack = function(id){
            var proj = {};
            $scope.getProject(id).success(function(data, status, headers, config) {
                proj.id = data.id;
                proj.name = data.name;
                proj.description = data.description;
                proj.creator = data.creator.name;
                proj.events = data.calendar_events.count
                proj.docs = data.documents.count;
                if(data.archived){
                    proj.status = "Archived";
                }else{
                    proj.status = "Active";
                }
            })
            return proj;
        }

        $scope.getPersonDepts = function(id){
            var departments = [];
            $scope.getGroups().success(function(data, status, headers, config) {
                angular.forEach(data,function(dept){
                    $scope.getGroup(dept.id).success(function(data, status, headers, config) {
                        angular.forEach(data.memberships, function(person){
                            if(person.id == id){
                                departments.push(data);
                            }
                        })
                    })
                })
            })
            return departments;
        }


        /**
         * Get project counts
         *
         * @param projectId
         * @returns {
         *     activeTodoListsCompletedCount: 0,
         *     activeTodoListsRemainingCount: 0,
         *     completedTodoListsCompletedCount: 0,
         *     completedTodoListsRemainingCount: 0,
         *     allTodoListsCompletedCount: 0,
         *     allTodoListsCompletedCount: 0,
         *     percentComplete: 0
         * }
         */
        $scope.getProjectCounts = function(projectId){

            var result = {
                activeTodoListsCompletedCount: 0,
                activeTodoListsRemainingCount: 0,
                completedTodoListsCompletedCount: 0,
                completedTodoListsRemainingCount: 0,
                allTodoListsCompletedCount: 0,
                allTodoListsCompletedCount: 0,
                percentComplete: 0
            };

            if(angular.isUndefined(projectId)){
                return result;
            }

            // Return cached result if there is one
            if(angular.isDefined($scope.main.projectCounts[projectId])){
                return $scope.main.projectCounts[projectId];
            }

            // Loop over active todo lists and count todo's
            angular.forEach($scope.main.activeTodoLists, function(todoList){
               if(todoList.bucket.id === projectId){
                   result.activeTodoListsCompletedCount += todoList.completed_count;
                   result.activeTodoListsRemainingCount += todoList.remaining_count;
               }
            });

            // Loop over completed todo lists and count todo's
            angular.forEach($scope.main.completedTodoLists, function(todoList){
                if(todoList.bucket.id === projectId){
                    result.completedTodoListsCompletedCount += todoList.completed_count;
                    result.completedTodoListsRemainingCount += todoList.remaining_count;
                }
            });

            // Only store result in cache if all data was fetched correctly so the numbers get updated
            // when todo lists are still being fetched
            if($scope.main.projects.length && $scope.main.activeTodoLists.length && $scope.main.completedTodoLists.length){

                // Calculate some extra statistics
                result.allTodoListsCompletedCount = result.activeTodoListsCompletedCount + result.completedTodoListsCompletedCount;
                result.allTodoListsRemainingCount = result.activeTodoListsRemainingCount + result.completedTodoListsRemainingCount;
                result.percentComplete = result.allTodoListsCompletedCount * (100 / (result.allTodoListsCompletedCount + result.allTodoListsRemainingCount));

                // Store in cache
                $scope.main.projectCounts[projectId] = result;
            }

            return result;
        }

        
        /**
         * Recalculate main counters when main active todo lists change
         */
        $scope.$watch('main.activeTodoLists', function (activeTodoLists, oldActiveTodoLists) {

            // Do nothing of nothing changed
            if (activeTodoLists === oldActiveTodoLists) {
                return;
            }

            basecampConfig.debug && console.log('Recalculate main active todo list counters');

            // Reset main counters
            $scope.main.activeTodoListsCompletedCount = 0;
            $scope.main.activeTodoListsRemainingCount = 0;

            // Increment counters
            angular.forEach(activeTodoLists, function (todoList) {

                // Increment main counters
                $scope.main.activeTodoListsCompletedCount += todoList.completed_count;
                $scope.main.activeTodoListsRemainingCount += todoList.remaining_count;
            })
        }, true);

        /**
         * Recalculate main counters when main completed todo lists change
         */
        $scope.$watch('main.completedTodoLists', function (completedTodoLists, oldCompletedTodoLists) {

            // Do nothing of nothing changed
            if (completedTodoLists === oldCompletedTodoLists) {
                return;
            }

            basecampConfig.debug && console.log('Recalculate main completed todo list counters');

            // Reset counters
            $scope.main.completedTodoListsCompletedCount = 0;
            $scope.main.completedTodoListsRemainingCount = 0;

            // Increment counters
            angular.forEach(completedTodoLists, function (todoList) {
                $scope.main.completedTodoListsCompletedCount += todoList.completed_count;
                $scope.main.completedTodoListsRemainingCount += todoList.remaining_count;
            })
        }, true);

        /**
         * Bootstrap data
         *
         * Get projects and if it succeeds also get the todo lists
         */
        $scope.bootstrapData = function(){
            
            $scope.getProjects().success(function (data, status, headers, config) {
                if (angular.isArray(data)) {
                    $scope.main.projects = data;
                    basecampConfig.debug && console.log('Projects:', data);

                    $scope.getActiveTodoLists().success(function (data, status, headers, config) {
                        if (angular.isArray(data)) {
                            $scope.main.activeTodoLists = data;
                            basecampConfig.debug && console.log('Active todo lists:', data);
                        }
                    });

                    $scope.getCompletedTodoLists().success(function (data, status, headers, config) {
                        if (angular.isArray(data)) {
                            $scope.main.completedTodoLists = data;
                            basecampConfig.debug && console.log('Completed todo lists:', data);
                        }
                    });
                }
            });

            $scope.getPeople().success(function (data, status, headers, config) {
                if (angular.isArray(data)) {
                    var rawPeople = data;   
                    // basecampConfig.debug && console.log('People:', rawPeople);

                    angular.forEach (rawPeople, function (person) {
                        var personInfo = [];
                        var personProj = [];

                        $scope.getPersonInfo(person.id).success(function (data, status, headers, config) {
                            // if (angular.isArray(data)) {
                                personInfo = data;
                                basecampConfig.debug && console.log('Person Info:', personInfo);

                                $scope.getPersonProj(person.id).success(function (data, status, headers, config) {
                                    // if (angular.isArray(data)) {
                                        personProj = data;
                                        basecampConfig.debug && console.log('Person Info:', personInfo);

                                        $scope.main.people.push( { 'info' : personInfo, 'proj' : personProj } );
                                    // }
                                })
                            // }
                        }) 
                    })                    
                }
            });

            $scope.getGroups().success(function (data, status, headers, config) {
                if (angular.isArray(data)) {
                    var rawGroups = data;

                    angular.forEach (rawGroups, function (group) {
                        $scope.getGroup(group.id).success(function (data, status, headers, config) {
                            var groupInfo = data;
                            var group_href = replace_All(replace_All(groupInfo.name.toLowerCase()," ", "-") , "&", "and");
                            groupInfo.group_href = group_href;

                            basecampConfig.debug && console.log('Group Info:', groupInfo);

                            $scope.main.groups.push( groupInfo );
                        })
                    })
                }
            });
        }

        $scope.bootstrapData();

    }])

/**
 * Controller for the home page that displays the project overview
 */
    .controller('HomeController', ['$scope','$http', function ($scope, $http) {
        $scope.featuredProjs = [];
        
        $scope.getProjects().success(function (data, status, headers, config) {
            if (angular.isArray(data)) {
                var rawProjects = data;

                angular.forEach(rawProjects, function (project) {
                    if (project.starred == true) {
                        $scope.featuredProjs.push(project);
                    }
                })
            }
        })
    }])

/**
 * Controller for the page that displays project details
 */
    .controller('ProjectController', ['$scope','$http', '$routeParams', function ($scope, $http, $routeParams) {

        $scope.project = {};
        $scope.projectRSSentries = [];

        $scope.activeTodoLists = [];
        $scope.completedTodoLists = [];

        $scope.activeTodoListsCompletedCount = 0;
        $scope.activeTodoListsRemainingCount = 0;

        $scope.completedTodoListsCompletedCount = 0;
        $scope.completedTodoListsRemainingCount = 0;

        $scope.prettyDate = function(dateTime){
          var dateStr = dateTime.substring(0,dateTime.indexOf('T'));
          var year = dateStr.substring(0,dateStr.indexOf('-'));
          var rest = dateStr.substring(dateStr.indexOf('-') + 1);

          var month = monthNames[parseInt(rest.substring(0,rest.indexOf('-'))) - 1];
          rest = rest.substring(rest.indexOf('-') + 1);
          var day = rest;
          var prettyDate = day + ' ' + month + ' ' + year; 
          return prettyDate;
        }
        $scope.trust = $http.trustAsHtml;
        $http.get('get.php?url=projects/' + $routeParams.projectId + '.json')
            .success(function (data, status, headers, config) {
                // console.log('SUCCESS');
                // this callback will be called asynchronously
                // when the response is available
                var project = angular.fromJson(data);
                if (angular.isObject(project)) {
                    $scope.project = project;
                    // console.log(project);
                    $scope.project.created_at = $scope.prettyDate($scope.project.created_at);
                    $scope.project.updated_at = $scope.prettyDate($scope.project.updated_at);

                }
            }).
            error(function (data, status, headers, config) {
                // called asynchronously if an error occurs
                // or server returns response with an error status.
                console.log('ERROR');
            })

        $http.get('getRSS.php?id=' + $routeParams.projectId)
            .success(function (data, status, headers, config) {
                var xml = data;
                var parsed;

                if (window.DOMParser) {     // you are using a SANE browser
                    parser = new DOMParser();
                    parsed = parser.parseFromString(xml, "text/xml");
                } else {                    // you are using INTERNET EXPLORER
                    parsed = new ActiveXObject("Microsoft.XMLDOM");
                    parsed.async = false;
                    parsed.loadXML(xml);
                }

                var temp = JSON.parse(xml2json(parsed,''));
                var oldDate = '';
                angular.forEach(temp["feed"]["entry"], function (entry) {
                    if (entry.hasOwnProperty("content")) {
                        entry.content = entry["content"]["#text"];
                    }
                    var dateTime = entry.published;
                    var prettyDate = $scope.prettyDate(dateTime);
                    entry.published = prettyDate;
                    if(entry.published == oldDate){
                      entry.published = '';
					}
                    oldDate = prettyDate;
                    $scope.projectRSSentries.push(entry);
                    
                })

                // console.log($scope.projectRSS);
            })
            .error(function (data, status, headers, config) {
                // called asynchronously if an error occurs
                // or server returns response with an error status.
                console.log('ERROR');
            })

        // Get active todo lists
        $scope.activeTodoLists = $http.get('get.php?url=projects/' + $routeParams.projectId + '/todolists.json')
            .success(function (data, status, headers, config) {
                // console.log('SUCCESS');
                // this callback will be called asynchronously
                // when the response is available
                var activeTodoLists = angular.fromJson(data);
                if (angular.isArray(activeTodoLists)) {
                    $scope.activeTodoLists = activeTodoLists;
                    // console.log(activeTodoLists);
                }
            }).
            error(function (data, status, headers, config) {
                // called asynchronously if an error occurs
                // or server returns response with an error status.
                console.log('ERROR');
            })

        // Get active todo lists
        $scope.completedTodoLists = $http.get('get.php?url=projects/' + $routeParams.projectId + '/todolists/completed.json')
            .success(function (data, status, headers, config) {
                // console.log('SUCCESS');
                // this callback will be called asynchronously
                // when the response is available
                var completedTodoLists = angular.fromJson(data);
                if (angular.isArray(completedTodoLists)) {
                    $scope.completedTodoLists = completedTodoLists;
                    // console.log(completedTodoLists);
                }
            }).
            error(function (data, status, headers, config) {
                // called asynchronously if an error occurs
                // or server returns response with an error status.
                console.log('ERROR');
            })


        $scope.$watch('activeTodoLists', function (activeTodoLists, oldActiveTodoLists) {

            if (activeTodoLists === oldActiveTodoLists) {
                return;
            }

            $scope.activeTodoListsCompletedCount = 0;
            $scope.activeTodoListsRemainingCount = 0;

            angular.forEach(activeTodoLists, function (todoList) {
                $scope.activeTodoListsCompletedCount += todoList.completed_count;
                $scope.activeTodoListsRemainingCount += todoList.remaining_count;
            })

        }, true);

        $scope.$watch('completedTodoLists', function (completedTodoLists, oldCompletedTodoLists) {

            if (completedTodoLists === oldCompletedTodoLists) {
                return;
            }

            $scope.completedTodoListsCompletedCount = 0;
            $scope.completedTodoListsRemainingCount = 0;

            angular.forEach(completedTodoLists, function (todoList) {
                $scope.completedTodoListsCompletedCount += todoList.completed_count;
                $scope.completedTodoListsRemainingCount += todoList.remaining_count;
            })

        }, true);
    }])

/**
 * Controller for the page that shows the todo lists for a certain project
 */
    .controller('TodoListController', ['$scope','$http', '$routeParams', function ($scope, $http, $routeParams) {

        $scope.projectId = $routeParams.projectId;
        $scope.todoListId = $routeParams.todoListId;
        $scope.todoList = {};

        $scope.project = $http.get('get.php?url=projects/' + $routeParams.projectId + '.json')
            .success(function (data, status, headers, config) {
                console.log('SUCCESS');
                // this callback will be called asynchronously
                // when the response is available
                var project = angular.fromJson(data);
                if (angular.isObject(project)) {
                    $scope.project = project;
                    console.log(project);
                }
            }).
            error(function (data, status, headers, config) {
                // called asynchronously if an error occurs
                // or server returns response with an error status.
                console.log('ERROR');
            })

        // Get todo list including todo's
        $scope.todoList = $http.get('get.php?url=projects/' + $routeParams.projectId + '/todolists/' + $routeParams.todoListId + '.json')
            .success(function (data, status, headers, config) {
                console.log('SUCCESS');
                // this callback will be called asynchronously
                // when the response is available
                var todoList = angular.fromJson(data);
                if (angular.isObject(todoList)) {
                    $scope.todoList = todoList;
                    console.log(todoList);
                }
            }).
            error(function (data, status, headers, config) {
                // called asynchronously if an error occurs
                // or server returns response with an error status.
                console.log('ERROR');
            })
    }])

    .controller('PeopleByDeptController', ['$scope','$http', '$routeParams', function ($scope, $http, $routeParams) {
        $scope.depts = [];
        $scope.scrollTo = function(id) {
            console.log('go yo ' + id);
            $anchorScroll(id);
        }
        var badEmails = ['sga@umbc.edu','berger@umbc.edu','saddison@umbc.edu'];
        $scope.getGroups().success(function (data, status, headers, config) {
            angular.forEach(data,function(dept){
                var department = {};
                $scope.getGroup(dept.id).success(function (data, status, headers, config) {
                    department.name = data.name;
                    department.id = data.id;
                    
                    var people = [];
                    angular.forEach(data.memberships, function(person){
                        if(badEmails.indexOf(person.email_address) == -1)
                            people.push($scope.getPersonPack(person.id));
                    })
                    department.people = people;
                    $scope.depts.push(department);
                })
            })
        })
    }])

    .controller('PeopleByNameController', ['$scope','$http', '$routeParams', function ($scope, $http, $routeParams) {
        $scope.people = {}
        var badEmails = ['sga@umbc.edu','berger@umbc.edu','saddison@umbc.edu'];
        $scope.scrollTo = function(id) {
            console.log('go yo ' + id);
            $anchorScroll(id);
        }
        $scope.alpha = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        angular.forEach($scope.alpha, function(letter){
            $scope.people[letter] = [];
        })
        $scope.getPeople().success(function(data, status, headers, config) {
            angular.forEach(data, function(person){
                if(badEmails.indexOf(person.email_address) == -1){
                    var letter = person.name[0].toUpperCase();
                    $scope.people[letter].push($scope.getPersonPack(person.id));
                }
            })
        })
    }])

    .controller('ProjectsByDeptController', ['$scope','$http', '$routeParams', function ($scope, $http, $routeParams) {
        $scope.depts = [];
        $scope.scrollTo = function(id){
            $anchorScroll(id);
        }
        $scope.getGroups().success(function (data, status, headers, config) {
            angular.forEach(data,function(dept){
                var department = {};
                $scope.getGroup(dept.id).success(function (data, status, headers, config) {
                    department.name = data.name;
                    department.id = data.id;
                    
                    var projects = [];
                    angular.forEach(data.memberships, function(person){
                        $scope.getPersonProj(person.id).success(function (data, status, headers, config) {
                            angular.forEach(data, function(proj){
                                if(!proj.template)
                                    projects.push($scope.getProjectPack(proj.id));
                            })
                        })
                    })
                    department.projects = projects;
                    $scope.depts.push(department);
                })
            })
        })
    }])

    .controller('ProjectsByNameController', ['$scope','$http', '$routeParams', function ($scope, $http, $routeParams) {
        $scope.projects = {};
        $scope.alpha = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        angular.forEach($scope.alpha, function(letter){
            $scope.projects[letter] = [];
        })
        $scope.getProjects().success(function(data, status, headers, config) {
            angular.forEach(data,function(proj){
                var letter = proj.name[0];
                if(!proj.template)
                    $scope.projects[letter].push($scope.getProjectPack(proj.id));
            })
        })
    }])

    .controller('PersonController', ['$scope','$http', '$routeParams', function ($scope, $http, $routeParams) {
        $scope.getPersonInfo($routeParams.personId).success(function(data, status, headers, config) {
            $scope.person = data;    
        })
        $scope.depts = $scope.getPersonDepts($routeParams.personId);
        $scope.projs = [];
        $scope.getPersonProj($routeParams.personId).success(function(data, status, headers, config) {
            angular.forEach(data, function(proj){
                if(!proj.template)
                    $scope.projs.push($scope.getProjectPack(proj.id));
            })
        })
    }])