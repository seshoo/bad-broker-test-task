<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\DataAwareRule;

class DifferenceBetweenTheDatesIsLessInDays implements Rule, DataAwareRule
{
    private $attribute;
    private $dateField;
    private $day;
    private $difference;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(string $dateField, int $day = 1)
    {
        $this->dateField = $dateField;
        $this->day = ($day > 0) ? $day : 1;
    }

    /**
     * All of the data under validation.
     *
     * @var array
     */
    protected $data = [];

    // ...

    /**
     * Set the data under validation.
     *
     * @param  array  $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        $this->attribute = $attribute;

        if (!isset($this->data[$this->dateField])) {
            return false;
        }

        // if values are not dates
        try {
            $firstDate = new \DateTime($value);
            $secondDate = new \DateTime($this->data[$this->dateField]);
        } catch (\Throwable $th) {
            return false;
        }

        $this->difference = abs($firstDate->getTimestamp() - $secondDate->getTimestamp()) / 86400;

        // dump([
        //     'attribute' => $attribute,
        //     'value' => $value,
        //     'other_field' =>  $this->dateField,
        //     'days' =>  $this->day,
        //     'difference' => $this->difference,
        //     'data' => $this->data,
        // ]);
        return ($this->difference <= $this->day);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return sprintf(
            'Difference between "%s" and "%s" is greater than %d (%d)',
            $this->attribute,
            $this->dateField,
            $this->day,
            $this->difference
        );
    }
}
