<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MaxWords implements Rule
{
    protected $maxWords;
    protected $attribute;

    public function __construct($maxWords)
    {
        $this->maxWords = $maxWords;
    }

    public function passes($attribute, $value)
    {
        $this->attribute = $attribute;
        return str_word_count($value) <= $this->maxWords;
    }

    public function message()
    {
        return 'Jumlah kata pada ' . $this->attribute . ' tidak boleh lebih dari ' . $this->maxWords . ' kata.';
    }
}
