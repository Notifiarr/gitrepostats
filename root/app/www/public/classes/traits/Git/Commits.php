<?php

/*
----------------------------------
 ------  Created: 012924   ------
 ------  Austin Best	   ------
----------------------------------
*/

trait Commits
{
    public function totalCommits()
    {
        $cmd    = $this->cd . 'git rev-list --count --all --first-parent';
        $shell  = shell_exec($cmd);
    
        return ['cmd' => $cmd, 'shell' => $shell];
    }

    public function commitInformation($commit)
    {
        $cmd    = $this->cd . 'git show ' . $commit;
        $shell  = explode("\n", shell_exec($cmd));
    
        return ['cmd' => $cmd, 'shell' => $shell];
    }

    public function commitStats($commit)
    {
        $cmd    = $this->cd . 'git show --stat ' . $commit;
        $shell  = explode("\n", shell_exec($cmd));
    
        return ['cmd' => $cmd, 'shell' => $shell];
    }
}
