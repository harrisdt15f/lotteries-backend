<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>时代娱乐后台</title>

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('smart/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('smart/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('smart/css/smartadmin-production-plugins.min.css') }}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('smart/css/smartadmin-production.min.css') }}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('smart/css/smartadmin-skins.min.css') }}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('smart/css/smartadmin-rtl.min.css') }}">

    <link href="{{ asset('js/layui/css/layui.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
    <header id="header">
        <div id="logo-group">
            <span id="logo"> <img src="{{ asset('images/smart/log.png') }}" alt="财务管理"> </span>

            <!-- Note: The activity badge color changes when clicked and resets the number to 0
            Suggestion: You may want to set a flag when this happens to tick off all checked messages / notifications -->
            <span id="activity" class="activity-dropdown"> <i class="fa fa-user"></i> <b class="badge"> 21 </b> </span>

            <!-- AJAX-DROPDOWN : control this dropdown height, look and feel from the LESS variable file -->
            <div class="ajax-dropdown">

                <!-- the ID links are fetched via AJAX to the ajax container "ajax-notifications" -->
                <div class="btn-group btn-group-justified" data-toggle="buttons">
                    <label class="btn btn-default">
                        <input type="radio" name="activity" id="/ajax/notify/mail.php">
                        Msgs (14) </label>
                    <label class="btn btn-default">
                        <input type="radio" name="activity" id="/ajax/notify/notifications.php">
                        notify (3) </label>
                    <label class="btn btn-default">
                        <input type="radio" name="activity" id="/ajax/notify/tasks.php">
                        Tasks (4) </label>
                </div>

                <!-- notification content -->
                <div class="ajax-notifications custom-scroll">

                    <div class="alert alert-transparent">
                        <h4>Click a button to show messages here</h4>
                        This blank page message helps protect your privacy, or you can show the first message here automatically.
                    </div>

                    <i class="fa fa-lock fa-4x fa-border"></i>

                </div>
                <!-- end notification content -->

                <!-- footer: refresh area -->
                <span> Last updated on: 12/12/2013 9:43AM
                                    <button type="button" data-loading-text="<i class='fa fa-refresh fa-spin'></i> Loading..." class="btn btn-xs btn-default pull-right">
                                        <i class="fa fa-refresh"></i>
                                    </button> </span>
                <!-- end footer -->

            </div>
            <!-- END AJAX-DROPDOWN -->
        </div>

        <!-- projects dropdown -->
        <div class="project-context hidden-xs">

            <span class="label">Projects:</span>
            <span id="project-selector" class="popover-trigger-element dropdown-toggle" data-toggle="dropdown">Recent projects <i class="fa fa-angle-down"></i></span>

            <!-- Suggestion: populate this list with fetch and push technique -->
            <ul class="dropdown-menu">
                <li>
                    <a href="javascript:void(0);">Online e-merchant management system - attaching integration with the iOS</a>
                </li>
                <li>
                    <a href="javascript:void(0);">Notes on pipeline upgradee</a>
                </li>
                <li>
                    <a href="javascript:void(0);">Assesment Report for merchant account</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="javascript:void(0);"><i class="fa fa-power-off"></i> Clear</a>
                </li>
            </ul>
            <!-- end dropdown-menu-->

        </div>
        <!-- end projects dropdown -->

        <!-- pulled right: nav area -->
        <div class="pull-right">

            <!-- collapse menu button -->
            <div id="hide-menu" class="btn-header pull-right">
                <span> <a href="javascript:void(0);" title="Collapse Menu" data-action="toggleMenu"><i class="fa fa-reorder"></i></a> </span>
            </div>
            <!-- end collapse menu -->

            <!-- #MOBILE -->
            <!-- Top menu profile link : this shows only when top menu is active -->
            <ul id="mobile-profile-img" class="header-dropdown-list hidden-xs padding-5">
                <li class="">
                    <a href="#" class="dropdown-toggle no-margin userdropdown" data-toggle="dropdown">
                        <img src="/img/avatars/sunny.png" alt="John Doe" class="online" />
                    </a>
                    <ul class="dropdown-menu pull-right">
                        <li>
                            <a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0"><i class="fa fa-cog"></i> Setting</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#ajax/profile.php" class="padding-10 padding-top-0 padding-bottom-0"> <i class="fa fa-user"></i> <u>P</u>rofile</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0" data-action="toggleShortcut"><i class="fa fa-arrow-down"></i> <u>S</u>hortcut</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0" data-action="launchFullscreen"><i class="fa fa-arrows-alt"></i> Full <u>S</u>creen</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="login.php" class="padding-10 padding-top-5 padding-bottom-5" data-action="userLogout"><i class="fa fa-sign-out fa-lg"></i> <strong><u>L</u>ogout</strong></a>
                        </li>
                    </ul>
                </li>
            </ul>

            <!-- logout button -->
            <div id="logout" class="btn-header transparent pull-right">
                <span> <a href="/login.php" title="Sign Out" data-action="userLogout" data-logout-msg="You can improve your security further after logging out by closing this opened browser"><i class="fa fa-sign-out"></i></a> </span>
            </div>
            <!-- end logout button -->

            <!-- search mobile button (this is hidden till mobile view port) -->
            <div id="search-mobile" class="btn-header transparent pull-right">
                <span> <a href="javascript:void(0)" title="Search"><i class="fa fa-search"></i></a> </span>
            </div>
            <!-- end search mobile button -->

            <!-- input: search field -->
            <form action="#ajax/search.php" class="header-search pull-right">
                <input type="text" name="param" placeholder="Find reports and more" id="search-fld">
                <button type="submit">
                    <i class="fa fa-search"></i>
                </button>
                <a href="javascript:void(0);" id="cancel-search-js" title="Cancel Search"><i class="fa fa-times"></i></a>
            </form>
            <!-- end input: search field -->

            <!-- fullscreen button -->
            <div id="fullscreen" class="btn-header transparent pull-right">
                <span> <a href="javascript:void(0);" title="Full Screen" data-action="launchFullscreen"><i class="fa fa-arrows-alt"></i></a> </span>
            </div>
            <!-- end fullscreen button -->

            <!-- #Voice Command: Start Speech -->
            <div id="speech-btn" class="btn-header transparent pull-right hidden-sm hidden-xs">
                <div>
                    <a href="javascript:void(0)" title="Voice Command" data-action="voiceCommand"><i class="fa fa-microphone"></i></a>
                    <div class="popover bottom"><div class="arrow"></div>
                        <div class="popover-content">
                            <h4 class="vc-title">Voice command activated <br><small>Please speak clearly into the mic</small></h4>
                            <h4 class="vc-title-error text-center">
                                <i class="fa fa-microphone-slash"></i> Voice command failed
                                <br><small class="txt-color-red">Must <strong>"Allow"</strong> Microphone</small>
                                <br><small class="txt-color-red">Must have <strong>Internet Connection</strong></small>
                            </h4>
                            <a href="javascript:void(0);" class="btn btn-success" onclick="commands.help()">See Commands</a>
                            <a href="javascript:void(0);" class="btn bg-color-purple txt-color-white" onclick="$('#speech-btn .popover').fadeOut(50);">Close Popup</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end voice command -->

            <!-- multiple lang dropdown : find all flags in the flags page -->

            <ul class="header-dropdown-list hidden-xs">
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ asset('smart/img/blank.gif') }}" class="flag flag-us" alt="United States"> <span> EN</span> <i class="fa fa-angle-down"></i> </a>
                    <ul class="dropdown-menu pull-right">
                        <li class="active">
                            <a href="javascript:void(0);"><img src="{{ asset('smart/img/blank.gif') }}" class="flag flag-us" alt="United States"> English (US)</a>
                        </li>

                        <li><a href="javascript:void(0);"><img src="{{ asset('smart/img/blank.gif') }}" class="flag flag-cn" alt="China"> 中文</a></li>
                    </ul>
                </li>
            </ul>

        </div>
    </header>
    <div>
        
    </div>
    <!-- Scripts -->
    <script src="{{ asset('smart/js/libs/jquery-2.1.1.min.js ') }}"></script>

    <script src="{{ asset('smart/js/app.config.js') }}"></script>

    <!-- JS TOUCH : include this plugin for mobile drag / drop touch events-->
    <script src="{{ asset('smart/js/plugin/jquery-touch/jquery.ui.touch-punch.min.js') }}"></script>

    <!-- BOOTSTRAP JS -->
    <script src="{{ asset('smart/js/bootstrap/bootstrap.min.js') }}"></script>

    <!-- CUSTOM NOTIFICATION -->
    <script src="{{ asset('smart/js/notification/SmartNotification.min.js') }}"></script>

    <!-- JARVIS WIDGETS -->
    <script src="{{ asset('smart/js/smartwidgets/jarvis.widget.min.js') }}"></script>

    <!-- EASY PIE CHARTS -->
    <script src="{{ asset('smart/js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js') }}"></script>

    <!-- SPARKLINES -->
    <script src="{{ asset('smart/js/plugin/sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- JQUERY VALIDATE -->
    <script src="{{ asset('smart/js/plugin/jquery-validate/jquery.validate.min.js') }}"></script>

    <!-- JQUERY MASKED INPUT -->
    <script src="{{ asset('smart/js/plugin/masked-input/jquery.maskedinput.min.js') }}"></script>

    <!-- JQUERY SELECT2 INPUT -->
    <script src="{{ asset('smart/js/plugin/select2/select2.min.js') }}"></script>

    <!-- JQUERY UI + Bootstrap Slider -->
    <script src="{{ asset('smart/js/plugin/bootstrap-slider/bootstrap-slider.min.js') }}"></script>

    <!-- browser msie issue fix -->
    <script src="{{ asset('smart/js/plugin/msie-fix/jquery.mb.browser.min.js') }}"></script>

    <!-- FastClick: For mobile devices -->
    <script src="{{ asset('smart/js/plugin/fastclick/fastclick.min.js') }}"></script>

    <script src="{{ asset('js/layui/layui.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('script')
</body>
</html>
