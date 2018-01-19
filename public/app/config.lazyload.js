// lazyload config

angular.module('app')
    /**
   * jQuery plugin config use ui-jq directive , config the js and css files that required
   * key: function name of the jQuery plugin
   * value: array of the css js file located
   */
    .constant('JQ_CONFIG', {
            easyPieChart:   [   'assets/js/jquery-plugins/jquery.easy-pie-chart/dist/jquery.easypiechart.fill.js'],
            sparkline:      [   'assets/js/jquery-plugins/jquery.sparkline/dist/jquery.sparkline.retina.js'],
            plot:           [   'assets/js/jquery-plugins/flot/jquery.flot.js',
                'assets/js/jquery-plugins/flot/jquery.flot.pie.js',
                'assets/js/jquery-plugins/flot/jquery.flot.resize.js',
                'assets/js/jquery-plugins/flot.tooltip/js/jquery.flot.tooltip.min.js',
                'assets/js/jquery-plugins/flot.orderbars/js/jquery.flot.orderBars.js',
                'assets/js/jquery-plugins/flot-spline/js/jquery.flot.spline.min.js'],
            moment:         [   'assets/js/jquery-plugins/moment/moment.min.js'],
            screenfull:     [   'assets/js/jquery-plugins/screenfull/dist/screenfull.min.js'],
            slimScroll:     [   'assets/js/jquery-plugins/slimscroll/jquery.slimscroll.min.js'],
            sortable:       [   'assets/js/jquery-plugins/html5sortable/jquery.sortable.js'],
            nestable:       [   'assets/js/jquery-plugins/nestable/jquery.nestable.js',
                'assets/js/jquery-plugins/nestable/jquery.nestable.css'],
            filestyle:      [   'assets/js/jquery-plugins/bootstrap-filestyle/src/bootstrap-filestyle.js'],
            slider:         [   'assets/js/jquery-plugins/bootstrap-slider/bootstrap-slider.js',
                'assets/js/jquery-plugins/bootstrap-slider/bootstrap-slider.css'],
            chosen:         [   'assets/js/jquery-plugins/chosen/chosen.jquery.min.js',
                'assets/js/jquery-plugins/chosen/bootstrap-chosen.css'],
            TouchSpin:      [   'assets/js/jquery-plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js',
                'assets/js/jquery-plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css'],
            wysiwyg:        [   'assets/js/jquery-plugins/bootstrap-wysiwyg/bootstrap-wysiwyg.js',
                'assets/js/jquery-plugins/bootstrap-wysiwyg/external/jquery.hotkeys.js'],
            dataTable:      [   'assets/js/jquery-plugins/datatables/media/js/jquery.dataTables.min.js',
                'assets/js/jquery-plugins/plugins/integration/bootstrap/3/dataTables.bootstrap.js',
                'assets/js/jquery-plugins/plugins/integration/bootstrap/3/dataTables.bootstrap.css'],
            vectorMap:      [   'assets/js/jquery-plugins/bower-jvectormap/jquery-jvectormap-1.2.2.min.js',
                'assets/js/jquery-plugins/bower-jvectormap/jquery-jvectormap-world-mill-en.js',
                'assets/js/jquery-plugins/bower-jvectormap/jquery-jvectormap-us-aea-en.js',
                'assets/js/jquery-plugins/bower-jvectormap/jquery-jvectormap.css'],
            footable:       [   'assets/js/jquery-plugins/footable/dist/footable.all.min.js',
                'assets/js/jquery-plugins/footable/css/footable.core.css'],
            fullcalendar:   [
                       'assets/js/angular-library/angular-ui-calendar/gcal.js',
                'assets/js/angular-library/angular-ui-calendar/fullcalendar.min.css',
                'assets/js/angular-library/angular-ui-calendar/fullcalendar.min.js',

            ],
            daterangepicker:[   'assets/js/jquery-plugins/moment/moment.js',
                'assets/js/jquery-plugins/bootstrap-daterangepicker/daterangepicker.js',
                'assets/js/jquery-plugins/bootstrap-daterangepicker/daterangepicker-bs3.css'],
            pdfMake:['assets/js/jquery-plugins/pdfMake/pdfmake.js',
                'assets/js/jquery-plugins/pdfMake/vfs_fonts.js',
                'assets/js/jquery-plugins/pdfMake/html2canvas.js'],
            tagsinput:      [   'assets/js/jquery-plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.js',
                'assets/js/jquery-plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css'],
        signature:[
            'assets/js/jquery-plugins/signature-pad/signature_pad.min.js'
        ],
        underscore:[
            'assets/js/jquery-plugins/underscore/underscore-min.js'
        ],
        stripeJs:['https://js.stripe.com/v2/'],

        }
    )
    .constant('MODULE_CONFIG', [
            {
                name: 'ngGrid',
                files: [
                    'assets/js/angular-library/ng-grid/build/ng-grid.min.js',
                    'assets/js/angular-library/ng-grid/ng-grid.min.css',
                    'assets/js/angular-library/ng-grid/ng-grid.bootstrap.css'
                ]
            },
        {
            name:'ui.calendar',
            files:[
                'assets/js/angular-library/angular-ui-calendar/calendar.js']

        },
        {
            name:'mwl.calendar',
            files:[
                'assets/js/angular-library/angular-bootstrap-calendar/angular-bootstrap-calendar-tpls.min.js',
                'assets/js/angular-library/angular-bootstrap-calendar/angular-bootstrap-calendar.min.css'
            ]
        },
            {
                name: 'ui.grid',
                files: [
                    'assets/js/angular-library/angular-ui-grid/ui-grid.min.js',
                    'assets/js/angular-library/angular-ui-grid/ui-grid.min.css',
                    'assets/js/angular-library/angular-ui-grid/ui-grid.bootstrap.css'
                ]
            },
            {
                name: 'ui.select',
                files: [
                    'assets/js/angular-library/angular-ui-select/dist/select.min.js',
                    'assets/js/angular-library/angular-ui-select/dist/select.min.css'
                ]
            },
            {
                name:'angularFileUpload',
                files: [
                    'assets/js/angular-library/angular-file-upload/angular-file-upload.js'
                ]
            },

            {
                name: 'ngImgCrop',
                files: [
                    'assets/js/angular-library/ngImgCrop/compile/minified/ng-img-crop.js',
                    'assets/js/angular-library/ngImgCrop/compile/minified/ng-img-crop.css'
                ]
            },
            {
                name: 'angularBootstrapNavTree',
                files: [
                    'assets/js/angular-library/angular-bootstrap-nav-tree/dist/abn_tree_directive.js',
                    'assets/js/angular-library/angular-bootstrap-nav-tree/dist/abn_tree.css'
                ]
            },
            {
                name: 'textAngular',
                files: [
                    'assets/js/angular-library/textAngular/dist/textAngular-sanitize.min.js',
                    'assets/js/angular-library/textAngular/dist/textAngular.min.js'
                ]
            },
            {
                name: 'vr.directives.slider',
                files: [
                    'assets/js/angular-library/venturocket-angular-slider/build/angular-slider.min.js',
                    'assets/js/angular-library/venturocket-angular-slider/build/angular-slider.css'
                ]
            },
            {
                name: 'com.2fdevs.videogular',
                files: [
                    'assets/js/angular-library/videogular/videogular.min.js'
                ]
            },
            {
                name: 'com.2fdevs.videogular.plugins.controls',
                files: [
                    'assets/js/angular-library/videogular-controls/controls.min.js'
                ]
            },
            {
                name: 'com.2fdevs.videogular.plugins.buffering',
                files: [
                    'assets/js/angular-library/videogular-buffering/buffering.min.js'
                ]
            },
            {
                name: 'com.2fdevs.videogular.plugins.overlayplay',
                files: [
                    'assets/js/angular-library/videogular-overlay-play/overlay-play.min.js'
                ]
            },
            {
                name: 'com.2fdevs.videogular.plugins.poster',
                files: [
                    'assets/js/angular-library/videogular-poster/poster.min.js'
                ]
            },
            {
                name: 'com.2fdevs.videogular.plugins.imaads',
                files: [
                    'assets/js/angular-library/videogular-ima-ads/ima-ads.min.js'
                ]
            },
            {
                name: 'smart-view-table',
                files: [
                    'assets/js/angular-library/angular-smart-view-table/dist/smart-view-table.min.js'
                ]
            },
        {
            name: 'smart-table',
            files: [
                'assets/js/angular-library/angular-smart-table/dist/smart-table.min.js'
            ]
        },
        {
            name: 'ngDialog',
            files: [
                'assets/js/angular-library/angular-ngDialog/ngDialog.css',
                'assets/js/angular-library/angular-ngDialog/ngDialog-theme-default.css',
                'assets/js/angular-library/angular-ngDialog/ngDialog.min.js'
            ]
        },

        {
            name: 'monospaced.qrcode',
            files: [
                'assets/js/angular-library/angular-qr-code/angular-qrcode.min.js',
                'assets/js/angular-library/angular-qr-code/qrcode.js'
            ]
        },
        {
            name: 'ui.bootstrap.datetimepicker',
            files: [
                'assets/js/angular-library/angular-date-time-picker/datetime-picker.min.js'
            ]
        },
        {
            name: 'AngularPrint',
            files: [
                'assets/js/angular-library/angular-print/angularPrint.css',
                'assets/js/angular-library/angular-print/angularPrint.js'
            ]
        },
     
            {
                name: 'angular-skycons',
                files: [
                    'assets/js/angular-library/angular-skycons/angular-skycons.js'
                ]
            },
        {
            name: 'angular-autogrow',
            files: [
                'assets/js/angular-library/angular-autogrow-textbox/angular-autogrow.min.js'
            ]
        },
        {
            name: 'am.multiselect',
            files: [
                'assets/js/angular-library/angular-am.multiselect/multiselect-tpls.js' //multi select
            ]
        },
        {
            name: 'ngFileUpload',
            files: [
                'assets/js/angular-library/angular-ng-file-upload/ng-file-upload-all.min.js',
                'assets/js/angular-library/angular-ng-file-upload/ng-file-upload-shim.min.js'
                //our default file upload
            ]
        },
        {
            name: 'ui.tinymce',
            files: [
                'assets/js/angular-library/angular-ui-tinymce/tinymce.min.js',
                'assets/js/angular-library/angular-ui-tinymce/uitinymce.min.js'
                //our default file upload
            ]
        },
        {
            name: 'naif.base64',
            files: [
                'assets/js/angular-library/angular-base64-upload/angular-base64-upload.min.js'
                //our default file upload
            ]
        },
        {
            name: 'credit-cards',
            files: [
                'assets/js/angular-library/angular-credit-cards/angular-credit-cards.js'
                //our default file upload
            ]
        },
        {
            name: 'angular-stripe',
            files: [
                'assets/js/angular-library/angular-stripe/angular-stripe.js'
                //our default file upload
            ]
        },
        ]
    )
    // oclazyload config
    .config(['$ocLazyLoadProvider', 'MODULE_CONFIG', function($ocLazyLoadProvider, MODULE_CONFIG) {
        // We configure ocLazyLoad to use the lib script.js as the async loader
        $ocLazyLoadProvider.config({
            debug:  false,
            events: true,
            modules: MODULE_CONFIG
        });
    }]);

