/**
 * Created by dylan on 16-Jun-16.
 */
var app =
    angular.module('app');

app.run(
    [          '$rootScope', '$state', '$stateParams',
        function ($rootScope,   $state,   $stateParams) {
            $rootScope.$state = $state;
            $rootScope.$stateParams = $stateParams;
        }
    ]
    )
    .config(
        [          '$stateProvider', '$urlRouterProvider', 'JQ_CONFIG', 'MODULE_CONFIG',
            function ($stateProvider,   $urlRouterProvider, JQ_CONFIG, MODULE_CONFIG) {
                /*
                default fallback route if wrong url is used
                 */
                $urlRouterProvider.otherwise('app');
/*
default should be app
 */
                $stateProvider
                    .state('app', {
                        url: '/app',
                        templateUrl: 'tpl/app.html'
                    })
                    /*
                    customers route
                     */
                    .state('app.view-customers-table', {
                        url: '/viewcustomerstable',
                        templateUrl: 'app/component/shop/customers/read/views/view-customers-table.html',
                        resolve: load(['smart-table','app/component/shop/customers/read/services/readCustomersService.js',
                            'app/component/shop/customers/read/controllers/readAllCustomersCtrl.js'])
                    })

                    .state('app.add-customer', {
                        url: '/addcustomer',
                        templateUrl: 'app/component/shop/customers/create/views/insert-customer-form.html',

                        resolve: load(['app/component/shop/customers/create/controllers/addNewCustomerController.js',
                            'app/component/shop/customers/create/controllers/formAddNewCustomerController.js',
                            'app/component/core/controllers/googleTypeAheadController.js'])
                    })

                    .state('app.update-customer', {
                        url: '/editcustomer/{customerId:int}',
                        templateUrl: 'app/component/shop/customers/update/views/view-update-customer.html',

                        resolve: load(['xeditable','app/component/shop/customers/update/views/view-update-customer.html',
                            'app/component/shop/customers/update/services/updateCustomerService.js',
                            'app/component/shop/customers/update/controllers/updateCustomerCtrl.js',
                            'app/component/core/controllers/googleTypeAheadController.js'])
                    })

                    /*
                    tickets routes
                     */

                    .state('app.create-ticket', {
                        url: '/create-ticket',
                        templateUrl: 'app/component/shop/tickets/create/views/create-ticket.html',

                        resolve: load(['app/component/shop/tickets/create/controllers/createTicketCtrl.js'])
                    })
                .state('app.read-ticket', {
                    url: '/read-ticket',
                    templateUrl: 'app/component/shop/tickets/read/views/read-ticket.html',

                    resolve: load(['xeditable', "ui.select",'app/component/shop/tickets/read/controllers/readTicketCtrl.js'])
                })
                    /*
                    be careful the links below belongs to tickets with(s)- return a view with a tables for all tickets
                     */

                .state('app.read-tickets', {
                    url: '/read-tickets',
                    templateUrl: 'app/component/shop/tickets/read/views/read-tickets.html',

                    resolve: load(['smart-table','app/component/shop/tickets/read/controllers/readTicketsCtrl.js'])
                });

                function load(srcs, callback) {
                    return {
                        deps: ['$ocLazyLoad', '$q',
                            function( $ocLazyLoad, $q ){
                                var deferred = $q.defer();
                                var promise  = false;
                                srcs = angular.isArray(srcs) ? srcs : srcs.split(/\s+/);
                                if(!promise){
                                    promise = deferred.promise;
                                }
                                angular.forEach(srcs, function(src) {
                                    promise = promise.then( function(){
                                        if(JQ_CONFIG[src]){
                                            return $ocLazyLoad.load(JQ_CONFIG[src]);
                                        }
                                        angular.forEach(MODULE_CONFIG, function(module) {
                                            if( module.name == src){
                                                name = module.name;
                                            }else{
                                                name = src;
                                            }
                                        });
                                        return $ocLazyLoad.load(name);
                                    } );
                                });
                                deferred.resolve();
                                return callback ? promise.then(function(){ return callback(); }) : promise;
                            }]
                    }
                }


            }
        ]
    );
