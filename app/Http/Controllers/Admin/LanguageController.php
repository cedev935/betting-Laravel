<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Upload;
use App\Models\Language;
use Illuminate\Http\Request;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
class LanguageController extends Controller
{
    use Upload;

    public function index()
    {
        $existLang =  Language::where('short_name', 'US')->first();
        if(!$existLang){
            $language = new Language();
            $language->name = 'English';
            $language->short_name = 'US';
            $language->is_active = 1;
            $language->rtl = 0;
            $language->save();
            $data = file_get_contents(resource_path('lang/') . 'US.json');
            $json_file = strtoupper($language->short_name) . '.json';
            $path = resource_path('lang/') . $json_file;
            File::put($path, $data);
        }
        $languages = Language::all();

        return view('admin.language.index', compact('languages'));
    }

    public function create()
    {
        return view('admin.language.create');
    }

    public function store(Request $request)
    {
        $purifiedData = Purify::clean($request->except('_token'));
        $validationRules = [
            'name' => 'required|min:2|max:100',
            'short_name' => 'required|size:2|unique:languages',
        ];
        $validate = Validator::make($purifiedData, $validationRules);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }
        $purifiedData = (object) $purifiedData;

        $language = new Language();
        $language->name = $purifiedData->name;
        $language->short_name = $purifiedData->short_name;
        $language->is_active = isset($purifiedData->is_active);
        $language->rtl = isset($purifiedData->rtl);
        if ($request->file('flag') && $request->file('flag')->isValid()) {
            $extension = $request->flag->extension();
            $flagName = strtoupper($purifiedData->short_name . '.' . $extension);
            $this->uploadImage($request->flag, config('location.language.path'), config('location.language.size'), null, null, $flagName);
            $language->flag = $flagName;
        }
        $language->save();

        $data = file_get_contents(resource_path('lang/') . 'US.json');
        $json_file = strtoupper($language->short_name) . '.json';
        $path = resource_path('lang/') . $json_file;
        File::put($path, $data);
        return redirect()->route('admin.language.index')->with('success', 'Language Successfully Saved');
    }

    public function edit(language $language)
    {
        return view('admin.language.edit', compact('language'));
    }

    public function update(Request $request, language $language)
    {
        $purifiedData = Purify::clean($request->all());
        $validationRules = [
            'name' => 'required|min:2|max:100',
            'short_name' => 'required|size:2|unique:languages,short_name,' . $language->id,
        ];

        $validate = Validator::make($purifiedData, $validationRules);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }
        $purifiedData = (object) $purifiedData;

        $language->name = $purifiedData->name;
        $language->short_name = $purifiedData->short_name;
        $language->is_active = $purifiedData->is_active;
        $language->rtl = $purifiedData->rtl;
        if ($request->file('flag') && $request->file('flag')->isValid()) {
            $extension = $request->flag->extension();
            $flagName = strtoupper($purifiedData->short_name . '.' . $extension);
            $this->uploadImage($request->flag, config('location.language.path'), config('location.language.size'), $language->flag, null, $flagName);
            $language->flag = $flagName;
        }
        $language->save();

        $data = file_get_contents(resource_path('lang/') . 'US.json');
        $json_file = strtoupper($language->short_name) . '.json';
        $path = resource_path('lang/') . $json_file;
        File::put($path, $data);
        return redirect(route('admin.language.index'))->with('success', 'Language Successfully Saved');
    }

    public function delete(language $language)
    {
        $this->removeFile(config('location.language.path') . '/' . $language->flag);

        if($language->short_name . '.json' != 'US.json'){
            $this->removeFile(resource_path('lang/') . $language->short_name . '.json');
        }
        $language->mailTemplates()->delete();
        $language->notifyTemplates()->delete();
        $language->contentDetails()->delete();
        $language->templateDetails()->delete();



        $language->delete();

        return back()->with('success', 'Language Has been Deleted');
    }


    public function keywordEdit($id)
    {
        $lang = Language::findOrFail($id);
        $page_title = "Update " . $lang->name . " Keywords";
        $json = file_get_contents(resource_path('lang/') . $lang->short_name . '.json');
        $list_lang = Language::all();

        if (empty($json)) {
            return back()->with('error', 'File Not Found.');
        }
        $json = json_decode($json,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        return view('admin.language.keyword', compact('page_title', 'json', 'lang', 'list_lang'));
    }

    public function keywordUpdate(Request $request, $id)
    {
        $lang = Language::findOrFail($id);
        $content = json_encode($request->keys,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        if ($content === 'null') {
            return back()->with('error', 'At Least One Field Should Be Fill-up');
        }
        file_put_contents(resource_path('lang/') . $lang->short_name . '.json', $content);
        return back()->with('success', 'Update Successfully');
    }

    public function importJson(Request $request)
    {
        $myLang = Language::findOrFail($request->myLangid);
        $lang = Language::findOrFail($request->id);
        $json = file_get_contents(resource_path('lang/') . $lang->short_name . '.json');
        $jsonArray = json_decode($json, true);
        file_put_contents(resource_path('lang/') . $myLang->short_name . '.json', json_encode($jsonArray,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return 'success';
    }





    public function storeKey(Request $request, $id)
    {
        $lang = Language::findOrFail($id);
        $rules = [
            'key' => 'required',
            'value' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $items = file_get_contents(resource_path('lang/') . $lang->short_name . '.json');
        $requestKey = trim($request->key);
        if (array_key_exists($requestKey, json_decode($items, true))) {
            return back()->with('error', "`$requestKey` Already Exist");
        } else {
            $newArr[$requestKey] = trim($request->value);
            $itemsss = json_decode($items, true);
            $result = array_merge($itemsss, $newArr);
            file_put_contents(resource_path('lang/') . $lang->short_name . '.json', json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            return back()->with('success',"`$requestKey` has been added");
        }
    }

    public function deleteKey(Request $request, $id)
    {
        $rules = [
            'key' => 'required',
            'value' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $requestKey = $request->key;
        $requestValue = $request->value;
        $lang = Language::findOrFail($id);
        $data = file_get_contents(resource_path('lang/') . $lang->short_name . '.json');
        $jsonArray = json_decode($data, true);
        unset($jsonArray[$requestKey]);
        file_put_contents(resource_path('lang/'). $lang->short_name . '.json', json_encode($jsonArray,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return back()->with('success', "`$requestKey` has been removed");
    }


    public function updateKey(Request $request, $id)
    {
        $rules = [
            'key' => 'required',
            'value' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $requestKey = trim($request->key);
        $requestValue = $request->value;
        $lang = Language::findOrFail($id);

        $data = file_get_contents(resource_path('lang/') . $lang->short_name . '.json');
        $jsonArray = json_decode($data, true);
        $jsonArray[$requestKey] = $requestValue;
        file_put_contents(resource_path('lang/'). $lang->short_name . '.json', json_encode($jsonArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return back()->with('success', "Update successfully");
    }

}
