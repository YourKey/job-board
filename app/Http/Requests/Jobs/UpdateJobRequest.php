<?php

namespace App\Http\Requests\Jobs;

use App\Models\JobVacancy;
use Illuminate\Foundation\Http\FormRequest;

class UpdateJobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $job = JobVacancy::find($this->route('job')->id);
        return $job && $this->user()->can('update-job', $job);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|min:3|max:255',
            'description' => 'required|string',
        ];
    }
}
