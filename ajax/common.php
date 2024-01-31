<?php

/*
----------------------------------
 ------  Created: 013024   ------
 ------  Austin Best	   ------
----------------------------------
*/

require 'shared.php';

if ($_POST['m'] == 'loadRepositoryBranches') {
    foreach ($branches['shell'] as $branch) {
        $branchOptions .= '<option ' . (str_contains($branch, '*') ? 'selected' : '') . ' value="' . trim($branch) . '">' . trim($branch) . '</option>';
    }

    echo $branchOptions;
}

if ($_POST['m'] == 'checkoutBranch') {
    $git->checkout($_POST['branch']);
    $git->pull();
}

if ($_POST['m'] == 'addNewRepository') {
    ?>
    <table class="table table-bordered">
        <tr>
            <td colspan="4">Copy the https url for the public repository. Local and private repositories, navigate to <?= REPOSITORY_PATH ?> and you can run <code>git clone</code> or copy the repository there.</td>
        </tr>
        <tr>
            <td><code>git clone &lt;repository&gt; &lt;folder&gt;</code></td>
            <td><input type="text" class="form-control" placeholder="Ex: https://github.com/Notifiarr/dockwatch.git" id="clone-url"></td>
            <td><input type="text" class="form-control" placeholder="Ex: dockwatch" id="clone-folder"></td>
            <td align="center"><button class="btn btn-primary" onclick="cloneRepository()">Clone Repository</button></td>
        </tr>
        <tr><td colspan="4"><div id="clone-result">Result: Waiting...</div></td></tr>
    </table>
    <?php
}

if ($_POST['m'] == 'cloneRepository') {
    echo '<center><h4>Clone result</h4></center>';
    if (is_dir(RELATIVE_PATH . REPOSITORY_PATH . $_POST['folder'])) {
        $error = 'The path <code>' . REPOSITORY_PATH . $_POST['folder'] . '</code> is already used';
    }

    if (!$error) {
        echo 'Cloning <code>' . $_POST['url'] . '</code> into <code>' . REPOSITORY_PATH . $_POST['folder'] . '</code><br><br>';
        $clone = $git->clone($_POST['url'], $_POST['folder']);
        echo 'Command: ' . $clone['cmd'] . '<br><br>';
        echo 'Response: ' . $clone['shell'];

        if (!str_contains($clone['shell'], 'fatal')) {
            echo '<hr>';
            echo 'The repository can be used now, reload the page.';
        }
    } else {
        echo $error;
    }
}