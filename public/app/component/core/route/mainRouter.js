/**
 * Created by dylan on 16-Jun-16.
 */
var app =
    angular.module('app');

app.run(

    [ '$rootScope', '$state', '$stateParams',
        function ($rootScope,   $state,   $stateParams) {
            $rootScope.$state = $state;
            $rootScope.$stateParams = $stateParams;

        }
    ]
)
    .config(
        [          '$stateProvider', '$urlRouterProvider', 'JQ_CONFIG', 'MODULE_CONFIG',
            function ($stateProvider,   $urlRouterProvider, JQ_CONFIG, MODULE_CONFIG,$auth) {
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
                    .state('login',{
                        url:'/login',
                        templateUrl:'app/component/shop/log-in-out/log-in.html',
                    })

                    .state('app', {
                        url: '/app',
                        templateUrl: 'tpl/app.html',
                        ncyBreadcrumb: {
                            label: 'Home'
                        },
                        resolve:load(['smart-table','app/component/core/filters/otherFilter.js','app/shopAppCtrl.js','moment','ngDialog','ui.bootstrap.datetimepicker',
                            ]),


                    })


                    /*
                    customers route
                     */
                    .state('app.customer',{
                        url: '/customer',
                        templateUrl: 'app/component/shop/customers/index/views/index-customer.html',
                        resolve: load(['app/component/shop/customers/index/controllers/indexCustomersCtrl.js']),
                        ncyBreadcrumb: {
                            skip: true // Never display this state in breadcrumb.
                        },
                        pageTitle:'Customer  Panel'
                    })
                    .state('app.customer.table', {
                        url: '/table',
                        templateUrl: 'app/component/shop/customers/read/views/table-customers.html',
                        resolve: load(['app/component/shop/customers/read/controllers/tableCustomersCtrl.js']),

                        pageTitle:'Customers Table Panel',
                    })

                    .state('app.customer.create', {
                        url: '/create',
                        templateUrl: 'app/component/shop/customers/create/views/create-customer-form.html',
                        resolve: load(['app/component/shop/customers/create/controllers/createCustomerCtrl.js',
                            'app/component/core/controllers/googleTypeAheadController.js']),
                        pageTitle:'Customer create Panel'
                    })
                    .state('app.customer.update', {
                        url: '/update/{customerId:int}',
                        templateUrl: 'app/component/shop/customers/update/views/update-customer.html',

                        resolve: load([
                            'app/component/shop/customers/update/controllers/updateCustomerCtrl.js',
                            'app/component/core/controllers/googleTypeAheadController.js'])
                    })

                    /*
                    tickets routes
                     */

                    .state('app.ticket', {
                        url: '/ticket',
                        templateUrl: 'app/component/shop/tickets/index/views/index-ticket.html',
                        resolve: load(['app/component/shop/tickets/index/controllers/ticketIndexCtrl.js','ngDialog']),
                        ncyBreadcrumb: {
                            skip: true // Never display this state in breadcrumb.
                        },
                        pageTitle:'Ticket Panel'
                    })

                    .state('app.ticket.create', {
                        url: '/create?customerId&employeeId', //! pass customerId & employeeId as Query in uri
                        templateUrl: 'app/component/shop/tickets/create/views/create-ticket-form.html',
                        resolve: load(['app/component/shop/tickets/create/controllers/createTicketCtrl.js',
                            'app/component/shop/tickets/create/controllers/selectCustomerCtrl.js',//load controller needed by select dialog also
                            'app/component/shop/tickets/create/controllers/selectTechnicianCtrl.js',
                            'app/component/shop/tickets/create/controllers/createCustomerTicketCtrl.js', //load ctrl needed to create Customer
                            'app/component/core/controllers/googleTypeAheadController.js',
                            'app/component/shop/tickets/create/controllers/selectStockCtrl.js', //load Ctrl For select Stock
                            'AngularPrint','ui.bootstrap.datetimepicker',
                            'app/component/shop/tickets/create/controllers/createTicketCustomFieldsCtrl.js'
                        ]),
                        ncyBreadcrumb: {
                            skip: true // Never display this state in breadcrumb.
                        },
                        pageTitle:'Create Ticket Panel'
                    })

                    
                    .state('app.ticket.read-all', {
                        url: '/read/all',
                        templateUrl: 'app/component/shop/tickets/read/views/tickets-table.html',
                        resolve: load(['app/component/shop/tickets/read/controllers/readTicketsCtrl.js','moment']),
                        pageTitle:'Tickets Table Panel'
                    })

                    
                    .state('app.ticket.update', {
                        url: '/update/ticket/{ticketId:int}',
                        templateUrl: 'app/component/shop/tickets/update/views/update-ticket.html',
                        resolve: load(['monospaced.qrcode' ,'AngularPrint',"ui.select",
                            'app/component/shop/tickets/update/controllers/updateTicketCtrl.js',
                            'app/component/shop/tickets/update/controllers/ticketCommentCtrl.js', //comments Ctrl
                            'app/component/shop/tickets/update/controllers/ticketStockCtrl.js', //stock Ctrl
                            'app/component/shop/tickets/update/controllers/ticketTaskCtrl.js', //Task ctrl
                            'app/component/shop/tickets/update/controllers/selectStockCtrl.js',
                            'app/component/shop/tickets/update/controllers/selectTechnicianCtrl.js',
                            'app/component/shop/tickets/update/controllers/updateTicketCustomFieldsCtrl.js',
                            'pdfMake','ui.bootstrap.datetimepicker','signature' //should be include Every where
                        ]),
                    })
                        /*Estimtimation for ticket*/
                    .state('app.estimation', {
                        url: '/estimationCreate/{ticketId:int}',
                        templateUrl: 'app/component/shop/estimations/ticket-estimation.html',
                        resolve: load(['app/component/shop/estimations/ticketEstimationCtrl.js','app/component/shop/estimations/selectStockCtrl.js',
                           'ui.bootstrap.datetimepicker']),
                        pageTitle:'create estimation Panel'
                    })
                    .state('app.estimationPDF', {
                        url: '/estimationPDF/{ticketId:int}',
                        templateUrl: 'app/component/shop/estimations/ticket-estimation-PDF.html',
                        resolve: load(['app/component/shop/estimations/ticketEstimationPDFCtrl.js',
                            'moment','pdfMake','ui.bootstrap.datetimepicker','signature','am.multiselect','ngFileUpload']),
                        pageTitle:'Estimation Pdf'
                    })

                    /*Invoice*/
                    .state('app.invoice', {
                        url: '/invoiceCreate/{ticketId:int}',
                        templateUrl: 'app/component/shop/invoice/ticket-invoice.html',
                        resolve: load(['app/component/shop/invoice/ticketInvoiceCtrl.js','moment','pdfMake','ui.bootstrap.datetimepicker','signature',
                            'am.multiselect','ngFileUpload']),
                        pageTitle:'create Invoice Panel'
                    })


                        /*
                        task assigned to current Employee Route
                         */
                    .state('app.myTask', {
                        url: '/myTask',
                        templateUrl: 'app/component/shop/task/views/view-task.html',
                        resolve: load(['app/component/shop/task/controllers/viewTaskCtrl.js','moment'])
                    })




                /*
                Invoice Routes
                 */
                   /* .state('app.read-invoice', {
                        url: '/read/{invoiceId:int}',
                        templateUrl: 'app/component/shop/tickets/create/views/create-ticket-form.html',

                        resolve: load(['app/component/shop/tickets/create/controllers/createTicketCtrl.js'])
                    })

                    .state('invoice', {
                        url: '/create/invoice/{ticketId:int}',
                        view:{
                            'main':{
                                templateUrl: 'app/component/shop/invoices/create/views/create-invoice.html',
                                resolve: load(['app/component/shop/invoices/create/controllers/createInvoiceCtrl.js'])
                            }
                        }

                    })
                    .state('app.view-invoice', {
                        url: '/view/invoice/{ticketId:int}',
                        templateUrl: 'app/component/shop/invoices/read/views/view-invoice.html',

                        resolve: load(['app/component/shop/invoices/read/controllers/viewInvoiceCtrl.js','pdfMake','signature'])
                    })
                    */
                /*
                Employyes Routes
                 public/app/component/shop/employee/index/views/employee-index.html
                 */
                    .state('app.employee', {
                        url: '/employee',
                        templateUrl: 'app/component/shop/employees/index/views/employee-index.html',
                        resolve: load(['app/component/shop/employees/index/controllers/employeesIndexCtrl.js']),
                        ncyBreadcrumb: {
                            skip: true // Never display this state in breadcrumb.
                        }

                    })
                    .state('app.employee.read-all', {
                        url: '/read/all',
                        templateUrl: 'app/component/shop/employees/read/views/view-employees-table.html',
                        resolve: load(['app/component/shop/employees/read/controllers/readAllEmployeesCtrl.js']),
                        pageTitle:'Employee Table Panel'
                    })
                    .state('app.employee.create', {
                        url: '/create',
                        templateUrl: 'app/component/shop/employees/create/views/create-employee.html',
                        resolve: load(['app/component/shop/employees/create/controllers/createEmployeeCtrl.js']),
                        pageTitle:'Employee Create Panel'
                    })
                    .state('app.employee.update', {
                        url: '/update/{employeeId:int}',
                        templateUrl: 'app/component/shop/employees/update/views/update-employee.html',
                        resolve: load(['app/component/shop/employees/update/controllers/updateEmployeeCtrl.js'])
                    })
                        //All emp
                    .state('app.allEmployee', {
                        url: '/allEmployee',
                        templateUrl: 'app/component/shop/allEmployees/index/views/employee-index.html',
                        resolve: load(['app/component/shop/allEmployees/index/controllers/employeesIndexCtrl.js']),
                        ncyBreadcrumb: {
                            skip: true // Never display this state in breadcrumb.
                        }

                    })

                    .state('app.allEmployee.read-all', {
                        url: '/read/allEmp',
                        templateUrl: 'app/component/shop/allEmployees/read/views/view-employees-table.html',
                        resolve: load(['app/component/shop/allEmployees/read/controllers/readAllEmployeesCtrl.js']),
                        pageTitle:'All Employee'
                    })
                    .state('app.allEmployee.create', {
                        url: '/create/AllEmp',
                        templateUrl: 'app/component/shop/allEmployees/create/views/create-employee.html',
                        resolve: load(['app/component/shop/allEmployees/create/controllers/createEmployeeCtrl.js']),
                        pageTitle:'All Employee'
                    })
                    .state('app.allEmployee.update', {
                        url: '/updateAllEmp/{employeeId:int}',
                        templateUrl: 'app/component/shop/allEmployees/update/views/update-employee.html',
                        resolve: load(['app/component/shop/allEmployees/update/controllers/updateEmployeeCtrl.js'])
                    })



                /*suppliers Route

                 */
                .state('app.supplier', {
                    url: '/supplier',
                    templateUrl: 'app/component/shop/suppliers/index/views/supplier-index.html',
                    resolve: load(['app/component/shop/suppliers/index/controllers/suppliersIndexCtrl.js']),
                    ncyBreadcrumb: {
                        skip: true // Never display this state in breadcrumb.
                    }

                })
                    .state('app.supplier.read-all', {
                        url: '/supplier/table',
                        templateUrl: 'app/component/shop/suppliers/read/views/view-suppliers-table.html',
                        resolve: load(['app/component/shop/suppliers/read/controllers/readAllSuppliersCtrl.js'])
                    })
                    .state('app.supplier.create', {
                        url: '/create/supplier',
                        templateUrl: 'app/component/shop/suppliers/create/views/create-supplier.html',
                        resolve: load(['app/component/shop/suppliers/create/controllers/createSupplierCtrl.js'])
                    })
                    .state('app.supplier.update', {
                        url: '/update/supplier/{supplierId:int}',
                        templateUrl: 'app/component/shop/suppliers/update/views/update-supplier.html',
                        resolve: load(['app/component/shop/suppliers/update/controllers/updateSupplierCtrl.js',
                            'app/component/shop/suppliers/update/controllers/updateSuppliedStockCtrl.js',
                            'app/component/shop/suppliers/update/controllers/selectStockCtrl.js'

                        ])
                    })
                /*
                stock Route
                 */
                    .state('app.stock', {
                        url: '/stock',
                        templateUrl: 'app/component/shop/stocks/index/views/index-stock.html',
                        resolve: load(['app/component/shop/stocks/index/controllers/indexStockCtrl.js']),
                        ncyBreadcrumb: {
                            skip: true // Never display this state in breadcrumb.
                        },
                        pageTitle:'stock Panel' //cause cause trouble
                    })

                    .state('app.stock.create', {
                        url: '/create',
                        templateUrl: 'app/component/shop/stocks/create/views/create-stock.html',
                        resolve: load(['app/component/shop/stocks/create/controllers/createStockCtrl.js']),
                        pageTitle:'Create Stock Panel'
                    })

                    .state('app.stock.table', {
                        url: '/table',
                        templateUrl: 'app/component/shop/stocks/read/views/table-stock.html',
                        resolve: load(['app/component/shop/stocks/read/controllers/tableStockCtrl.js']),
                        pageTitle:'Stock Table Panel'
                    })

                    .state('app.stock.update', {
                    url: '/update/{stockId:int}',
                    templateUrl: 'app/component/shop/stocks/update/views/update-stock.html',
                    resolve: load(['app/component/shop/stocks/update/controllers/updateStockCtrl.js'])
                    })

                        /*Stock Location
                        *stock location route
                         */
                    .state('app.stockLocation', {
                    url: '/stockLocation',
                    templateUrl: 'app/component/shop/stocks-location/index/views/index-stock-location.html',
                    resolve: load(['app/component/shop/stocks-location/index/controllers/indexStockLocationCtrl.js']),
                    ncyBreadcrumb: {
                        skip: true // Never display this state in breadcrumb.
                    },
                    pageTitle:'this Location stock Panel' //cause cause trouble
                })
                    .state('app.stockLocation.table', {
                        url: '/tableStockLocation',
                        templateUrl: 'app/component/shop/stocks-location/read/read-stock-location.html',
                        resolve: load(['app/component/shop/stocks-location/read/readStockLocation.js']),
                        pageTitle:'Stock Location Table Panel'
                    })
                    .state('app.stockLocation.update', {
                        url: '/updateStockLocation/{stockLocationId:int}',
                        templateUrl: 'app/component/shop/stocks-location/update/update-stock-location.html',
                        resolve: load(['app/component/shop/stocks-location/update/updateStockLocation.js']),
                        pageTitle:'Stock Location Table Panel'
                    })
                        //purchase orders
                    .state('app.stockLocation.purchase', {
                        url: '/purchaseStock/{stockId:int}',
                        templateUrl: 'app/component/shop/puchaseOrder/purchase-order.html',
                        resolve: load(['app/component/shop/puchaseOrder/purchaseOrderCtrl.js','am.multiselect',
                            'app/component/shop/puchaseOrder/selectSuppliersForPurchaseOrdersCtrl.js','pdfMake','signature','ngFileUpload'])
                    })


                        /**calendar**/
                    .state('app.calendar',{
                        url:'/calendar',
                        templateUrl:'app/component/shop/calendar/views/calendar.html',
                        resolve: load(['moment','app/component/shop/calendar/controllers/calendarCtrl.js','mwl.calendar']),
                        pageTitle:'calendar' //cause cause trouble

                    })
                    /*Dash board */
                    .state('app.dashboard', {
                        url: '/dashboard',
                        templateUrl: 'app/component/shop/dashboard/index/views/index-dashboard.html',
                        resolve: load(['app/component/shop/dashboard/index/controllers/indexDashboardCtrl.js']),
                        pageTitle:'dashboard' ,//cause cause trouble,


            })
                    .state('app.dashboard.graph', {
                        url: '/dashboard/graph',
                        templateUrl: 'app/component/shop/dashboard/graph/dashboard-graph.html',
                        resolve: load(['app/component/shop/dashboard/graph/dashboardGraphCtrl.js']),
                        pageTitle:'dashoard graph' //cause cause trouble
                    })
                    /*form setting*/
                    /* things below made me crazy ,mind to put (ng-view when needed else be ready to loose 24 hr,debugging)*/
                    .state('app.settings', {
                        url: '/settings',
                        templateUrl: 'app/component/shop/shopSettings/index/views/shop-settings-index.html',
                        resolve: load(['app/component/shop/shopSettings/index/controllers/shopSettingsIndexCtrl.js']),
                        pageTitle:'Setting Panel' //cause cause trouble
                    })
                    .state('app.settings.gmail',{
                        url:'/gmail',
                        templateUrl:'app/component/shop/shopSettings/email/gmail-login.html'
                    })

                    .state('app.settings.form-editor', {
                        url: '/from-editor/{formName:string}',
                        templateUrl:'app/component/shop/shopSettings/formsEditor/views/form-editor.html',
                        resolve: load(['app/component/shop/shopSettings/formsEditor/controllers/formEditorCtrl.js']),
                        pageTitle:'' //cause cause trouble,defined into ctrl
                    })
                    .state('app.settings.customizeEstimationEmail',{
                    url: '/customizeEstimationEmail',
                    templateUrl:'app/component/shop/shopSettings/estimationEmail/customize-estimation-email.html',
                    resolve: load(['app/component/shop/shopSettings/estimationEmail/customizeEstimationEmailCtrl.js','ui.tinymce']),
                    pageTitle:'setting Invoice email' //cause cause trouble,defined into ctrl
                    })

                    .state('app.settings.customizeInvoiceEmail',{
                        url: '/customizeInvoiceEmail',
                        templateUrl:'app/component/shop/shopSettings/invoiceEmail/customize-invoice-email.html',
                        resolve: load(['app/component/shop/shopSettings/invoiceEmail/customizeInvoiceEmail.js','ui.tinymce']),
                        pageTitle:'setting Invoice email' //cause cause trouble,defined into ctrl

                    })

                    .state('app.settings.customizeColor',{
                    url: '/customizeColor',
                    templateUrl:'app/component/shop/shopSettings/shopColor/settingsColor.html',
                    resolve: load(['app/component/shop/shopSettings/shopColor/settingColorCtrl.js']),
                    pageTitle:'setting Invoice email' //cause cause trouble,defined into ctrl
                    })

                    .state('app.settings.updateRolePermission',{
                        url: '/updateRolePermission',
                        templateUrl:'app/component/shop/shopSettings/permissions/update-role-permissions.html',
                        resolve: load(['app/component/shop/shopSettings/permissions/updateRolePermissionsCtrl.js']),
                        pageTitle:'setting Role Permission' //cause cause trouble,defined into ctrl

                    })
                    .state('app.settings.payment',{
                        url: '/payment',
                        templateUrl:'app/component/shop/shopSettings/payment/payment.html',
                        resolve: load(['app/component/shop/shopSettings/payment/paymentCtrl.js','stripeJs','angular-stripe']),
                        pageTitle:'payment Role Permission' //cause cause trouble,defined into ctrl

                    })

                    .state('app.importExportData',{
                        url: '/importExportData',
                        templateUrl:'app/component/shop/importExportData/importExportData.html',
                        resolve: load(['app/component/shop/importExportData/importExportDataCtrl.js','naif.base64']),
                        pageTitle:'Import And Export DataImport' //cause cause trouble,defined into ctrl
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
