<!DOCTYPE html>
<html lang="en" data-ng-app="app">
<head>
    <meta charset="utf-8" />
    <title>repair tracker</title>
    <meta name="description" content="repair tracking System 2.0" />
    <meta name="keywords" content="repair ,repair tracker" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <link rel="stylesheet" href="assets/css/animate.css/animate.css" type="text/css" />
    <link rel="stylesheet" href="assets/fonts/font-awesome/css/font-awesome.min.css" type="text/css" />
    <link rel="stylesheet" href="assets/fonts/simple-line-icons/css/simple-line-icons.css" type="text/css" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css" />

    <link rel="stylesheet" href="assets/css/font.css" type="text/css" />
    <link rel="stylesheet" href="assets/css/app.css" type="text/css" />
    <link rel="stylesheet" href="assets/js/angular-library/angular-xeditable/dist/css/xeditable.min.css" type="text/css">
</head>

<body ng-controller="config"> <!--config .js--->
<div class="app" id="app" ng-class="{'app-header-fixed':app.settings.headerFixed, 'app-aside-fixed':app.settings.asideFixed, 'app-aside-folded':app.settings.asideFolded, 'app-aside-dock':app.settings.asideDock, 'container':app.settings.container}" ui-view>


</div>



<!-- jQuery -->
<script src="assets/js/jquery.js"></script>
<!-- Bootstrap -->
<script src="assets/js/bootstrap.min.js"></script>
<!-- Angular -->
<!-- Angular -->
<script src="assets/js/angular-library/angular/angular1.5.min.js"></script>
<!-- bootstrap this is breaking the previous  nav bar pop up -->
<script src="assets/js/angular-library/angular-bootstrap/ui-bootstrap-tpls-2.0.1.min.js"></script>

<script src="assets/js/angular-library/angular-animate/angular-animate.js"></script>
<script src="assets/js/angular-library/angular-aria/angular-aria.js"></script>
<script src="assets/js/angular-library/angular-cookies/angular-cookies.js"></script>
<script src="assets/js/angular-library/angular-messages/angular-messages.js"></script>
<script src="assets/js/angular-library/angular-messages/angular-messages.js"></script>
<script src="assets/js/angular-library/angular-resource/angular-resource.js"></script>
<script src="assets/js/angular-library/angular-sanitize/angular-sanitize.js"></script>
<script src="assets/js/angular-library/angular-touch/angular-touch.js"></script>

<!-- toast -->
<script src="assets/js/angular-library/angularjs-toaster/toaster.min.js"></script>
<link rel="stylesheet" href="assets/js/angular-library/angularjs-toaster/toaster.min.css"  type="text/css">

<script src="assets/js/angular-library/angular-ui-router/release/angular-ui-router.js"></script>
<!--ui tab route Extension-->
<script src="assets/js/angular-library/anjular-ui-route-tab/ui-router-tabs.js"></script>

<script src="assets/js/angular-library/ngstorage/ngStorage.js"></script>
<script src="assets/js/angular-library/angular-ui-utils/ui-utils.js"></script>


<!-- lazyload -->
<script src="assets/js/angular-library/oclazyload/dist/ocLazyLoad.min.js"></script>
<script src="assets/js/angular-library/oclazyload/dist/angular-ui-router.min.js"></script>
<!-- translate -->
<script src="assets/js/angular-library/angular-translate/angular-translate.js"></script>
<script src="assets/js/angular-library/angular-translate-loader-static-files/angular-translate-loader-static-files.js"></script>
<script src="assets/js/angular-library/angular-translate-storage-cookie/angular-translate-storage-cookie.js"></script>
<script src="assets/js/angular-library/angular-translate-storage-local/angular-translate-storage-local.js"></script>
<script src="assets/js/angular-library/angular-breadcrumbs/angular-breadcrumb.min.js"></script>
<script src='assets/js/angular-library/angular-xeditable/dist/js/xeditable.min.js'></script>

<!----app still need router --->
<script src="app/app.js"></script>
<script src="app/config.js"></script>
<script src="app/config.lazyload.js"></script>
<script src="app/component/core/route/mainRouter.js"></script>



<!----core for App ---->
<script src="app/component/core/services/ui-load.js"></script>

<script src="app/component/core/filters/fromNow.js"></script>
<script src="app/component/core/directives/setnganimate.js"></script>
<script src="app/component/core/directives/ui-butterbar.js"></script>
<script src="app/component/core/directives/ui-focus.js"></script>
<script src="app/component/core/directives/ui-fullscreen.js"></script>
<script src="app/component/core/directives/ui-jq.js"></script>
<script src="app/component/core/directives/ui-module.js"></script>
<script src="app/component/core/directives/ui-nav.js"></script>
<script src="app/component/core/directives/ui-scroll.js"></script>
<script src="app/component/core/directives/ui-shift.js"></script>
<script src="app/component/core/directives/ui-toggleclass.js"></script>
<script src="app/component/core/controllers/bootstrap.js"></script>
<!---contoller for login--->
<script src="app/component/shop/log-in-out/loginCtrl.js"></script>
<!----controller for logOut--->
<script src="app/component/shop/log-in-out/logOutCtrl.js"></script>
<!-----server service to query--->
<script src="app/component/core/services/serverServices.js"></script>
<!---delete Controller used By All CRUD Operation -->
<script src="app/component/shop/deleteConfirmation/controllers/deleteModalCtrl.js"></script>
<!---confirm Btn--- http://stackoverflow.com/questions/21815971/extend-angularui-popover-directive-to-create-a-confirm-popover--->
<script src="app/component/core/directives/delete-button.js"></script>

<!---Auth 0 plugin --->
<script src="assets/js/angular-library/angular-satellizer/satellizer.min.js"></script>

<!---cache Plugin--->
<script src="assets/js/angular-library/angular-cache/angular-cache.min.js"></script>

</body>
</html>
