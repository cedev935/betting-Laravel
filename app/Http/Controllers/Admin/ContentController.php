<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Upload;
use App\Models\Content;
use App\Models\ContentDetails;
use App\Models\ContentMedia;
use App\Models\Language;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Stevebauman\Purify\Facades\Purify;


class ContentController extends Controller
{
    use Upload;

    public function index($content)
    {
        if (!array_key_exists($content, config('contents'))) {
            abort(404);
        }

        $contents = Content::with('contentDetails', 'contentMedia')->where('name', $content)->get();
        return view('admin.content.index', compact('content', 'contents'));
    }

    public function create($content)
    {
        if (!array_key_exists($content, config('contents'))) {
            abort(404);
        }
        $languages = Language::all();

        return view('admin.content.create', compact('languages', 'content'));
    }

    public function store(Request $request, $content, $language)
    {
        if (!array_key_exists($content, config('contents'))) {
            abort(404);
        }

        $purifiedData = Purify::clean($request->except('image', 'thumbnail', '_token', '_method'));

        if ($request->has('image')) {
            $purifiedData['image'] = $request->image;
        }
        if ($request->has('thumbnail')) {
            $purifiedData['thumbnail'] = $request->thumbnail;
        }

        $validate = Validator::make($purifiedData, config("contents.$content.validation"), config('contents.message'));

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        // save regular field
        $field_name = array_diff_key(config("contents.$content.field_name"), config("contents.content_media"));

        foreach ($field_name as $name => $type) {
            $description[$name] = $purifiedData[$name][$language];
        }

        // save content for the first time
        $contentModel = new Content();
        $contentModel->name = $content;
        $contentModel->save();

        // save content details on any language
        if ($language != 0) {
            $contentDetails = new ContentDetails();
            $contentDetails->content_id = $contentModel->id;
            $contentDetails->language_id = $language;
            $contentDetails->description = $description ? : null;
            $contentDetails->save();
        }

        // save content media
        if ($request->hasAny(array_keys(config('contents.content_media')))) {
            $contentMedia = new ContentMedia();

            foreach (config('contents.content_media') as $key => $media) {
                if ($request->hasFile($key)) {
                    $size =  null;
                    $thumb =  null;
                    if(config("contents.$content.size.image")){
                        $size = config("contents.$content.size.image");
                    }
                    if(config("contents.$content.size.thumb")){
                        $thumb = config("contents.$content.size.thumb");
                    }

                    $contentMediaDescription[$key] = $this->uploadImage($purifiedData[$key][$language], config('location.content.path'), $size, null, $thumb);
                } elseif ($request->has($key)) {
                    $contentMediaDescription[$key] = linkToEmbed($purifiedData[$key][$language]);
                }
            }


            $contentMedia->content_id = $contentModel->id;
            $contentMedia->description = $contentMediaDescription ?? null;
            $contentMedia->save();
        }

        return redirect(route('admin.content.index', $content))->with('success', 'Content Details Successfully Saved');
    }

    public function show(Content $content, $name = null )
    {
        if (!array_key_exists($content->name, config('contents'))) {
            abort(404);
        }

        $languages = Language::all();
        $contentDetails = ContentDetails::where('content_id', $content->id)->get()->groupBy('language_id');
        $contentMedia = ContentMedia::where('content_id', $content->id)->first();


        return view('admin.content.show', compact('content', 'languages', 'contentDetails', 'contentMedia'));
    }

    public function update(Request $request, Content $content, $language)
    {
        if (!array_key_exists($content->name, config('contents'))) {
            abort(404);
        }

        $purifiedData = Purify::clean($request->except('image', 'thumbnail', '_token', '_method'));

        if ($request->has('image')) {
            $purifiedData['image'] = $request->image;
        }
        if ($request->has('thumbnail')) {
            $purifiedData['thumbnail'] = $request->thumbnail;
        }

        $validate = Validator::make($purifiedData, config("contents.$content->name.validation"), config('contents.message'));
        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        // save regular field
        $field_name = array_diff_key(config("contents.$content->name.field_name"), config("contents.content_media"));

        foreach ($field_name as $name => $type) {
            $description[$name] = $purifiedData[$name][$language];
        }

        if ($language != 0) {
            $contentDetails = ContentDetails::where(['content_id' => $content->id, 'language_id' => $language])->firstOrNew();
            $contentDetails->content_id = $content->id;
            $contentDetails->language_id = $language;
            $contentDetails->description = $description ?? null;
            $contentDetails->save();
        }



        // save contents media
        if ($request->hasAny(array_keys(config('contents.content_media')))) {
            $contentMedia = ContentMedia::where(['content_id' => $content->id])->firstOrNew();

            foreach (config('contents.content_media') as $key => $media) {
                $old_data = optional($contentMedia->description)->{$key} ?? null;
                if ($request->hasFile($key)) {
                    $size =  null;
                    $thumb =  null;
                    if(config("contents.$content->name.size.image")){
                        $size = config("contents.$content->name.size.image");
                    }
                    if(config("contents.$content->name.size.thumb")){
                        $thumb = config("contents.$content->name.size.thumb");
                    }

                    $contentMediaDescription[$key] = $this->uploadImage($purifiedData[$key][$language], config('location.content.path'), $size, $old_data, $thumb);
                } elseif ($request->has($key)) {
                    $contentMediaDescription[$key] = linkToEmbed($purifiedData[$key][$language]);
                } elseif (isset($old_data)) {
                    $contentMediaDescription[$key] = $old_data;
                }
            }



            $contentMedia->content_id = $content->id;
            $contentMedia->description = $contentMediaDescription ?? null;
            $contentMedia->save();
        }

        return back()->with('success', 'Content Details Successfully Saved');
    }

    public function contentDelete($id)
    {
        $content = Content::findOrFail($id);
        $content->delete();
        return back()->with('success', 'Content has been deleted');
    }

}
