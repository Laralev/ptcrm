<!DOCTYPE html>
<html lang="<?= $currlang ?>" dir="<?= $currlang == 'ar' ? 'rtl' : 'ltr' ?>">

<head>

    <?= $this->Html->charset() ?>

    <title>
        <?= __('sitename') ?> - <?= __($this->fetch('title')) ?>
    </title>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    <link rel="canonical" href="<?= $path ?>/<?= $currlang ?>" />
    
    <link rel="shortcut icon" href="<?=$app_folder?>/webroot/img/favicon/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="<?=$app_folder?>/webroot/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=$app_folder?>/webroot/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?=$app_folder?>/webroot/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?=$app_folder?>/webroot/img/favicon/site.webmanifest">

    <?php // Meta Tags 
    ?>
    <meta name="yandex-verification" content="3b51f14bd8b2b0f5" />
    <meta name="google-site-verification" content="6GpL8eaZQTeI60nFvqgMxnLu9-fdVbXUw5WXbvBLUso" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="Cache-control" content="public">
    <meta http-equiv="Cache-control" content="max-atge=120 ETag: x234dff">
    <meta http-equiv="Cache-control" content="max-age=31557600">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="robots" content="index, follow" />

    <?php // Meta SEO 
    ?>
    <meta name="generator" content="<?= __('sitename') ?> <?= __($metaDt['_title']) ?>" />
    <meta name="keywords" content="<?= __($metaDt['_keywords']) ?>" />
    <meta name="description" content="<?= __($metaDt['_description']) ?>" />
    <meta name="author" content="DevZonia" />
    <meta name="date" content="Jul. 10, 2019" />

    <?php // Meta Open Graph 
    ?>
    <meta property="og:title" content="<?= __($mainDt['site_main_title']) ?> <?= __($metaDt['_title']) ?>" />
    <meta property="og:url" content="<?= $mainDt["server_url"] . urldecode($mainDt['current_url']) ?>" />
    <meta property="og:description" content="<?= __($metaDt['_description']) ?>" />
    <meta property="og:type" content="article" />
    <meta property="og:image" content="<?= $mainDt['server_url'] ?><?= $metaDt['_photo'] ?>" />
    <meta property="og:locale" content="<?= $currlang . '_' . strtoupper($currlang) ?>" />

    <?php // Meta tags 
    ?>
    <?php $tags = explode(",", $metaDt['_keywords']);
    foreach ($tags as $tag) { ?>
        <meta property="article:tag" content="<?= $tag ?>" />
    <?php } ?>

    <?php // Twitter Meta tags 
    ?>
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:description" content="<?= __($metaDt['_description']) ?>" />
    <meta name="twitter:title" content="<?= __($metaDt['_title']) ?>" />
    <meta name="twitter:image" content="<?= $mainDt['server_url'] ?><?= $metaDt['_photo'] ?>" />

    <META NAME="robots" CONTENT="INDEX, FOLLOW">

    <?php

    //<!--  Style files  -->
    echo $this->Html->css('bootstrap.min');
    // echo $this->Html->css('fa6/css/all.min');
    // echo $this->Html->css('animate.min');
    echo $this->Html->css('style');
    

    //<!-- JavaScript files -->
    echo $this->Html->script('jquery-1.12.3.min');
    echo $this->Html->script('bootstrap.bundle.min');
    echo $this->Html->script('angular');
    // echo $this->Html->script('angular-animate.min');
    echo $this->Html->script('angular-sanitize.min');
    // echo $this->Html->script('myfunc');

    echo $this->Html->script('satellizer.min');
    
    ?>

</head>

