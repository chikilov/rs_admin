<?php
/**
 * base_header.php
 *
 * Author: pixelcave
 *
 * The header of each page (Backend)
 *
 */
?>

<!-- Header -->
<header id="header-navbar" class="content-mini content-mini-full">
    <!-- Header Navigation Right -->
    <ul class="nav-header pull-right">
        <li>
            <div class="btn-group">
                <button class="btn btn-default btn-image dropdown-toggle" data-toggle="dropdown" type="button">
                    <img src="<?php echo $one->assets_folder; ?>/img/avatars/avatar10.jpg" alt="Avatar">
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li class="dropdown-header">Actions</li>
                    <li>
                        <a tabindex="-1" href="/Login/logout">
                            <i class="si si-logout pull-right"></i>Log out
                        </a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
    <!-- END Header Navigation Right -->

    <!-- Header Navigation Left -->
    <ul class="nav-header pull-left">
        <li class="hidden-md hidden-lg">
            <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
            <button class="btn btn-default" data-toggle="layout" data-action="sidebar_toggle" type="button">
                <i class="fa fa-navicon"></i>
            </button>
        </li>
        <li class="hidden-xs hidden-sm">
            <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
            <button class="btn btn-default" data-toggle="layout" data-action="sidebar_mini_toggle" type="button">
                <i class="fa fa-ellipsis-v"></i>
            </button>
        </li>
        <li class="visible-xs">
            <!-- Toggle class helper (for .js-header-search below), functionality initialized in App() -> uiToggleClass() -->
            <button class="btn btn-default" data-toggle="class-toggle" data-target=".js-header-search" data-class="header-search-xs-visible" type="button">
                <i class="fa fa-search"></i>
            </button>
        </li>
        <li class="js-header-search header-search">
            <form id="searchbar" class="form-horizontal" method="post">
                <div class="form-material form-material-primary input-group remove-margin-t remove-margin-b">
                    <input class="form-control" type="text" id="searchval" name="searchval" placeholder="Search.." value="<?php if( isset($searchval) ) echo $searchval; ?>" />
                    <span class="input-group-addon" data-toggle="modal" data-target="#modal-search"><i class="si si-magnifier"></i></span>
                </div>
        </li>
        <li class="js-header-search header-search" style="margin: 7px 0 0 12px;width:40px;">
            <div class="form-material form-material-primary input-group remove-margin-t remove-margin-b">
                <span>UID : </span>
            </div>
        </li>
        <li class="js-header-search header-search" style="width:180px;">
                <div class="form-material form-material-primary input-group remove-margin-t remove-margin-b">
					<input class="form-control" type="text" id="searchuid" name="searchuid" value="<?php if( isset($searchuid) ) echo $searchuid; ?>" />
                </div>
        </li>
        <li class="js-header-search header-search" style="margin: 7px 0 0 10px;width:60px;">
            <div class="form-material form-material-primary input-group remove-margin-t remove-margin-b">
                <span>NAME : </span>
            </div>
        </li>
        <li class="js-header-search header-search">
                <div class="form-material form-material-primary input-group remove-margin-t remove-margin-b">
					<input class="form-control" type="text" id="searchname" name="searchname" value="<?php if( isset($searchname) ) echo $searchname; ?>" />
                </div>
            </form>
        </li>
    </ul>
    <!-- END Header Navigation Left -->
</header>
<!-- END Header -->
