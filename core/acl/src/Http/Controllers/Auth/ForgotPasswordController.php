<?php

namespace Botble\ACL\Http\Controllers\Auth;

use Assets;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * @var BaseHttpResponse
     */
    protected $response;

    /**
     * Create a new controller instance.
     * @param BaseHttpResponse $response
     */
    public function __construct(BaseHttpResponse $response)
    {
        $this->middleware('guest');
        $this->response = $response;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author DGL Custom
     */
    public function showLinkRequestForm()
    {
        Assets::addJavascript(['jquery-validation'])
            ->addAppModule(['login'])
            ->removeStylesheets([
                'select2',
                'fancybox',
                'spectrum',
                'simple-line-icons',
                'custom-scrollbar',
                'datepicker',
            ])
            ->removeJavascript([
                'select2',
                'fancybox',
                'cookie',
            ]);

        return view('core.acl::auth.forgot-password');
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param Request $request
     * @param  string $response
     * @return BaseHttpResponse
     * @author DGL Custom
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return $this->response->setMessage(trans($response));
    }
}