<body ng-app="listingApp" ng-controller="ctrl as ctrl">

    <div class="main-cover"></div>

    <?php echo $this->element('header') ?>

    <div class="main-content">
        <?= $this->fetch('content'); ?>
    </div>

    <?= $this->element('footer'); ?>

    <div> <?php //echo $this->element('modal'); ?> </div>


    <div id="flash"></div>

    <div id="imgHolder" class="imgHolder" onClick="this.setAttribute('style', 'opacity:0; visibility:hidden;')"></div>
    <div id="slideHolder" class="imgHolder slideHolder" ></div>
    
    <?= $this->Flash->render() ?>

    <!-- ANGULARJS APP -->
    <script>
    (function() {

        var ptrn = [];
        ptrn['isEmail'] = /^[a-z]+[a-z0-9._]+@[a-z]+\.[a-z.]{2,7}$/;
        ptrn['isNumber'] = /^[0-9]$/;
        ptrn['isInteger'] = /^[\s\d]$/;
        ptrn['isFloat'] = /^[0-9]?\d+(\.\d+)?$/;
        ptrn['isVersion'] = /^(?:(\d+)\.)?(?:(\d+)\.)?(\*|\d+)$/
        ptrn['isPassword'] = /^[A-Za-z0-9@#$%^&*()!_-]{4,32}$/;
        ptrn['isParagraph'] = /^[^()]{40,255}$/;
        ptrn['isEmpty'] = /^[^()]{3,255}$/; ///^((?!undefined).){3,255}$/;
        ptrn['isSelected'] = /^((?!undefined).){0,255}$/; ///^.{1,255}$/;
        ptrn['isZipcode'] = /^\+[0-9]{1,4}$/;
        ptrn['isPhone'] = /^[\s\d]{9,15}$/;
        ptrn['is4Digits'] = /^[0-9].{3,4}$/;

        var errorMsg = [];
        errorMsg['isEmail'] = '<?= __('is-email-msg') ?>';
        errorMsg['isNumber'] = '<?= __('is-number-msg') ?>';
        errorMsg['isInteger'] = '<?= __('is-integer-msg') ?>';
        errorMsg['isFloat'] = '<?= __('is-flaot-msg') ?>';
        errorMsg['isVersion'] = '<?= __('is-version-msg') ?>';
        errorMsg['isPassword'] = '<?= __('is-password-msg') ?>'; //Only Alphabet, Numbers and symboles @ # $ % ^ & * ( ) ! _ - allowed;
        errorMsg['isParagraph'] = '<?= __('is-paragraph-msg') ?>'; //Paragraph should be between 40 and 255 character;
        errorMsg['isEmpty'] = '<?= __('is-empty-msg') ?>';
        errorMsg['isSelected'] = '<?= __('is-selected-empty-msg') ?>';
        errorMsg['isPhone'] = '<?= __('is-phone-msg') ?>';
        errorMsg['is4Digits'] = '<?= __('is-4-digits-msg') ?>';

        var _setError = function(elm, msg, clr) {

            !msg ? msg = "" : msg;
            !clr ? clr = false : clr;

            var tar = $(elm).parent();
            if (elm.type == "checkbox") {
                tar = $(elm).parent().parent().parent()
            }
            if ($('.error-message', tar).html() == undefined) {
                $(tar).append('<div class="error-message"></div>');
            }
            $('.error-message', tar).text(msg)
        }

        var _getErrors = function(obj, form_name) {

            $(".error-message").text('');
            for (var prop in obj) {
                var value = obj[prop];
                if (typeof obj[prop] !== 'object') {
                    continue;
                }
                var arr = $.map(value, function(val, index) {
                    return [val];
                });
                var elm = $('#' + form_name + ' [name="' + prop + '"]');
                if (Array.isArray(elm)) {
                    _setError($('#' + form_name + ' [name="' + prop + '"]')[0], arr[0])
                } else {
                    _setError($('#' + form_name + ' [name="' + prop + '"]'), arr[0])
                }
            }
        }
        var _setDate = function(dt, p, mode) {

            !dt ? dt = '' : dt;
            !p ? p = [0, 0, 0, 0, 0, 0] : p;
            !mode ? mode = '' : mode;

            var now = new Date(dt);
            var year = now.getFullYear();
            var month = now.getMonth() + 1;
            var day = now.getDate();
            var hour = now.getHours();
            var minute = now.getMinutes();
            var second = now.getSeconds();

            year += (p[0] * 1);
            month += (p[1] * 1);
            day += (p[2] * 1);
            hour += (p[3] * 1);
            minute += (p[4] * 1);
            second += (p[5] * 1);

            if (month.toString().length == 1) { month = '0' + month; }
            if (day.toString().length == 1) { day = '0' + day; }
            if (hour.toString().length == 1) { hour = '0' + hour; }
            if (minute.toString().length == 1) { minute = '0' + minute; }
            if (second.toString().length == 1) { second = '0' + second; }
            var res = year + '-' + month + '-' + day + ' ' + hour + ':' + minute + ':' + second;
            if (mode.indexOf('onlydate') > -1) {
                res = year + '-' + month + '-' + day;
            }
            if (mode.indexOf('onlytime') > -1) {
                res = hour + ':' + minute + ':' + second;
            }
            return res;
        }

        var millisecondsToTime = function(milliseconds) {
            var hours = milliseconds / (1000 * 60 * 60);
            var absoluteHours = Math.floor(hours);
            var h = absoluteHours > 9 ? absoluteHours : '0' + absoluteHours;

            var minutes = (hours - absoluteHours) * 60;
            var absoluteMinutes = Math.floor(minutes);
            var m = absoluteMinutes > 9 ? absoluteMinutes : '0' + absoluteMinutes;

            var seconds = (minutes - absoluteMinutes) * 60;
            var absoluteSeconds = Math.floor(seconds);
            var s = absoluteSeconds > 9 ? absoluteSeconds : '0' + absoluteSeconds;

            return h + ':' + m + ':' + s;
        }
        
        var DtSetter = function(tar, val) {
            var defines = {
                'bool': { 0: '<?= __('disabled') ?>', 1: '<?= __('enabled') ?>' },
                'bool2': { 
                    0: '<i class="fa fa-times-circle-o redText" title="<?= __('disabled') ?>"></i>', 
                    1: '<i class="fa fa-check-circle-o greenText" title="<?= __('enabled') ?>"></i>', 
                    2: '<i class="fa fa-bookmark orangeText" title="<?= __('sold') ?>"></i>' 
                },
                'bool3': { 0: '<?= __('no') ?>', 1: '<?= __('yes') ?>' },
                'roles': JSON.parse('<?= json_encode($this->Do->lcl($this->Do->get('roles'))) ?>'),
                'language_id': JSON.parse('<?= json_encode($this->Do->lcl($this->Do->get('langs'))) ?>'),
            }
            
            if (val=='list') { return defines[tar]; }
            if (!defines[tar]) { return val; }
            if (!defines[tar][val]) { return val; }

            return defines[tar][val];
        }

        var nFormat = function(v, _unit, _round) {
            !_unit ? _unit = '' : _unit;
            if (!v) { return 0 };
            var res = Math.floor(v).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") ;
            if(v > 9999){res = res.slice(0, -3)+'000';}
            return res+ ' ' + _unit;
        };

        var listingApp = angular.module('listingApp', [
            // 'ngAnimate',
            // 'ngSanitize',
            'satellizer',
            //=$authUser != null ? ", 'ckeditor'" : ''?>
            //=$isChart == 1 ? ", 'googlechart'" : ''?>
        ]); //'ngTagsInput'

        listingApp.controller('ctrl', function($scope, $http, $location, $timeout, $q, $auth) {

            $scope.filesInfo = {
                section_photo: []
            }
            $scope.files = {
                "sections": []
            };

            $scope.app_folder = '<?php echo $app_folder ?>';
            $scope.currlang = '<?php echo $currlang ?>';
            $scope.param1 = '<?= empty($this->request->getParam('pass')[0]) ? '' : $this->request->getParam('pass')[0] ?>';

            $scope.lists = {
                users: [],
                categories: [],
            }
            
            const rec_origin = {
                user: {remember_me:true},
                category: {parent_id:null, category_name:null}
            }

            $scope.rec = {
                user: rec_origin.user,
                category: rec_origin.category,
            }
            
            $scope.newEntity = function(tar, val) {
                $scope.rec[tar] = val;
            }           

            $scope.DtSetter = function(tar, val) {
                return DtSetter(tar, val)
            }
            
            $scope.nFormat = function(v, unit, round) {
                return nFormat(v, unit, round)
            }
            
            $scope.getPhoto = function(fileToUpload, photo, folder) {
                !fileToUpload ? fileToUpload = false : fileToUpload;
                !photo ? photo = '' : photo;
                !folder ? folder = '' : folder;
                if (fileToUpload) {
                    return fileToUpload.tmp_name;
                }
                var path = '<?= $app_folder ?>/img/' + folder + '_photos/thumb'
                if (photo.length > 3) {
                    return path + '/' + photo
                }
                return path + '/noimg.svg'
            }

            $scope.rounder = function(n) {
                return Math.floor(n)
            }

            $scope.rand = function(n) {
                return Math.floor(Math.random() * n)
            }

            $scope.toArr = function(num) {
                var arr = [];
                for(var i=0; i<num; i++){ arr[i] = i }
                return arr
            }

            $scope.closeModal = function(tar){
                $(tar).modal('hide');
            }

            $scope.openModal = function(tar){
                $('.close').click();
                $timeout(function(){
                    $(tar).modal('show');
                }, 510)
            }
            $scope.toElm = function(tar) {
                var elmTarget2 = $('#' + tar);
                if (elmTarget2.length > 0) {
                    $("html, body").animate({
                        scrollTop: elmTarget2.offset().top + " "
                    }, 1000);
                }
            }

            var _setCvrBtn = function(tar, param, icon) {
                
                tar = (tar[0]!='.' || tar[0]!='#') ? '#'+tar : tar ;
                !icon ? icon = false : icon;
                
                var span = $(tar + " > span");
                var btn = $(tar);
                if (param == 1) {
                    span.html('<i class="fa fa-soild fa-spinner fa-pulse"></i>');
                    btn.css("pointer-events", "none");
                    btn.attr("disabled", true);
                } else {
                    if (icon) {
                        span.html('<i class="fa fa-solid fa-' + icon + '"> </i>');
                    } else {
                        span.html('')
                    }
                    btn.css("pointer-events", "all");
                    btn.attr("disabled", false);
                }
            }

            _doClick = function(tar) {
                setTimeout(() => {
                    $(tar).click();
                }, 500)
            }

            $scope.doClick = function(tar) {
                return _doClick(tar)
            }

            var headers = {
                'X-CSRF-Token': '<?= $_Token ?>',
                '_Token': '<?= $_Token ?>',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }

            // FUNCTIONS STARTED 

            $scope.setDate = function(dt, p, mode) {
                return _setDate(dt, p, mode)
            }

            /////////// Modal and Message ///////////////
            var _opAlert = function(msg, color) {
                !color ? color = 'default' : color;
                $('#flash').html(`
                        <div class='message ` + color + `' onclick="closeHolder('flash');"> 
                            <span><h3><?=__('system_message')?></h3> 
                            <i class='fas fa-times'></i> ` + msg + `</span>
                        </div>`);
                $timeout(function(){
                    $('#flash .message').addClass('showAlert');
                }, 100);
            }

            $scope.opAlert = function(msg, color) {
                _opAlert(msg, color)
            }
            /////////// End Modal and Message ///////////////

            /////////// Data Handling Functions ///////////////
            var _doRequest = function(url, obj, method) {

                !method ? method = 'get' : method;
                !obj ? obj = null : obj;

                // url.indexOf($scope.currlang) > -1 ? url : url = '/' + $scope.currlang + url
                url.indexOf($scope.app_folder) > -1 ? url : url = $scope.app_folder + url

                var requestObj = {
                    method: method,
                    url: url,
                    data: obj,
                    headers: headers
                }

                return $http(requestObj)
            }

            $scope.doGet = function(url, type, tar) {
                !type ? type = 'list' : type
                _doRequest(url, null, 'get').then(function(res) {
                    if (type == 'list') {
                        $scope.lists[tar] = res.data.data;
                        if (res.data.paging) {
                            $scope.paging = res.data.paging
                        }
                    } else {
                        $scope.rec[tar] = res.data.data
                    }
                })
            }

            $scope.doSave = function(orginialObj, tar, ctrl) {
                !tar ? tar = 'package' : tar;
                !ctrl ? ctrl = '<?= strtolower($this->request->getParam("controller")) ?>' : tar;

                var obj = {}
                Object.assign(obj, orginialObj);

                !obj.id ? obj.id = -1 : obj.id;

                var defer = $q.defer();
                var method = obj.id > -1 ? "PUT" : "POST";
                defer.resolve(
                    _doRequest('/' + ctrl + '/save/' + obj.id , obj, method, 'save_' + tar + '_btn', 'save', tar + '_form')
                )
                var done = defer.promise;
                done.then(function(res) {
                    if (res.data.status == 'SUCCESS') {
                        _opAlert('<?= __("save-success") ?>', "success");
                        setTimeout(() => {
                            $scope.filesInfo = {};
                            if (ctrl == 'categories') {
                                $scope.doGet('/' + ctrl + '?list=1', 'list', ctrl);
                                $scope.doGet('/' + ctrl + '/?list=1&col=parent_id&k=12', 'list', 'sections');
                            }else if (ctrl == 'sections') {
                                $scope.doGet('/packages?list=1', 'list', 'packages');
                                $scope.doGet('/packages?id=' + res.data.data.package_id, 'package', 'package');
                            } else {
                                $scope.doGet('/' + ctrl + '?list=1', 'list', ctrl);
                                $scope.doGet('/' + ctrl + '?id=' + res.data.data.id, tar, tar);
                            }
                        }, 1500)
                    } else {
                        _opAlert('<?= __("save-fail") ?>', "error")
                        console.log(res)
                    }
                })
                
            }

            $scope.doDelete = function(url, doUpdate) {
                if (confirm("<?= __('delete_confirm') ?>")) {
                    _doRequest(url, "", "POST").then(function(res) {
                        if (res.data.status == 'SUCCESS') {
                            if (doUpdate) {
                                _doClick(doUpdate)
                            }
                        } else {
                            console.log(res.data)
                        }
                    })
                }
            }
            /////////// END Data Handling Functions ///////////////


            /////////// Users Operations ////////////////////
            $scope.doRegister = function() {
                _setCvrBtn("register_btn", 1, "user-plus")
                _doRequest("/register", $scope.rec.user, 'POST').then(function(res) {
                    _setCvrBtn("register_btn", 0, "user-plus")
                    if (res.data.status == 'SUCCESS') {
                        _opAlert('<?= __("register-success") ?>', "success")
                        $('#register_mdl [data-dismiss="modal"]').click();
                    } else {
                        _getErrors(res.data, 'reg_form')
                        _opAlert('<?= __("register-fail") ?>', "error")
                    }
                }, function(res) {
                    console.log("register fail ", res)
                });
            }

            $scope.doLogin = function(dt) {
                _setCvrBtn("login_btn", 1)
                _doRequest("/login", dt||$scope.rec.user, "POST").then(function(res) {
                    _setCvrBtn("login_btn", 0, "sign-in-alt")
                    if (res.data.status == 'SUCCESS') {
                        _opAlert(res.data.msg || '<?= __("login-success") ?>', "success");
                        $timeout(function(){
                            window.location.href = res.data.redirect || $scope.app_folder + '/<?=$currlang?>';
                        },500);
                    } else {
                        if (res.data.status == "NOT_ACTIVE") {
                            return _opAlert('<?= __("account_not_active") ?>', "error");
                        }
                        return _opAlert('<?= __("login-fail") ?>', "error");
                    }
                }, function(err) {
                    _setCvrBtn("login_btn", 0, "sign-in-alt")
                });
            }

            $scope.doGetPassword = function() {
                _setCvrBtn('getpassword_btn', 1);
                _doRequest("/users/getpassword", $scope.rec.user, "POST").then(function(res) {
                    _setCvrBtn('getpassword_btn', 0, 'lock');
                    if (res.data.status == 'SUCCESS') {
                        _opAlert(res.data.msg || '<?= __("send-success") ?>', "success");
                        $('#getpassword_mdl').modal('hide');
                    } else {
                        _opAlert(res.data.msg || '<?= __("send-fail") ?>', "error");
                    }
                }, function(res) {
                    _opAlert(res.data.msg || '<?= __("send-fail") ?>', "error");
                    _setCvrBtn('getpassword_btn', 0, 'lock');
                })
            }
            
            // social media login
            $scope.authenticate = function(provider) {
                $auth.authenticate(provider).then(function(response) {
                    console.log(response)
                    alert(1)
                    window.location.reload();
                })
                .catch(function(err) {
                    console.log(err);
                    alert(0)
                });;
            };
            $scope.logout = function(){
                $auth.logout();
            }
            $scope.isAuth = function(){
                alert( $auth.isAuthenticated() );
            }
            
            /////////// End Users Operations ////////////////////


                if('<?=$this->request->getQuery('autologin') ? 1 : 0?>' == 1){
                    let dt = {
                        autologin: '<?=$this->request->getQuery('autologin')?>',
                        changePassword: '<?=$this->request->getQuery('changePassword') ? 1 : 0 ?>'
                    } 
                    $scope.doLogin(dt);
                }
                if('<?=isset( $_COOKIE['RMMBRME_ID']) && empty($authUser)  ? 1 : 0?>' == 1){
                    $scope.doLogin();
                }
                

        });
        
        // Soccial Media Auth Provider //////////////////////////////////////////////////////
        listingApp.config(function($authProvider) {

            $authProvider.facebook({
                clientId: '801648356909373', //f4bc5caa69c798f5ed8ff6157f1b99df
                url: '/users/register/?auth=facebook',
                authorizationEndpoint: 'https://www.facebook.com/v2.5/dialog/oauth',
                redirectUri: window.location.origin + '/',
                requiredUrlParams: ['display', 'scope'],
                scope: ['email'],
                scopeDelimiter: ',',
                display: 'popup',
                oauthType: '2.0',
                popupOptions: { width: 580, height: 400 }
            });

            // Optional: For client-side use (Implicit Grant), set responseType to 'token' (default: 'code')
            // $authProvider.facebook({
            //     clientId: 'Facebook App ID',
            //     responseType: 'token'
            // });

            $authProvider.google({
                clientId: '750390202595-n09jvq0gf5ugsgohhdfnpl6fmp1mptgf.apps.googleusercontent.com',
                
                url: '/users/register/?auth=google',
                authorizationEndpoint: 'https://accounts.google.com/o/oauth2/auth',
                redirectUri: window.location.origin,
                requiredUrlParams: ['scope'],
                optionalUrlParams: ['display'],
                scope: ['profile', 'email'],
                scopePrefix: 'openid',
                scopeDelimiter: ' ',
                display: 'popup',
                oauthType: '2.0',
                popupOptions: { width: 452, height: 633 }
            });

            $authProvider.github({
                clientId: 'GitHub Client ID'
            });

            $authProvider.linkedin({
                clientId: '7743w5nngwpx3q'
            });

            $authProvider.instagram({
                clientId: 'Instagram Client ID'
            });

            $authProvider.yahoo({
                clientId: 'Yahoo Client ID / Consumer Key'
            });

            $authProvider.live({
                clientId: 'Microsoft Client ID'
            });

            $authProvider.twitch({
                clientId: 'Twitch Client ID'
            });

            $authProvider.bitbucket({
                clientId: 'Bitbucket Client ID'
            });

            $authProvider.spotify({
                clientId: 'Spotify Client ID'
            });

            // No additional setup required for Twitter

            $authProvider.oauth2({
                name: 'foursquare',
                url: '/auth/foursquare',
                clientId: 'Foursquare Client ID',
                redirectUri: window.location.origin,
                authorizationEndpoint: 'https://foursquare.com/oauth2/authenticate',
            });

        });

        // Directives //////////////////////////////////////////////////////
        listingApp.directive("showImg", function() {
            return {
                link: function(scope, elm, attrs, ngModel) {
                    elm.bind('click', function(e) {

                        if (attrs.src.indexOf(".svg") > 0) { return ""; }
                        if (attrs.src.indexOf("noimg") > 0) { return ""; }
                        
                        if(attrs.showImg != ''){
                            
                            $('#slideHolder').attr("style", "opacity: 1; z-index:1111;");
                            
                            var imgs_array = attrs.showImg.split(','), 
                                imgs='';

                            var ctrl = !attrs.ctrl ? '<?=strtolower( $this->request->getParam('controller') )?>' : attrs.ctrl;

                            for( let img in  imgs_array){
                                imgs += `
                                    <div class="carousel-item `+(attrs.curr == imgs_array[img] ? 'active' : '')+`">
                                        <img class="" src="<?=$app_folder?>/img/`+ctrl+`_photos/` + imgs_array[img] + `" />
                                    </div>
                                    `;
                            }
                            
                            $('#slideHolder').html(`
                                <i class="fa fa-times" aria-hidden="true" onClick="document.getElementById('slideHolder').setAttribute('style', 'opacity:0; visibility:hidden;')"></i>
                                <div id="imgs_slider" class="carousel slide carousel-fade imgs_slider" data-ride="carousel">
                                    <div class="carousel-inner">
                                        `+imgs+`
                                    </div>
                                    <a class="carousel-control-prev" href="#imgs_slider" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#imgs_slider" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            `);
                        }else{
                            $('#imgHolder').attr("style", "opacity: 1; z-index:1111;");
                            $('#imgHolder').html('<img src="' + attrs.src.replace("thumb/", "") + '"><i class="fa fa-times" aria-hidden="true"></i>');
                        }
                    })
                }
            }
        });
        
        listingApp.directive("fullHieght", function() {
            return {
                link: function(scope, elm, attrs, ngModel) {
                    $(elm).css('min-height', $(window).height() )
                }
            }
        });

    })();

    setTimeout(() => {
        jQuery('.main-cover').fadeOut("slow");
    }, 1000)

    function closeHolder(tar) {
        if(tar == 'flash'){
            return $('#'+tar+' .message').removeClass('showAlert');
        }
        var elm = document.getElementById(tar)
        elm.setAttribute('style', 'opacity:0;');
        setTimeout(() => {
            elm.setAttribute('style', 'display:none;');
        }, 500);
    }

    // if (window.location.href.indexOf('login=1') > -1) {
    //     $("#login_mdl_btn")[0].click();
    // }
    
    $(document).bind('keyup', function(e) {
        if (e.keyCode==39) {
            $('.carousel-control-next-icon').trigger('click');
        }else if(e.keyCode==37){
            $('.carousel-control-prev-icon').trigger('click');
        }
    });
    
    </script>

    <div id="bottom_div"></div>

</body>

</html>
