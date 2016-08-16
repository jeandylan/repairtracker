// config

var app =  
angular.module('app')
  .config(
    [        '$controllerProvider', '$compileProvider', '$filterProvider', '$provide',
    function ($controllerProvider,   $compileProvider,   $filterProvider,   $provide) {
        
        // lazy controller, directive and service
        app.controller = $controllerProvider.register;
        app.directive  = $compileProvider.directive;
        app.filter     = $filterProvider.register;
        app.factory    = $provide.factory;
        app.service    = $provide.service;
        app.constant   = $provide.constant;
        app.value      = $provide.value;
    }
  ])
  .config(['$translateProvider', function($translateProvider){
    // Register a loader for the static files
    // So, the module will search missing translation tables under the specified urls.
    // Those urls are [prefix][langKey][suffix].
    $translateProvider.useStaticFilesLoader({
      prefix: 'app/component/core/translation/',
      suffix: '.js'
    });
    // Tell the module what language to use by default
    $translateProvider.preferredLanguage('en');
    // Tell the module to store the language in the local storage
    $translateProvider.useLocalStorage();
  }]);


'use strict';

/* Controllers */

angular.module('app')
    .controller('appInit', ['$scope', '$translate', '$localStorage', '$window',
        function(              $scope,   $translate,   $localStorage,   $window ) {
            // add 'ie' classes to html
            var isIE = !!navigator.userAgent.match(/MSIE/i);
            isIE && angular.element($window.document.body).addClass('ie');
            isSmartDevice( $window ) && angular.element($window.document.body).addClass('smart');

            // config
            $scope.app = {
                name: 'tester',
                version: '2.0.3',
                // for chart colors
                color: {
                    primary: '#7266ba',
                    info:    '#23b7e5',
                    success: '#27c24c',
                    warning: '#fad733',
                    danger:  '#f05050',
                    light:   '#e8eff0',
                    dark:    '#3a3f51',
                    black:   '#1c2b36'
                },
                settings: {
                    themeID: 1,
                    navbarHeaderColor: 'bg-black',
                    navbarCollapseColor: 'bg-white-only',
                    asideColor: 'bg-black',
                    headerFixed: true,
                    asideFixed: false,
                    asideFolded: false,
                    asideDock: false,
                    container: false
                }
            };
            $scope.SettingsCardBackgroundStyle = {
                "background-color" : "#03A9F4",
                "font-size" : "3em",
                "padding" : "0.5em"
            };



            $scope.cardTextStyle={
                "color": "#DCEDC8",
                'font-size':'120%'
            };
            $scope.cardBackground={
                "background-color" : '#F9FBE7',
                "color":"#1A237E"
            };

            $scope.yesNo=[{value:0,text:'no'},{value:1,text:'yes'}];

            // save settings to local storage
            if ( angular.isDefined($localStorage.settings) ) {
                $scope.app.settings = $localStorage.settings;
            } else {
                $localStorage.settings = $scope.app.settings;
            }
            $scope.$watch('app.settings', function(){
                if( $scope.app.settings.asideDock  &&  $scope.app.settings.asideFixed ){
                    // aside dock and fixed must set the header fixed.
                    $scope.app.settings.headerFixed = true;
                }
                // for box layout, add background image
                $scope.app.settings.container ? angular.element('html').addClass('bg') : angular.element('html').removeClass('bg');
                // save to local storage
                $localStorage.settings = $scope.app.settings;
            }, true);

            // angular translate
            $scope.lang = { isopen: false };
            $scope.langs = {en:'English', fr:'francais', it_IT:'Italian'};
            $scope.selectLang = $scope.langs[$translate.proposedLanguage()] || "English";
            $scope.setLang = function(langKey, $event) {
                // set the current lang
                $scope.selectLang = $scope.langs[langKey];
                // You can change the language during runtime
                $translate.use(langKey);
                $scope.lang.isopen = !$scope.lang.isopen;
            };

            function isSmartDevice( $window )
            {
                // Adapted from http://www.detectmobilebrowsers.com
                var ua = $window['navigator']['userAgent'] || $window['navigator']['vendor'] || $window['opera'];
                // Checks for iOs, Android, Blackberry, Opera Mini, and Windows mobile devices
                return (/iPhone|iPod|iPad|Silk|Android|BlackBerry|Opera Mini|IEMobile/).test(ua);
            }

        }]);

angular.module('app').controller("shopAppCtrl",function ($scope,serverServices,toaster,editableOptions) {
    editableOptions.theme = 'bs3';  //the editable theme for xeditable injection should always be used else calendar and type ahead for address fails
     $scope.updateResource=function (url, data) {
         console.log('start updating');
        return serverServices.put(url, data)//id parameter obtain by doing state parameter (like a query)
            .then(
                function (result) {
                    console.log(result);
                    (result.successful) ? toaster.pop("success", 'success', result.message) :
                        toaster.pop("warning", 'info:', result.message);
                    return result

                },
                function (result) {
                    // toaster.pop('error', "server Err", "we could not get info needed");
                    console.log(result);
                    toaster.pop('error', "server Err", result.message);
                    return result;
                    //could not get response from Server

                });
    };

    $scope.createResource=function (url, data){
        console.log('start creatinon');
        return serverServices.post(url, data)//id parameter obtain by doing state parameter (like a query)
            .then(
                function (result) {
                    (result.successful) ? toaster.pop("success", 'success', result.message) :
                        toaster.pop("warning", 'info:', result.message);
                    return result;

                },
                function (result) {
                    // toaster.pop('error', "server Err", "we could not get info needed");
                    console.log(result);
                    toaster.pop('error', "server Err", result.message);
                    //could not get response from Server
                });
    }
});

