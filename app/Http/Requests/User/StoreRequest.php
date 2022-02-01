<?php

namespace App\Http\Requests\User;

use App\Http\Requests\ApiRequest;
use App\Models\User;
use App\Models\ValueObjects\User\RoleVO;

class StoreRequest extends ApiRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role' => ['required', 'integer', 'between:0,30'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }

    public function makeUser(): User
    {
        // バリデーションした値で埋めたUserを取得
        // roleはVOを生成してセットする
        $role = new RoleVO($this->validated()['role']);
        $attributes = array_merge($this->validated(), ['role' => $role]);
        return new User($attributes);
    }

    /**
     * エラーメッセージ
     *
     * @return array
     */
    public function messages() {
        return [
            'email.unique' => 'emailは既に登録されています。',
        ];
    }
}
