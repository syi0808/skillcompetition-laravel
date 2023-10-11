<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function checkIdDuplicated(Request $request) {
        $user = User::query()->where('id', $request->get('id'))->first();

        if($user) {
            return response()->json([
                'result' => 'unable',
                'message' => '사용할 수 없는 아이디 입니다.',
                'data' => [],
            ]);
        } else {
            return response()->json([
                'result' => 'able',
                'message' => '사용 가능한 아이디 입니다.',
                'data' => [],
            ]);
        }
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'id'=>'required|max:20|unique:users',
            'password'=>'required|max:8',
            'name'=>'required|max:5',
            'tel'=>'required|min:13|max:13',
            'address'=>'max:200',
        ]);

        if($validator->fails()) {
            return response()->json([
                'result' => 'fail',
                'message' => '회원가입을 할 수 없습니다. 관리자에게 문의해 주세요.',
                'data' => [],
            ], 400);
        }

        $input = $request->all();

        $input['role'] = 'general';

        User::query()->create($input);

        return response()->json([
            'result' => 'success',
            'message' => '정상적으로 가입 되었습니다.',
            'data' => [],
        ]);
    }

    public function login(Request $request) {
        $user = User::query()->where(['id' => $request->get('id'), 'password' => $request->get('password')])->first(['id', 'name', 'tel']);

        if($user) {
            $request->session()->regenerate();

            Auth::login($user);

            return response()->json([
                'result' => 'success',
                'message' => '어서오세요.',
                'data' => [$user],
            ]);
        }

        return response()->json([
            'result' => 'fail',
            'message' => '아이디 또는 비밀번호가 일치하지 않습니다.',
            'data' => []
        ], 400);
    }

    public function logout(Request $request) {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Auth::logout();
    }
}
