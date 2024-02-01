<?php

/*
----------------------------------
 ------  Created: 012924   ------
 ------  Austin Best	   ------
----------------------------------
*/

trait Contributors
{
    public function contributors()
    {
        $cmd    = $this->cd . 'git shortlog -sne --all';
        $shell  = explode("\n", shell_exec($cmd));
    
        return ['cmd' => $cmd, 'shell' => array_filter($shell)];
    }

    public function contributorCommits($author)
    {
        $cmd    = $this->cd . 'git log --author="' . $author . '"';
        $shell  = explode("\n", shell_exec($cmd));

        $userCommits = [];
        $counter = 0;
        foreach ($shell as $index => $commitLine) {
            if (str_contains($commitLine, 'commit') && str_contains($shell[$index + 1], 'Author')) {
                $counter++;
            }
    
            if (trim($commitLine)) {
                $userCommits[$counter][] = trim($commitLine);
            }
        }

        return ['cmd' => $cmd, 'shell' => $userCommits];
    }

    public function contributorStats($author)
    {
        $cmd    = $this->cd . 'git log --author="' . $author . '" --oneline --shortstat';
        $shell  = explode("\n", shell_exec($cmd));
    
        return ['cmd' => $cmd, 'shell' => array_filter($shell)];
    }
}
