<?php

/*
----------------------------------
 ------  Created: 013024   ------
 ------  Austin Best	   ------
----------------------------------
*/

require 'shared.php';

if ($_POST['m'] == 'init') {
    ?><h3>Settings</h3><hr><?php

    ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Setting</th>
                <th>Value</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <tr><td colspan="3"><h5>Global</h5></td></tr>
            <tr>
                <td>Repository location</td>
                <td><input type="text" class="form-control setting" id="global-repositoryPath" value="<?= REPOSITORY_PATH ?>"></td>
                <td>This is the location of all git repositories to load and use</td>
            </tr>
            <tr>
                <td>Ignore</td>
                <td><input type="text" class="form-control setting" id="global-ignoreDirectories" value="<?= implode(', ', $ignoreDirectories) ?>"></td>
                <td>Ignore these directories for all calculations</td>
            </tr>
            <tr><td colspan="3"><h5>Page: Overview</h5></td></tr>
            <tr>
                <td>Display newest</td>
                <td><input type="number" class="form-control setting" id="pages-overview-displayNewest" value="<?= ($settings['pages']['overview']['displayNewest'] ? $settings['pages']['overview']['displayNewest'] : 100) ?>"></td>
                <td>Amount of commits (newest) to show</td>
            </tr>
            <tr>
                <td>Display oldest</td>
                <td><input type="number" class="form-control setting" id="pages-overview-displayOldest" value="<?= ($settings['pages']['overview']['displayOldest'] ? $settings['pages']['overview']['displayOldest'] : 100) ?>"></td>
                <td>Amount of commits (oldest) to show</td>
            </tr>
            <tr><td colspan="3"><h5>Page: Code</h5></td></tr>
            <tr>
                <td>Limit</td>
                <td><input type="number" class="form-control setting" id="pages-code-limit" value="<?= ($settings['pages']['code']['limit'] ? $settings['pages']['code']['limit'] : 20) ?>"></td>
                <td>How many different file types to show</td>
            </tr>
            <tr>
                <td>Ignore</td>
                <td><input type="text" class="form-control setting" id="pages-code-ignoreExtension" value="<?= implode(', ', $ignoreCodePageExtensions) ?>"></td>
                <td>Ignore these file types when generating the graphs</td>
            </tr>
        </tbody>
        <tfoot>
            <tr><td colspan="3" align="center"><button class="btn btn-outline-success" onclick="saveSettings()">Save Settings</button></td></tr>
        </tfoot>
    </table>
    <?php
}

if ($_POST['m'] == 'saveSettings') {
    foreach ($_POST as $key => $val) {
        if ($key == 'm') {
            continue;
        }

        $field = $key;
        if (str_contains($field, '-')) {
            $keyParts = explode('-', $key);
        }

        if (count($keyParts) == 3) {
            $settings[$keyParts[0]][$keyParts[1]][$keyParts[2]] = $val;
        } elseif (count($keyParts) == 2) {
            $settings[$keyParts[0]][$keyParts[1]] = $val;
        } else {
            $settings[$field] = $val;
        }
    }

    file_put_contents(SETTINGS_FILE, json_encode($settings));
}
