<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Configure;
use App\Models\Language;
use App\Models\NotifyTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;
class NotifyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function notifyConfig()
    {
        $control = Configure::first();
        return view('admin.notify.controls', compact('control'));
    }

    public function notifyConfigUpdate(Request $request)
    {
        $reqData = Purify::clean($request->except('_token', '_method'));
        $request->validate([
            'PUSHER_APP_ID' => 'required|integer|not_in:0',
            'PUSHER_APP_KEY' => 'required|string|min:5',
            'PUSHER_APP_SECRET' => 'required|string|min:5',
            'PUSHER_APP_CLUSTER' => 'required|string',
        ]);

        $control = Configure::first();
        $in['push_notification'] =   (int)$reqData['push_notification'];
        $control->fill($in)->save();

        config(['basic.push_notification' => (int)$reqData['push_notification']]);
        $fp = fopen(base_path() . '/config/basic.php', 'w');
        fwrite($fp, '<?php return ' . var_export(config('basic'), true) . ';');
        fclose($fp);



        $envPath = base_path('.env');
        $env = file($envPath);
        $env = $this->set('PUSHER_APP_ID', $reqData['PUSHER_APP_ID'], $env);
        $env = $this->set('PUSHER_APP_KEY', $reqData['PUSHER_APP_KEY'], $env);
        $env = $this->set('PUSHER_APP_SECRET', $reqData['PUSHER_APP_SECRET'], $env);
        $env = $this->set('PUSHER_APP_CLUSTER', $reqData['PUSHER_APP_CLUSTER'], $env);
        $fp = fopen($envPath, 'w');
        fwrite($fp, implode($env));
        fclose($fp);


        Artisan::call('optimize:clear');
        return back()->with('success', 'Updated Successfully.');
    }

    public function show()
    {
        $notifyTemplate = NotifyTemplate::groupBy('template_key')->distinct()->orderBy('template_key')->get();
        return view('admin.notify.show',compact('notifyTemplate'));
    }

    public function edit(NotifyTemplate $notifyTemplate, $id)
    {
        $notifyTemplate = NotifyTemplate::findOrFail($id);
        $languages = Language::orderBy('short_name')->get();
        if($notifyTemplate->notify_for == 0){
            foreach ($languages as $lang){
                $checkTemplate =  NotifyTemplate::where('template_key',$notifyTemplate->template_key)->where('language_id',$lang->id)->count();

                if($lang->short_name == 'en' && ($notifyTemplate->language_id  == null)){
                    $notifyTemplate->language_id = $lang->id;
                    $notifyTemplate->short_name = $lang->short_name;
                    $notifyTemplate->save();
                }

                if(0 == $checkTemplate){
                    $template = new  NotifyTemplate();
                    $template->language_id = $lang->id;
                    $template->name = $notifyTemplate->name;
                    $template->template_key = $notifyTemplate->template_key;
                    $template->body = $notifyTemplate->body;
                    $template->short_keys = $notifyTemplate->short_keys;
                    $template->status = $notifyTemplate->status;
                    $template->lang_code = $lang->short_name;
                    $template->save();
                }
            }
        }

        $templates = NotifyTemplate::where('template_key',$notifyTemplate->template_key)->with('language')->get();
        return view('admin.notify.edit',compact('notifyTemplate','languages','templates'));
    }

    public function update(Request $request, NotifyTemplate $notifyTemplate, $id)
    {
        $templateData = Purify::clean($request->all());

        $rules = [
            'body' => 'sometimes|required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $template = NotifyTemplate::findOrFail($id);
        $template->status = $templateData['status'];
        $template->body = $templateData['body'];
        $template->save();

        return back()->with('success', 'Update Successfully');
    }


    private function set($key, $value, $env)
    {
        foreach ($env as $env_key => $env_value) {
            $entry = explode("=", $env_value, 2);
            if ($entry[0] == $key) {
                $env[$env_key] = $key . "=" . $value . "\n";
            } else {
                $env[$env_key] = $env_value;
            }
        }
        return $env;
    }

}
