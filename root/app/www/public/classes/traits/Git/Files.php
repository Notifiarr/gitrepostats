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
        $grepExcludeDirectories = '';
        if ($this->ignoreDirectories) {
            foreach ($this->ignoreDirectories as $directory) {
                $grepExcludeDirectories .= ($grepExcludeDirectories ? '|' : '') . $directory . '/*';
            }

            $grepExcludeDirectories = '| grep -v -E "' . $grepExcludeDirectories . '" ';
        }

        $cmd    = $this->cd . 'git ls-files ' . $grepExcludeDirectories  . '| wc -l';
        $shell  = shell_exec($cmd);
    
        return ['cmd' => $cmd, 'shell' => $shell];
    }

    public function totalLines()
    {
        $grepExcludeDirectories = '';
        if ($this->ignoreDirectories) {
            foreach ($this->ignoreDirectories as $directory) {
                $grepExcludeDirectories .= ($grepExcludeDirectories ? '|' : '') . $directory . '/*';
            }

            $grepExcludeDirectories = '| grep -v -E "' . $grepExcludeDirectories . '" ';
        }

        $cmd    = $this->cd . 'git ls-files ' . $grepExcludeDirectories  . '| xargs wc -l';
        $shell  = explode("\n", shell_exec($cmd));
    
        return ['cmd' => $cmd, 'shell' => $shell];
    }
}
