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
        $author = trim($author);

        if (!$author) {
            continue;
        }

        $authorStats    = $git->contributorStats($author);
        $commitHistory  = $git->contributorCommits($author);
        $newestCommit   = $commitHistory['shell'][1];

        if (empty($newestCommit)) {
            continue;
        }

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

            if (count($graphPoints) <= 24) {
                $graphPoints[date('Y-m', $timestamp)]++;
            }
        }
        ksort($graphPoints);

        $labels = $data = '';
        foreach ($graphPoints as $graphPointDate => $graphPointCount) {
            $label = date('M. y', strtotime($graphPointDate . '-1 12:00:00'));

            $labels .= ($labels ? ', ' : '') . '"' . $label . '"';
            $data   .= ($data ? ', ' : '') . intval($graphPointCount);
        }
        ?>
        <div class="col-sm-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4><?= $author ?></h4>
                    <div class="bg-gray-dark rounded">
                        <div class="row">
                            <div class="col-lg-3 col-sm-12">
                                <div class="card ms-2 mt-2">
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
                            <div class="col-lg-4 col-sm-12">
                                <div class="card mt-2">
                                    <div class="card-body">
                                        Commit: <?= substr(trim(str_replace('commit', '', $newestCommit[0])), 0, 7) ?><br>
                                        Date: <?= trim(str_replace('Date:', '', $newestCommit[2])) ?><br>
                                        <ul>
                                        <?php
                                        $notes = array_slice($newestCommit, 3);
                                        foreach ($notes as $note) {
                                            if (str_contains_any($note, ['Author:', 'Date:', 'Merge:', 'Signed-off-by:', 'Co-authored-by:']) || substr($note, 0, 7) == 'commit ') {
                                                continue;
                                            }
                                            ?><li><?= $note ?></li><?php
                                        }
                                        ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 col-sm-12">
                                <div class="card me-2 mb-2 mt-2">
                                    <div class="card-body">
                                        <canvas id="contributor-<?= $graphHash ?>"></canvas>
                                    </div>
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
