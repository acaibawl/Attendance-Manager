<?php

namespace App\Http\Requests\Attendance\Schedule;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class IndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'year' => ['required', 'integer'],
            'month' => ['required', 'numeric', 'min:1', 'max:12']
        ];
    }

    public function makeDate(): Carbon
    {
        $params = $this->validated();
        return Carbon::createFromDate($params['year'], $params['month'], 1);
    }
}
