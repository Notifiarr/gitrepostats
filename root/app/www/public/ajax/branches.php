<?php

/*
----------------------------------
 ------  Created: 012824   ------
 ------  Austin Best	   ------
----------------------------------
*/

require 'shared.php';

if ($_POST['m'] == 'init') {
    ?><h3>Branches <br><code><?= $repository ?></code></h3><hr><?php

    $branches       = $git->branches();
    $branchHeads    = $git->branchHeads();

    $remoteLabel = false;
    ?>
    <div class="row">
        <h3>Local</h3>
        <?php
        foreach ($branches['shell'] as $index => $branch) {
            if (!$remoteLabel && str_contains($branch, 'remotes/')) {
                $remoteLabel = true;
                ?><h3>Remote</h3><?php
            }
            $branchHeadCommit   = $git->commitInformation($branchHeads['shell'][$index]);
            $commitStats        = $git->commitStats($branchHeads['shell'][$index]);
            $commitStats        = array_slice($commitStats['shell'], -2, 1);
            $author             = trim(preg_replace('/\t+/', '', $branchHeadCommit['shell'][1]));
            $date               = trim(preg_replace('/\t+/', '', $branchHeadCommit['shell'][2]));
            $notes              = [];

            for ($n = 3; $n < count($branchHeadCommit['shell']); $n++) {
                if (str_contains($branchHeadCommit['shell'][$n], 'diff --')) {
                    break;
                }
                $notes[] = trim(preg_replace('/\t+/', '', $branchHeadCommit['shell'][$n]));
            }
            $notes = array_filter($notes);

            $commitStats = str_replace('changed', '<span class="text-warning">changed</span>', $commitStats[0]);
            $commitStats = str_replace('insertions', '<span class="text-success">insertions</span>', $commitStats);
            $commitStats = str_replace('deletions', '<span class="text-danger">deletions</span>', $commitStats);

            $commitStats = str_replace('insertion', '<span class="text-success">insertion</span>', $commitStats);
            $commitStats = str_replace('deletion', '<span class="text-danger">deletion</span>', $commitStats);

            ?>
            <div class="col-sm-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4><?= $branch ?></h4>
                        <div class="bg-gray-dark rounded p-3">
                            <?= $author ?><br>
                            <?= $date ?><br><br>
                            <?= $commitStats ?><br><br>
                            <ul><li><?= implode('</li><li>', $notes) ?></li></ul>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    ?></div><?php
}
