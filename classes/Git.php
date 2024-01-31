<?php

/*
----------------------------------
 ------  Created: 012924   ------
 ------  Austin Best	   ------
----------------------------------
*/

//-- BRING IN THE TRAITS
$traits     = RELATIVE_PATH . 'classes/traits/Git/';
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

    public function __construct($repository)
    {
        $this->repository   = $repository;
        $this->cd           = 'cd ' . RELATIVE_PATH . $this->repository .' && ';
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
        $cmd    = 'git clone "' . $repository . '" ' . RELATIVE_PATH . REPOSITORY_PATH . $folder . ' 2>&1';
        $shell  = shell_exec($cmd);
    
        return ['cmd' => $cmd, 'shell' => $shell];
    }

    public function size()
    {
        $cmd    = $this->cd . 'git count-objects -H';
        $shell  = explode("\n", shell_exec($cmd));
    
        return ['cmd' => $cmd, 'shell' => array_filter($shell)];
    }
}
