<?php

/*
----------------------------------
 ------  Created: 012724   ------
 ------  Austin Best	   ------
----------------------------------
*/

require 'loader.php';
require 'includes/header.php';
?>

<div class="main-panel">
    <div class="content-wrapper">
    <div class="row">
        <?php if (!$repositories) { ?>
        <div class="col-xl-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body" id="page-content">
                    <div class="row">
                        No repositories found.
                    </div>
                    <?php if ($settings['global']['repositoryPath']) { ?>
                        <h6 class="text-muted font-weight-normal">Please clone/add them to <code><?= REPOSITORY_PATH ?></code></h6>
                    <?php } else { ?>
                        <h6 class="text-muted font-weight-normal">Please clone/add them to <code><?= REPOSITORY_PATH ?></code> or open the Settings and specify a path (such as <code>/config/repositories</code> for docker)</h6>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php } else { ?>
            <div class="col-xl-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body" id="page-content">Select a repository and a page to view<br><br></div>
            </div>
        </div>
        <?php } ?>
    </div>
    <footer class="footer">

    </footer>
</div>

<?php
require 'includes/footer.php';
