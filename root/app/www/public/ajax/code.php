<?php

/*
----------------------------------
 ------  Created: 012924   ------
 ------  Austin Best	   ------
----------------------------------
*/

require 'shared.php';

if ($_POST['m'] == 'init') {
    ?><h3>Code <br><code><?= $repository ?></code></h3><hr><?php

    $labels = $dataFiles = $dataLines = $colors = '';
    $usedColors = [];
    array_sort_by_key($fileTypes, 'lines', 'desc');
    $fileTypes = array_slice($fileTypes, 0, ($settings['pages']['code']['limit'] ? $settings['pages']['code']['limit'] : 20));

    foreach ($fileTypes as $fileType => $fileTypeData) {
        $randomColor = randomColor($usedColors);
        $usedColors[] = $randomColor;

        $labels     .= ($labels ? ',' : '') . "'" . $fileType . "'";
        $dataFiles  .= ($dataFiles ? ',' : '') . intval($fileTypeData['files']);
        $dataLines  .= ($dataLines ? ',' : '') . intval($fileTypeData['lines']);
        $colors     .= ($colors ? ',' : '') . "'" . $randomColor . "'";
    }
    ?>
    <div class="col-sm-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                    <div class="col-xs-12 col-sm-6">
                        <h4 class="card-title">Types</h4>
                        <div class="card">
                            <div class="card-body">
                                <canvas id="fileType"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <h4 class="card-title">Lines</h4>
                        <div class="card">
                            <div class="card-body">
                                <canvas id="fileLines"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var ctx = document.querySelector('#fileType').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [<?= $labels ?>],
                datasets: [{
                    label: 'Types',
                    data: [<?= $dataFiles ?>],
                    backgroundColor: [<?= $colors ?>],
                    color: '#FFFFFF',
                    hoverOffset: 4
                }]
            },
            options: { 
                legend: {
                    position: 'left',
                    labels: {
                        fontColor: 'white',
                        fontSize: 18
                    }
                }
            }
        });
        var ctx = document.querySelector('#fileLines').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [<?= $labels ?>],
                datasets: [{
                    label: 'Types',
                    data: [<?= $dataLines ?>],
                    backgroundColor: [<?= $colors ?>],
                    color: '#FFFFFF',
                    hoverOffset: 4
                }]
            },
            options: { 
                legend: {
                    position: 'left',
                    labels: {
                        fontColor: 'white',
                        fontSize: 18
                    }
                }
            }
        });
    </script>
    <?php
}
