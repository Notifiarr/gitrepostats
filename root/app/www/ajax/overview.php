<?php

/*
----------------------------------
 ------  Created: 012824   ------
 ------  Austin Best	   ------
----------------------------------
*/

require 'shared.php';

if ($_POST['m'] == 'init') {
    ?><h3>Overview <?= '<br><code>./' . $repository ?></code></h3><hr><?php

    $regex = '/{(?<hash>(.*))}~{(?<date>(.*))}~{(?<relative>(.*))}~{(?<branch>(.*))}~{(?<note>(.*))}~{(?<authorName>(.*))}~{(?<authorEmail>(.*))}/';

    //-- GET MAX WIDTH
    $treeSpacing = $emailSpacing = 0;
    foreach ($overview['shell'] as $line) {
        list($tree, $stuff) = explode('{', $line);
        if (strlen($tree) > $treeSpacing) {
            $treeSpacing = strlen($tree);
        }

        $details    = str_replace($tree, '', $line);
        $details    = preg_match($regex, $details, $matches);
        $nameEmail  = str_replace('authorName:', '', $matches['authorName']) . ' (' . str_replace('authorEmail:', '', $matches['authorEmail']) . ')';
        if (strlen($nameEmail) > $emailSpacing) {
            $emailSpacing = strlen($nameEmail);
        }
    }

    $display = '';
    foreach ($overview['shell'] as $line) {
        list($tree, $stuff) = explode('{', $line);
        $display .= '<span>' . str_pad($tree, $treeSpacing, ' ', STR_PAD_RIGHT) . '</span>';

        $details    = str_replace($tree, '', $line);
        $details    = preg_match($regex, $details, $matches);
        $hash       = str_replace('hash:', '', $matches['hash']);
        $date       = str_replace('date:', '', $matches['date']);
        $relative   = str_replace('relative:', '', $matches['relative']);
        $author     = str_replace('authorName:', '', $matches['authorName']);
        $email      = str_replace('authorEmail:', '', $matches['authorEmail']) ? ' (' . str_replace('authorEmail:', '', $matches['authorEmail']) . ')' : '';

        $branchIn   = ['branch:', 'HEAD -> ', 'refs/heads/', 'refs/remotes/', '(', ')'];
        $branchOut  = ['', '', '', '', '', ''];
        $branch     = trim(str_replace($branchIn, $branchOut, $matches['branch']));

        if ($branch) {
            $branchList = [];
            if (str_contains($branch, ',')) {
                $branches = explode(',', $branch);
                foreach ($branches as $commitBranch) {
                    if (str_contains($commitBranch, '/')) {
                        $commitBranch = '<button class="btn btn-outline-danger" disabled>' . $commitBranch . '</button>';
                    } else {
                        $commitBranch = '<button class="btn btn-outline-success" disabled>' . $commitBranch . '</button>';
                    }

                    $branchList[] = $commitBranch;
                    $branch = implode(' ', $branchList);
                }
            } else {
                if (str_contains($branch, '/')) {
                    $branch = '<button class="btn btn-outline-danger" disabled>' . $branch . '</button>';
                } else {
                    $branch = '<button class="btn btn-outline-success" disabled>' . $branch . '</button>';
                }
            }
        }

        $display .= '   <span class="text-warning">' . $hash . '</span>';
        $display .= '   <span title="' . $date . '">' . str_pad($relative, 15, ' ', STR_PAD_RIGHT) . '</span>';
        $display .= '   <span class="text-primary">' . $author . '</span>';
        $display .= str_pad($email, ($emailSpacing - strlen($author)), ' ', STR_PAD_RIGHT);
        $display .= '   ' . trim($branch) . ' ' . str_replace('note:', '', $matches['note']);
        $display .= '<br>';
    }

    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="float-right mb-3">
                <button class="btn btn-inverse-primary" onclick="gitPull()"><i class="fas fa-download"></i> Pull</button>
            </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Repository</h4>
                    <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                        <div class="text-md-center text-xl-left me-5">
                            <h6 class="mb-1">Commits</h6>
                            <p class="text-muted mb-0"><?= number_format($totalCommits['shell']) ?></p>
                        </div>
                        <div class="text-md-center text-xl-left me-5">
                            <h6 class="mb-1">Objects</h6>
                            <p class="text-muted mb-0"><?= number_format($repoObjects) ?></p>
                        </div>
                        <div class="text-md-center text-xl-left me-5">
                            <h6 class="mb-1">Size</h6>
                            <p class="text-muted mb-0"><?= $repoSize ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Code</h4>
                    <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                        <div class="text-md-center text-xl-left me-5">
                            <h6 class="mb-1">Total files</h6>
                            <p class="text-muted mb-0"><?= number_format($totalFiles['shell']) ?></p>
                        </div>
                        <div class="text-md-center text-xl-left me-5">
                            <h6 class="mb-1">Total lines</h6>
                            <p class="text-muted mb-0"><?= number_format($linesOfCode) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Contributors</h4>
                    <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                        <div class="text-md-center text-xl-left me-5">
                            <h6 class="mb-1">Total</h6>
                            <p class="text-muted mb-0"><?= count($contributors['shell']) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <span class="text-warning me-2">Commit hash</span> 
    <span class="text-primary me-2">Commit author</span> 
    <span class="text-success me-2">Local branch</span> 
    <span class="text-danger me-2">Remote branch</span> 
    <pre><?= $display; ?></pre>
    <?php
}

if ($_POST['m'] == 'gitPull') {
    $git->pull();
}
