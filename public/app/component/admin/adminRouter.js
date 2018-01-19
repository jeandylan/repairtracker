/**
 * Created by dylan on 9/24/16.
 */
var app =
    angular.module('app');

app.run(
    ['$rootScope', '$state', '$stateParams',
        function ($rootScope, $state, $stateParams) {
            $rootScope.$state = $state;
            $rootScope.$stateParams = $stateParams;

        }
    ]
    )
    .config(
        ['$stateProvider', '$urlRouterProvider', 'JQ_CONFIG', 'MODULE_CONFIG',
            function ($stateProvider, $urlRouterProvider, JQ_CONFIG, MODULE_CONFIG, $auth) {
                /*
                 default fallback route if wrong url is used
                 */
                $urlRouterProvider.otherwise('app');
                /*
                 default should be app,every page is Check for login in ShopAppCtrl
                 */
                $stateProvider
                /*/
                 Login Page State
                 */
                    .state('login', {
                        url: '/login',
                        templateUrl: 'app/component/admin/log-in-out/log-in.html',
                    })

                    .state('app', {
                        url: '/app',
                        templateUrl: 'app/component/admin/template/app.html',
                        ncyBreadcrumb: {
                            label: 'Home'
                        },
                        resolve: load(['app/component/admin/adminCtrl.js', 'smart-table', 'app/component/core/filters/otherFilter.js', 'moment', 'ngDialog', 'ui.bootstrap.datetimepicker'
                        ])
                    })
                    .state('app.company', {
                        url: '/app',
                        templateUrl: 'app/component/admin/company/read/views/read-company.html',
                        ncyBreadcrumb: {
                            label: 'Client'
                        },
                        resolve: load(['app/component/admin/company/read/controllers/readCompanyCtrl.js'
                        ]),
                        pageTitle: 'Client Panel'
                    })
                    .state('app.supportersList', {
                        url: '/supporters',
                        templateUrl: 'app/component/admin/supporter/list.html',
                        ncyBreadcrumb: {
                            label: 'Supporters List'
                        },
                        resolve: load(['app/component/admin/supporter/supporterCtrl.js'
                        ])
                    })
                    .state('app.messagesList', {
                        url: '/messages',
                        templateUrl: 'app/component/admin/messages/list.html',
                        ncyBreadcrumb: {
                            label: 'Messages List'
                        },
                        resolve: load(['app/component/admin/messages/messageListCtrl.js'
                        ])
                    })
                    .state('app.supportersAdd', {
                        url: '/createSupporter',
                        templateUrl: 'app/component/admin/supporter/form.html',
                        ncyBreadcrumb: {
                            label: 'Add New Supporter'
                        },
                        resolve: load(['app/component/admin/supporter/supporterFormCtrl.js'
                        ])
                    })
                    .state('app.createCompany', {
                        url: '/createCompany',
                        templateUrl: 'app/component/admin/company/create/create-company.html',
                        ncyBreadcrumb: {
                            label: 'Create Company'
                        },
                        resolve: load(['app/component/admin/company/create/createCompanyCtrl.js',
                        ])
                    })
                    .state('app.updateCompany', {
                        url: '/updateCompany/{companyId:int}',
                        templateUrl: 'app/component/admin/company/update/updateCompany.html',
                        ncyBreadcrumb: {
                            label: 'Update Company'
                        },
                        resolve: load(['app/component/admin/company/update/updateCompanyCtrl.js'
                        ])
                    })
                    .state('app.viewMessage', {
                        url: '/viewMessage/{messageId:int}',
                        templateUrl: 'app/component/admin/messages/view.html',
                        ncyBreadcrumb: {
                            label: 'View Message'
                        },
                        resolve: load(['app/component/admin/messages/messageViewCtrl.js'
                        ])
                    })
                    .state('app.updateSupporter', {
                        url: '/updateSupporter/{supporterId:int}',
                        templateUrl: 'app/component/admin/supporter/update.html',
                        ncyBreadcrumb: {
                            label: 'Update Supporter'
                        },
                        resolve: load(['app/component/admin/supporter/updateSupporterCtrl.js'
                        ])
                    });


                /*form setting*/


                function load(srcs, callback) {
                    return {
                        deps: ['$ocLazyLoad', '$q',
                            function ($ocLazyLoad, $q) {
                                var deferred = $q.defer();
                                var promise = false;
                                srcs = angular.isArray(srcs) ? srcs : srcs.split(/\s+/);
                                if (!promise) {
                                    promise = deferred.promise;
                                }
                                angular.forEach(srcs, function (src) {
                                    promise = promise.then(function () {
                                        if (JQ_CONFIG[src]) {
                                            return $ocLazyLoad.load(JQ_CONFIG[src]);
                                        }
                                        angular.forEach(MODULE_CONFIG, function (module) {
                                            if (module.name == src) {
                                                name = module.name;
                                            } else {
                                                name = src;
                                            }
                                        });
                                        return $ocLazyLoad.load(name);
                                    });
                                });
                                deferred.resolve();
                                return callback ? promise.then(function () {
                                    return callback();
                                }) : promise;
                            }]
                    }
                }


            }
        ]
    );
