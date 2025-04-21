<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NameRule implements Rule
{
    public function __construct($check)
    {
      $this->check = $check;
    }

    public function passes($attribute, $value)
    {
      return $this->check !== '0';
    }

    public function message()
    {
      return 'リストに存在しない商品です。';
    }
}
