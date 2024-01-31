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
                <div class="card-body">
                    <div class="row">
                        No repositories found.
                    </div>
                    <h6 class="text-muted font-weight-normal">Please clone/add them to <code><?= REPOSITORY_PATH ?></code></h6>
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
