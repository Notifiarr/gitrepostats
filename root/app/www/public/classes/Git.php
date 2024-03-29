<?php

/*
----------------------------------
 ------  Created: 012924   ------
 ------  Austin Best	   ------
----------------------------------
*/

//-- BRING IN THE TRAITS
$traits     = ABSOLUTE_PATH . 'classes/traits/Git/';
$traitsDir  = opendir($traits);
while ($traitFile = readdir($traitsDir)) {
    if (str_contains($traitFile, '.php')) {
        require $traits . $traitFile;
    }
}
closedir($traitsDir);

class Git
{
    use Branches;
    use Commits;
    use Contributors;
    use Files;

    public $cd;
    public $repository;
    public $ignoreDirectories;

    public function __construct($repository)
    {
        global $ignoreDirectories;

        $this->repository           = $repository;
        $this->cd                   = 'cd ' . $this->repository .' && ';
        $this->ignoreDirectories    = $ignoreDirectories;
    }

    public function __toString()
    {
        return 'Git initialized';
    }

    public function log()
    {
        $cmd    = $this->cd . 'git log --graph --abbrev-commit --decorate=full --all --tags --format=format:\'{hash:%h}~{date:%aD}~{relative:%ar}~{branch:%d}~{note:%s}~{authorName:%an}~{authorEmail:%ae}\'';
        $shell  = explode("\n", shell_exec($cmd));
    
        return ['cmd' => $cmd, 'shell' => $shell];
    }
    
    public function pull()
    {
        $cmd    = $this->cd . 'git pull --all';
        $shell  = shell_exec($cmd);
    
        return ['cmd' => $cmd, 'shell' => $shell];
    }

    public function clone($repository, $folder)
    {
        $cmd    = 'git clone "' . $repository . '" ' . REPOSITORY_PATH . $folder . ' 2>&1';
        $shell  = shell_exec($cmd);
    
        return ['cmd' => $cmd, 'shell' => $shell];
    }

    public function size()
    {
        $cmd    = $this->cd . 'git count-objects -vH';
        $shell  = explode("\n", shell_exec($cmd));

        return ['cmd' => $cmd, 'shell' => array_filter($shell)];
    }
}
