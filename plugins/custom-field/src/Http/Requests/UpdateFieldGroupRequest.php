<?php

namespace Botble\CustomField\Http\Requests;

use Botble\Support\Http\Requests\Request;

class UpdateFieldGroupRequest extends Request
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
            'order' => 'integer|min:0|required',
            'rules' => 'json|required',
            'group_items' => 'json|required',
            'deleted_items' => 'json|nullable',
            'title' => 'required|max:255',
            'status' => 'required',
        ];
    }
}
