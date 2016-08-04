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
                        templateUrl: 'tpl/app.html',
                        resolve:load(['app/component/core/controllers/testCtrl.js'])
                    })
                    /*
                    customers route
                     */
                    .state('app.customer',{
                        url: '/customer',
                        templateUrl: 'app/component/shop/customers/index/views/index-customer.html',

                        resolve: load(['app/component/shop/customers/index/controllers/indexCustomersCtrl.js'])
                    })
                    .state('app.customer.table', {
                        url: 'customer/table',
                        templateUrl: 'app/component/shop/customers/read/views/table-customers.html',
                        resolve: load(['smart-table', 'app/component/shop/customers/read/controllers/tableCustomersCtrl.js'])
                    })

                    .state('app.customer.create', {
                        url: '/customer/create',
                        templateUrl: 'app/component/shop/customers/create/views/create-customer-form.html',

                        resolve: load(['app/component/shop/customers/create/controllers/createCustomerCtrl.js',
                            'app/component/core/controllers/googleTypeAheadController.js'])
                    })
                    .state('app.customer.update', {
                        url: '/customer/update/{customerId:int}',
                        templateUrl: 'app/component/shop/customers/update/views/update-customer.html',

                        resolve: load(['xeditable',
                            'app/component/shop/customers/update/controllers/updateCustomerCtrl.js',
                            'app/component/core/controllers/googleTypeAheadController.js'])
                    })

                    /*
                    tickets routes
                     */

                    .state('app.ticket', {
                        url: '/ticket',
                        templateUrl: 'app/component/shop/tickets/index/views/index-ticket.html',

                        resolve: load(['app/component/shop/tickets/index/controllers/ticketIndexCtrl.js'])
                    })

                    .state('app.ticket.create', {
                        url: '/create/ticket/{customerId:int}', //! need CUstomer Id to create Ticket
                        templateUrl: 'app/component/shop/tickets/create/views/create-ticket-form.html',

                        resolve: load(['app/component/shop/tickets/create/controllers/createTicketCtrl.js'])
                    })

                    
                    .state('app.ticket.read-all', {
                    url: '/read/all/ticket',
                    templateUrl: 'app/component/shop/tickets/read/views/tickets-table.html',

                    resolve: load(['smart-table','app/component/shop/tickets/read/controllers/readTicketsCtrl.js'])
                    })
                    
                    .state('app.ticket.update', {
                        url: '/update/ticket/{ticketId:int}',
                        templateUrl: 'app/component/shop/tickets/update/views/update-ticket.html',

                        resolve: load(['xeditable','monospaced.qrcode' ,'AngularPrint',"ui.select",'app/component/shop/tickets/update/controllers/updateTicketCtrl.js'])
                    })
                /*
                Invoice Routes
                 */
                    .state('app.read-invoice', {
                        url: '/read/invoice/{invoiceId:int}',
                        templateUrl: 'app/component/shop/tickets/create/views/create-ticket-form.html',

                        resolve: load(['app/component/shop/tickets/create/controllers/createTicketCtrl.js'])
                    })
                    .state('app.create-invoice', {
                        url: '/create/invoice/{ticketId:int}',
                        templateUrl: 'app/component/shop/invoices/create/views/create-invoice.html',

                        resolve: load(['app/component/shop/invoices/create/controllers/createInvoiceCtrl.js'])
                    })
                /*
                Employyes Routes
                 public/app/component/shop/employee/index/views/employee-index.html
                 */
                    .state('app.employee', {
                        url: '/employee',
                        templateUrl: 'app/component/shop/employees/index/views/employee-index.html',
                        resolve: load(['app/component/shop/employees/index/controllers/employeesIndexCtrl.js'])

                    })
                    .state('app.employee.read-all', {
                        url: '/read/all/employees',
                        templateUrl: 'app/component/shop/employees/read/views/view-employees-table.html',
                        resolve: load(['app/component/shop/employees/read/controllers/readAllEmployeesCtrl.js'])
                    })
                    .state('app.employee.create', {
                        url: '/create/employee',
                        templateUrl: 'app/component/shop/employees/create/views/create-employee.html',
                        resolve: load(['app/component/shop/employees/create/controllers/createEmployeeCtrl.js'])
                    })
                    .state('app.employee.update', {
                        url: '/update/employee/{employeeId:int}',
                        templateUrl: 'app/component/shop/employees/update/views/update-employee.html',
                        resolve: load(['xeditable','app/component/shop/employees/update/controllers/updateEmployeeCtrl.js'])
                    })

                /*suppliers Route

                 */
                .state('app.supplier', {
                    url: '/supplier',
                    templateUrl: 'app/component/shop/suppliers/index/views/supplier-index.html',
                    resolve: load(['app/component/shop/suppliers/index/controllers/suppliersIndexCtrl.js'])

                })
                    .state('app.supplier.read-all', {
                        url: '/supplier/table',
                        templateUrl: 'app/component/shop/suppliers/read/views/view-suppliers-table.html',
                        resolve: load(['smart-table','app/component/shop/suppliers/read/controllers/readAllSuppliersCtrl.js'])
                    })
                    .state('app.supplier.create', {
                        url: '/create/supplier',
                        templateUrl: 'app/component/shop/suppliers/create/views/create-supplier.html',
                        resolve: load(['app/component/shop/suppliers/create/controllers/createSupplierCtrl.js'])
                    })
                    .state('app.supplier.update', {
                        url: '/update/supplier/{supplierId:int}',
                        templateUrl: 'app/component/shop/suppliers/update/views/update-supplier.html',
                        resolve: load(['xeditable','app/component/shop/suppliers/update/controllers/updateSupplierCtrl.js'])
                    })
                /*
                stock Route
                 */
                    .state('app.stock', {
                        url: '/stock',
                        templateUrl: 'app/component/shop/stocks/index/views/index-stock.html',
                        resolve: load(['app/component/shop/stocks/index/controllers/indexStockCtrl.js'])
                    })

                    .state('app.stock.create', {
                        url: '/stock/create',
                        templateUrl: 'app/component/shop/stocks/create/views/create-stock.html',
                        resolve: load(['app/component/shop/stocks/create/controllers/createStockCtrl.js'])
                    })

                    .state('app.stock.table', {
                    url: '/stock/table',
                    templateUrl: 'app/component/shop/stocks/read/views/table-stock.html',
                    resolve: load(['smart-table','app/component/shop/stocks/read/controllers/tableStockCtrl.js'])
                    })

                    .state('app.stock.update', {
                    url: '/stock/update/{stockId:int}',
                    templateUrl: 'app/component/shop/stocks/update/views/update-stock.html',
                    resolve: load(['xeditable','app/component/shop/stocks/update/controllers/updateStockCtrl.js'])
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
