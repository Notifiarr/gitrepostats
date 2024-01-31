<?php

/*
----------------------------------
 ------  Created: 012824   ------
 ------  Austin Best	   ------
----------------------------------
*/

require 'shared.php';

if ($_POST['m'] == 'init') {
    ?><h3>Commits <?= '<br><code>./' . $repository ?></code></h3><hr><?php

    $regex = '/{(?<hash>(.*))}~{(?<date>(.*))}~{(?<relative>(.*))}~{(?<branch>(.*))}~{(?<note>(.*))}~{(?<authorName>(.*))}~{(?<authorEmail>(.*))}/';

    $yearData = $monthData = $weekData = $dayData = [];
    foreach ($overview['shell'] as $commit) {
        $details    = str_replace($tree, '', $commit);
        $details    = preg_match($regex, $details, $matches);

        if ($matches['date']) {
            $timestamp = strtotime(str_replace('date:', '', $matches['date']));
            $yearData[date('Y', $timestamp)]++;
            if (count($monthData) <= 36) { //-- 3 YEARS
                $monthData[date('Y-m', $timestamp)]++;
            }
            if (count($weekData) <= 26) { //-- 26 WEEKS (6 MONTHS)
                $weekData[date('Y-W', $timestamp)]++;
            }
            if (count($dayData) <= 30) { //-- 30 DAYS (1 MONTH)
                $dayData[date('Y-m-d', $timestamp)]++;
            }
        }
    }
    ksort($yearData);
    ksort($monthData);
    ksort($weekData);
    ksort($dayData);

    $dailyLabels = $dailyData = '';
    foreach ($dayData as $key => $val) {
        $label = date('M. d, y', strtotime($key));

        $dailyLabels   .= ($dailyLabels ? ',' : '') . "'" . $label . "'";
        $dailyData     .= ($dailyData ? ',' : '') . "'" . $val . "'";
    }

    $weeklyLabels = $weeklyData = '';
    foreach ($weekData as $key => $val) {
        list($year, $week) = explode('-', $key);

        $weeklyLabels   .= ($weeklyLabels ? ',' : '') . "'" . $year . " week " . $week . "'";
        $weeklyData     .= ($weeklyData ? ',' : '') . "'" . $val . "'";
    }

    $monthlyLabels = $monthlyData = '';
    foreach ($monthData as $key => $val) {
        $label = date('M. y', strtotime($key . '-1 12:00:00'));

        $monthlyLabels   .= ($monthlyLabels ? ',' : '') . "'" . $label . "'";
        $monthlyData     .= ($monthlyData ? ',' : '') . "'" . $val . "'";
    }

    $yearlylabels = $yearlyData = '';
    foreach ($yearData as $key => $val) {
        $yearlylabels   .= ($yearlylabels ? ',' : '') . "'" . $key . "'";
        $yearlyData     .= ($yearlyData ? ',' : '') . "'" . $val . "'";
    }

    ?>
    <div class="col-sm-12 grid-margin stretch-card">
        <div class="card">
            <div class="row">
                <div class="col-xl-6 col-sm-12">
                    <div class="card-body">
                        <h4>Daily</h4>
                        <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                            <canvas id="commits-daily"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-sm-12">
                    <div class="card-body">
                        <h4>Weekly</h4>
                        <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                            <canvas id="commits-weekly"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-sm-12">
                    <div class="card-body">
                        <h4>Monthly</h4>
                        <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                            <canvas id="commits-monthly"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-sm-12">
                    <div class="card-body">
                        <h4>Yearly</h4>
                        <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                            <canvas id="commits-yearly"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var ctx = document.querySelector('#commits-daily').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [<?= $dailyLabels ?>],
                datasets: [{
                    label: 'Daily Commits (Last 30 active days)',
                    data: [<?= $dailyData ?>],
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

        var ctx = document.querySelector('#commits-weekly').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [<?= $weeklyLabels ?>],
                datasets: [{
                    label: 'Weekly Commits (Last 26 active weeks)',
                    data: [<?= $weeklyData ?>],
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

        var ctx = document.querySelector('#commits-monthly').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [<?= $monthlyLabels ?>],
                datasets: [{
                    label: 'Monthly Commits (Last 36 active months)',
                    data: [<?= $monthlyData ?>],
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

        var ctx = document.querySelector('#commits-yearly').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [<?= $yearlylabels ?>],
                datasets: [{
                    label: 'Yearly Commits',
                    data: [<?= $yearlyData ?>],
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
