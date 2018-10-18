<?php

namespace Botble\Setting\Http\Controllers;

use Assets;
use Botble\Base\Supports\EmailHandler;
use Botble\Page\Repositories\Interfaces\PageInterface;
use Botble\Setting\Http\Requests\EmailTemplateRequest;
use Botble\Setting\Http\Requests\MediaSettingRequest;
use Botble\Setting\Http\Requests\SendTestEmailRequest;
use Botble\Setting\Repositories\Interfaces\SettingInterface;
use Botble\Setting\Supports\SettingStore;
use Exception;
use Illuminate\Support\Facades\File;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Illuminate\Http\Request;

class SettingController extends BaseController
{
    /**
     * @var SettingInterface
     */
    protected $settingRepository;

    /**
     * @var PageInterface
     */
    protected $pageRepository;

    /**
     * SettingController constructor.
     * @param SettingInterface $settingRepository
     * @param PageInterface $pageRepository
     */
    public function __construct(SettingInterface $settingRepository, PageInterface $pageRepository)
    {
        $this->settingRepository = $settingRepository;
        $this->pageRepository = $pageRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author DGL Custom
     */
    public function getOptions()
    {
        page_title()->setTitle(trans('core.setting::setting.title'));

        $pages = $this->pageRepository->allBy(['status' => 1], [], ['id', 'name']);

        return view('core.setting::index', compact('pages'));
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @param SettingStore $setting
     * @return BaseHttpResponse
     * @author DGL Custom
     */
    public function postEdit(Request $request, BaseHttpResponse $response, SettingStore $setting)
    {
        foreach ($request->except(['_token']) as $setting_key => $setting_value) {
            $setting->set($setting_key, $setting_value);
        }

        $setting->save();

        return $response
            ->setPreviousUrl(route('settings.options'))
            ->setMessage(trans('core.base::notices.update_success_message'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getEmailConfig()
    {
        page_title()->setTitle(trans('core.base::layouts.setting_email'));
        Assets::addAppModule(['setting']);

        return view('core.setting::email');
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @param SettingStore $setting
     * @return BaseHttpResponse
     * @author DGL Custom
     */
    public function postEditEmailConfig(Request $request, BaseHttpResponse $response, SettingStore $setting)
    {
        foreach ($request->except(['_token']) as $setting_key => $setting_value) {
            $setting->set($setting_key, $setting_value);
        }

        $setting->save();

        return $response
            ->setPreviousUrl(route('settings.email'))
            ->setMessage(trans('core.base::notices.update_success_message'));
    }

    /**
     * @param $type
     * @param $name
     * @param $template_file
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getEditEmailTemplate($type, $name, $template_file)
    {
        Assets::addAppModule(['setting'])
            ->addStylesheetsDirectly([
                'vendor/core/packages/codemirror/lib/codemirror.css',
                'vendor/core/packages/codemirror/addon/hint/show-hint.css',
                'vendor/core/css/setting.css',
            ])
            ->addJavascriptDirectly([
                'vendor/core/packages/codemirror/lib/codemirror.js',
                'vendor/core/packages/codemirror/lib/css.js',
                'vendor/core/packages/codemirror/addon/hint/show-hint.js',
                'vendor/core/packages/codemirror/addon/hint/anyword-hint.js',
                'vendor/core/packages/codemirror/addon/hint/css-hint.js',
            ]);


        $email_content = get_setting_email_template_content($type, $name, $template_file);
        $email_subject = get_setting_email_subject($type, $name, $template_file);
        $plugin_data = [
            'type' => $type,
            'name' => $name,
            'template_file' => $template_file,
        ];

        page_title()->setTitle(trans(config($type . '.' . $name . '.email.templates.' . $template_file . '.title', '')));
        return view('core.setting::email-template-edit', compact('email_subject', 'email_content', 'plugin_data'));
    }

    /**
     * @param EmailTemplateRequest $request
     * @param BaseHttpResponse $response
     * @param SettingStore $setting
     * @return BaseHttpResponse
     */
    public function postStoreEmailTemplate(EmailTemplateRequest $request, BaseHttpResponse $response, SettingStore $setting)
    {
        if ($request->has('email_subject_key')) {
            $setting->set($request->input('email_subject_key'), $request->input('email_subject'));
            $setting->save();
        }

        save_file_data($request->input('template_path'), $request->input('email_content'), false);
        return $response->setMessage(trans('core.base::notices.update_success_message'));
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @author DGL Custom
     */
    public function postResetToDefault(Request $request, BaseHttpResponse $response)
    {
        $this->settingRepository->deleteBy(['key' => $request->input('email_subject_key')]);
        File::delete($request->input('template_path'));
        return $response->setMessage(trans('core.setting::setting.email.reset_success'));
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @param SettingStore $setting
     * @return BaseHttpResponse
     */
    public function postChangeEmailStatus(Request $request, BaseHttpResponse $response, SettingStore $setting)
    {
        $setting
            ->set($request->input('key'), $request->input('value'))
            ->save();
        return $response->setMessage(trans('core.base::notices.update_success_message'));
    }

    /**
     * @param BaseHttpResponse $response
     * @param SendTestEmailRequest $request
     * @param EmailHandler $emailHandler
     * @return BaseHttpResponse
     * @throws \Throwable
     * @author DGL Custom
     */
    public function postSendTestEmail(BaseHttpResponse $response, SendTestEmailRequest $request, SettingStore $settingStore, EmailHandler $emailHandler)
    {
        try {
            $emailHandler->send('{{ header }}' . __('Email sent from: ' . $settingStore->get('site_title') . ' at ' . now()) . '{{ footer }}', __('Test title'), $request->input('email'), [], true);
            return $response->setMessage(__('Send email successfully!'));
        } catch (Exception $exception) {
            return $response->setError()
                ->setMessage($exception->getMessage());
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author DGL Custom
     */
    public function getMediaSetting()
    {
        page_title()->setTitle(trans('core.setting::setting.media.title'));
        return view('core.setting::media');
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @param SettingStore $setting
     * @return BaseHttpResponse
     * @author DGL Custom
     */
    public function postEditMediaSetting(MediaSettingRequest $request, BaseHttpResponse $response, SettingStore $setting)
    {
        foreach ($request->except(['_token']) as $setting_key => $setting_value) {
            $setting->set($setting_key, $setting_value);
        }

        $setting->save();

        return $response
            ->setPreviousUrl(route('settings.media'))
            ->setMessage(trans('core.base::notices.update_success_message'));
    }
}
