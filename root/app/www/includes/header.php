<?php

/*
----------------------------------
 ------  Created: 012724   ------
 ------  Austin Best	   ------
----------------------------------
*/

$repositoryOptions = '';
if ($repositories) {
    foreach ($repositories as $repository) {
        $repositoryOptions .= '<option value="' . $repository . '">' . str_replace(REPOSITORY_PATH, '', $repository) . '</option>';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>GIT Repo Stats</title>

        <link rel="stylesheet" href="libraries/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="libraries/fontawesome/all.min.css">
        <link rel="stylesheet" href="libraries/bootstrap/bootstrap-icons.css">

        <link rel="stylesheet" href="assets/css/style.css?t=<?= filemtime('assets/css/style.css') ?>">
        <link rel="stylesheet" href="css/style.css?t=<?= filemtime('css/style.css') ?>">
    </head>
    <body>
    <div class="container-scroller">
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
                <a class="sidebar-brand brand-logo" href="index.php">GIT Repo Stats</a>
                <a class="sidebar-brand brand-logo-mini" href="index.php">GSR</a>
            </div>
            <ul class="nav">
                <li class="nav-item nav-category">
                    <select id="active-repository" class="form-select form-control-sm text-white d-inline-block w-75" onchange="loadRepositoryBranches()">
                        <option value="0">Select repository</option>
                        <?= $repositoryOptions ?>
                    </select>
                    <i class="fas fa-plus-circle ms-2" title="Clone a repository" style="cursor: pointer;" onclick="addNewRepository()"></i><br>
                    <select id="active-branch" class="form-select form-control-sm text-white mt-2" onchange="checkoutBranch()" style="display: none;">
                        <?= $repositoryBranchOptions ?>
                    </select>
                </li>
                <li class="nav-item nav-category">
                    <span class="nav-link">Navigation</span>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="#" onclick="loadPage('overview')">
                        <span class="menu-icon"><i class="fab fa-git"></i></span>
                        <span class="menu-title">Overview</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="#" onclick="loadPage('contributors')">
                        <span class="menu-icon"><i class="fas fa-users"></i></span>
                        <span class="menu-title">Contributors</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="#" onclick="loadPage('branches')">
                        <span class="menu-icon"><i class="fas fa-code-branch"></i></span>
                        <span class="menu-title">Branches</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="#" onclick="loadPage('commits')">
                        <span class="menu-icon"><i class="fab fa-git-alt"></i></span>
                        <span class="menu-title">Commits</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="#" onclick="loadPage('code')">
                        <span class="menu-icon"><i class="fas fa-code"></i></span>
                        <span class="menu-title">Code</span>
                    </a>
                </li>
                <li class="fixed-bottom ms-2">
                    <!-- https://themewagon.com/themes/corona-free-responsive-bootstrap-4-admin-dashboard-template/ -->
                    <span class="text-muted d-block text-center text-sm-right d-sm-inline-block">Theme by <a href="https://www.bootstrapdash.com/bootstrap-admin-template/" target="_blank">bootstrapdash</a></span>
                </li>
            </ul>
        </nav>
        <div class="container-fluid page-body-wrapper">
            <nav class="navbar p-0 fixed-top d-flex flex-row">
                <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
                    <a class="navbar-brand brand-logo-mini" href="index.php">GSR</a>
                </div>
                <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                        <i class="fas fa-bars"></i>
                    </button>
                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                        <span class="mdi mdi-format-line-spacing"></span>
                    </button>
                </div>
            </nav>
