<?php

namespace Botble\Media\Http\Requests;

use Botble\Support\Http\Requests\Request;

class MediaFolderRequest extends Request
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
            'name' => 'required|regex:/^[\pL\s\ \_\-0-9]+$/u',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name.regex' => trans('media::media.name_invalid'),
        ];
    }
}
