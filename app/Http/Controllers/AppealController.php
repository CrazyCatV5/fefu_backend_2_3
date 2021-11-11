<?php

namespace App\Http\Controllers;

use App\Models\Appeal;
use Illuminate\Http\Request;

class AppealController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $errors = [];
        $success = $request->session()->get('success', false);

        if ($request->isMethod('post')) {
            $name = $request->input('name');
            $phone = $request->input('phone');
            $email = $request->input('email');
            $message = $request->input('message');

            if ($name === null) {
                $errors['name'] = 'Укажите ваше имя';
            }
            if ($phone === null && $email === null) {
                $errors['contacts'] = 'Укажите электронную почту или телефон';
            }
            if ($message === null) {
                $errors['message'] = 'Поле "message" не заполнено ';
            }

            if (strlen($name) > 20) {
                $errors['name'] = 'Слишком длинное имя ';
            }

            if (strlen($phone) > 11) {
                $errors['phone'] = 'Телефон Слишком длинный';
            }

            if (strlen($email) > 100) {
                $errors['email'] = 'Электронная почта слишком длинная';
            }

            if (strlen($message) > 100) {
                $errors['message'] = 'Введите менее длинное сообщение';
            }

            if (count($errors) > 0) {
                $request->flash();
            } else {
                $appeal = new Appeal();
                $appeal->name = $name;
                $appeal->phone = $phone;
                $appeal->email = $email;
                $appeal->message = $message;
                $appeal->save();

                $success = true;

                return redirect()
                    ->route('appeal')
                    ->with('success', $success);
            }
        }

        return view('appeal', ['errors' => $errors, 'success' => $success]);
    }
}
