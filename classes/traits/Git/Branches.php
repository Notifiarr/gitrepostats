<?php

/*
----------------------------------
 ------  Created: 012924   ------
 ------  Austin Best	   ------
----------------------------------
*/

trait Branches
{
    public function checkout($branch)
    {
        $cmd    = $this->cd . 'git checkout -qf ' . $branch;
        $shell  = explode("\n", shell_exec($cmd));
    
        return ['cmd' => $cmd, 'shell' => array_filter($shell)];
    }

    public function branches()
    {
        $cmd    = $this->cd . 'git branch -a';
        $shell  = explode("\n", shell_exec($cmd));
    
        return ['cmd' => $cmd, 'shell' => array_filter($shell)];
    }

    public function branchHeads()
    {
        $cmd    = $this->cd . 'git show-ref -s';
        $shell  = explode("\n", shell_exec($cmd));
    
        return ['cmd' => $cmd, 'shell' => array_filter($shell)];
    }
}
