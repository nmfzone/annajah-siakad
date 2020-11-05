<?php

namespace App\Garages\Utility;

class IndonesianNameFormatter
{
    protected $indonesianTitles = [
        'S.Kom', 'S.Pd', 'PhD', 'M.Cs', 'M.Sc', 'ST', 'S.Ag',
        'S.Ars', 'S.Pd.I', 'S.T', 'S.TI', 'S.Si', 'S.I.P',
        'S.Psi', 'S.E', 'S.I.Kom', 'S.Sos', 'M.Kom', 'S.H',
        'M.Hum', 'M.M', 'M.Pd', 'M.Psi', 'M.Pd.I', 'M.Kes',
        'S.Ked', 'S.Hum', 'B.Sc', 'S.Gz', 'A.Md', 'M.Arch',
        'A.Md.Pd', 'A.Md.Bid', 'A.Md.Par', 'A.Md.Kes',
        'S.Sos.I', 'S.Kes', 'M.Ag', 'M.T', 'MT',
    ];

    protected $patterns = [];

    protected $replacements = [];

    public function __construct()
    {
        foreach ($this->indonesianTitles as $value) {
            $rgxVal = preg_quote(ucwords(mb_strtolower($value)));
            array_push($this->patterns, "/^{$rgxVal}\s/");
            array_push($this->replacements, $value . ' ');
            array_push($this->patterns, "/^{$rgxVal}\.\s/");
            array_push($this->replacements, $value . '. ');
            array_push($this->patterns, "/\s{$rgxVal}$/");
            array_push($this->replacements, ' ' . $value);
            array_push($this->patterns, "/\s{$rgxVal}\.$/");
            array_push($this->replacements, ' ' . $value . '.');
            array_push($this->patterns, "/\s{$rgxVal}\s/");
            array_push($this->replacements, ' ' . $value . ' ');
            array_push($this->patterns, "/\s{$rgxVal}.\s/");
            array_push($this->replacements, ' ' . $value . '. ');
            array_push($this->patterns, "/\s{$rgxVal},/");
            array_push($this->replacements, ' ' . $value . ',');
            array_push($this->patterns, "/\s{$rgxVal}\.,/");
            array_push($this->replacements, ' ' . $value . '.,');
        }
    }

    public function format($name)
    {
        if (is_null($name)) {
            return null;
        }

        return preg_replace(
            $this->patterns,
            $this->replacements,
            mb_convert_case(mb_strtolower($name), MB_CASE_TITLE)
        );
    }
}
