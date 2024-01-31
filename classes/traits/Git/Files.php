<?php

/*
----------------------------------
 ------  Created: 012924   ------
 ------  Austin Best	   ------
----------------------------------
*/

trait Files
{
    public function totalFiles()
    {
        $cmd    = $this->cd . 'git ls-files | wc -l';
        $shell  = shell_exec($cmd);
    
        return ['cmd' => $cmd, 'shell' => $shell];
    }
    
    public function totalLines()
    {
        $cmd    = $this->cd . 'git ls-files | xargs wc -l';
        $shell  = explode("\n", shell_exec($cmd));
    
        return ['cmd' => $cmd, 'shell' => $shell];
    }
}
