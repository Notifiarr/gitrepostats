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
            <tr><td colspan="3"><h5>Global</h5></td></tr>
            <tr>
                <th>Setting</th>
                <th>Value</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Repository location</td>
                <td><input type="text" class="form-control setting" id="global-repositoryPath" value="<?= REPOSITORY_PATH ?>"></td>
                <td>This is the location of all git repositories to load and use</td>
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
            list($cat, $field) = explode('-', $key);
        }

        if ($cat) {
            $settings[$cat][$field] = $val;
        } else {
            $settings[$field] = $val;
        }
    }

    file_put_contents(SETTINGS_FILE, json_encode($settings));
}
