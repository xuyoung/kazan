<?php
namespace App\KaZanApp\Auth\Requests;

use App\KaZanApp\Base\Request;
use Illuminate\Contracts\Validation\Validator;

class AuthRequest extends Request
{
	protected $rules = [
		'login'		=> [
            'user_account' => "required"
        ]
	];

	protected $messages = [
		'login'		=> [
            'user_account.required' => "0x003002",
        ]
	];

	 /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($request)
    {
        $function = explode("@", $request->route()[1]['uses'])[1];
        return $this->getRouteValidateRule($this->rules, $function);
		// $this->setCurrentActionName();
        // return $this->rules[$this->actionName];
    }
	/**
	 * Set custom messages for validator errors.
	 *
	 * @return array
	 */
	public function messages()
	{
		return $this->messages[$this->actionName];
	}
	/**
	 * 验证失败后返回错误信息
	 * @param \Illuminate\Validation\Validator $validator
	 */
    public function failedValidation(Validator $validator){
        $this->responseFormErrors($validator, 'auth');
    }
}
