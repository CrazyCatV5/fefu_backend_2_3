<?php

namespace App\Http\Controllers;

use App\Models\Appeal;
use App\Sanitizers\PhoneSanitizer;
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
        $success = $request->session()->get('success', false);

        if ($request->isMethod('post')) {
            $validated = $request->validate((new \App\Http\Requests\AppealPostRequest)->rules());

            $appeal = new Appeal();
            $appeal->name = $validated['name'];
            $appeal->surname = $validated['surname'];
            $appeal->patronymic = $validated['patronymic'];
            $appeal->age = $validated['age'];
            $appeal->gender = $validated['gender'];
            $appeal->phone = PhoneSanitizer::sanitize($validated['phone']);
            $appeal->email = $validated['email'];
            $appeal->message = $validated['message'];
            $appeal->save();
            $success = true;

            return redirect()
                ->route('appeal')
                ->with('success', $success);

        } else {
            return view('appeal', ['success' => $success]);
        }

    }
}
