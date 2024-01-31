<?php

/*
----------------------------------
 ------  Created: 012824   ------
 ------  Austin Best	   ------
----------------------------------
*/

require 'shared.php';

if ($_POST['m'] == 'init') {
    ?><h3>Contributors <br><code><?= $repository ?></code></h3><hr><?php

    ?><div class="row"><?php
    foreach ($contributors['shell'] as $contributor) {
        $parts = explode("\t", $contributor);
        $parts = array_filter($parts);
        sort($parts, SORT_NUMERIC);
        $author     = trim($parts[0]);
        $commits    = trim($parts[1]);
        $graphHash  = md5($author . $commits);

        if (str_contains($author, '<')) {
            list($author, $email) = explode('<', $author);
        }
        $author         = trim($author);
        $authorStats    = $git->contributorStats($author);
        $commitHistory  = $git->contributorCommits($author);
        $newestCommit   = $commitHistory['shell'][1];

        $changed = $added = $removed = 0;
        foreach ($authorStats['shell'] as $line) {
            if (str_contains($line, 'change') || str_contains($line, '(+)') || str_contains($line, '(-)')) {
                $lineParts = explode(',', trim($line));
                if ($lineParts[0]) {
                    $number = intval(preg_replace("/[^0-9]/", '', $lineParts[0]));

                    if (str_contains($lineParts[0], 'file')) {
                        $changed += $number;
                    } elseif (str_contains($lineParts[0], '(+)')) {
                        $added += $number;
                    } elseif (str_contains($lineParts[0], '(-)')) {
                        $removed += $number;
                    }
                }
                if ($lineParts[1]) {
                    $number = intval(preg_replace("/[^0-9]/", '', $lineParts[1]));

                    if (str_contains($lineParts[1], 'file')) {
                        $changed += $number;
                    } elseif (str_contains($lineParts[1], '(+)')) {
                        $added += $number;
                    } elseif (str_contains($lineParts[1], '(-)')) {
                        $removed += $number;
                    }
                }
                if ($lineParts[2]) {
                    $number = intval(preg_replace("/[^0-9]/", '', $lineParts[2]));

                    if (str_contains($lineParts[2], 'file')) {
                        $changed += $number;
                    } elseif (str_contains($lineParts[2], '(+)')) {
                        $added += $number;
                    } elseif (str_contains($lineParts[2], '(-)')) {
                        $removed += $number;
                    }
                }
            }
        }

        $newest = $oldest = '';
        $graphPoints = [];
        foreach ($commitHistory['shell'] as $commit) {
            $timestamp = strtotime(trim(str_replace('Date:', '', $commit[2])));

            if (!$newest) {
                $newest = $timestamp;
            }
            $oldest = $timestamp;

            $graphPoints[date('Y-m-d', $timestamp)]++;
        }

        $labels = $data = '';
        foreach ($graphPoints as $graphPointDate => $graphPointCount) {
            $labels .= ($labels ? ', ' : '') . '"' . $graphPointDate . '"';
            $data .= ($data ? ', ' : '') . intval($graphPointCount);
        }
        ?>
        <div class="col-sm-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4><?= $author ?></h4>
                    <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                        <div class="col-xl-3 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    Commits: <span class="text-muted"><?= number_format($commits) ?>/<?= number_format($totalCommits['shell']) ?></span><br>
                                    <?php if ($newest) { ?>
                                    Newest: <span class="text-muted"><?= date('M. jS, Y', $newest) ?></span><br>
                                    <?php } ?>
                                    <?php if ($oldest) { ?>
                                    Oldest: <span class="text-muted"><?= date('M. jS, Y', $oldest) ?></span><br>
                                    <?php } ?>
                                    Files changed: <span class="text-muted"><?= number_format($changed) ?></span><br>
                                    Lines added: <span class="text-muted"><?= number_format($added) ?></span><br>
                                    Lines removed: <span class="text-muted"><?= number_format($removed) ?></span><br>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <?php 
                                    if (!empty($newestCommit)) {
                                        ?>
                                        Commit: <?= substr(trim(str_replace('commit', '', $newestCommit[0])), 0, 7) ?><br>
                                        Date: <?= trim(str_replace('Date:', '', $newestCommit[2])) ?><br>
                                        <ul><li><?= implode('</li><li>', array_slice($newestCommit, 3)) ?></li></ul>
                                        <?php
                                    } else {
                                        ?>No commit information found.<?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <canvas id="contributor-<?= $graphHash ?>"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            var ctx = document.querySelector('#contributor-<?= $graphHash ?>').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [<?= $labels ?>],
                    datasets: [{
                        label: 'Commits',
                        data: [<?= $data ?>],
                        borderColor: '#36A2EB',
                        backgroundColor: '#9BD0F5'
                    }]
                },
                options: {
                    scales: {
                        x: {
                            type: 'time',
                            parser: 'YYYY-MM-DD'
                        }
                    }
                }
            });
        </script>
        <?php
    }
    ?></div><?php

}
