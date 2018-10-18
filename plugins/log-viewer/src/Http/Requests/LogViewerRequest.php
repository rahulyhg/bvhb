<?php

namespace Botble\LogViewer\Http\Requests;

use Botble\Support\Http\Requests\Request;

class LogViewerRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @author DGL Custom
     */
    public function rules()
    {
        return [
            'name' => 'required',
        ];
    }
}
