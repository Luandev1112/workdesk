<?php

namespace App\Http\Controllers;

// use Symfony\Component\Console\Input\Input;
use App\Rules\Lowercase;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Language;
use App\Models\Translation;
use Validator;
use Redirect;
use Session;
use File;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $rules = array();
    private $messages = array();

    public function __construct()
    {
        $this->middleware(['permission:show system languages setting'])->only('index');

        $this->rules = [
            'name' => [
                'required',
                'unique:languages,name',
                'max:255',
            ],
            'code' => [
                'required',
                'unique:languages,code',
                'max:2',
                new Lowercase,
            ],
        ];

        $this->messages = [
            'name.required' => translate('Name is required'),
            'name.unique' => translate('Name must be unique'),
            'name.max' => translate('Name must less than :max characters'),
            'code.required' => translate('Code is required'),
            'code.unique' => translate('Code must be unique'),
            'code.max' => translate('Code must less than :max characters'),

        ];
    }

    public function index()
    {
        $languages = Language::paginate(10);
        return view('admin.default.system_configurations.languages.index', compact('languages'));
    }

    public function changeLanguage($locale)
    {
        Session::put('locale', $locale);
        $language = Language::where('code', $locale)->first();
        flash(translate('Language changed to ') . $language->name)->success();
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $language = new Language;
        $language->name = $request->name;
        $language->code = $request->code;
        $language->rtl = isset($request->rtl) ? 1 : 0;
        $language->enable = 1;

        $rules = $this->rules;
        $messages = $this->messages;
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            flash(translate('Something went wrong'))->error();
            return Redirect::back()->withErrors($validator);
        }

        if ($language->save()) {
            // saveJSONFile($language->code, openJSONFile('en'));
            flash(translate('Language has been inserted successfully'))->success();
            return redirect()->route('languages.index');
        }
        else {
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    public function show(Request $request, $id)
    {
        $sort_search  = null;
        $language     = Language::findOrFail(decrypt($id));
        $lang_keys    = Translation::where('lang', env('DEFAULT_LANGUAGE', 'en'));
        if ($request->has('search')){
            $sort_search  = $request->search;
            $lang_keys    = $lang_keys->where('lang_key', 'like', '%'.$sort_search.'%');
        }
        $lang_keys = $lang_keys->paginate(50);
        return view('admin.default.system_configurations.languages.language_view', compact('language','lang_keys','sort_search'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $language = Language::findOrFail(decrypt($id));
        return view('admin.default.system_configurations.languages.edit', compact('language'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (env("DEMO_MODE") == "On") {
            flash(translate('This action is blocked in demo version!'))->error();
            return back();
        }

        $language = Language::findOrFail($id);
        $prev_code = $language->code;
        $language->name = $request->name;
        $language->code = $request->code;
        $language->rtl = isset($request->rtl) ? 1 : 0;

        $rules = $this->rules;
        $rules['name'] = [
            'required',
            Rule::unique('languages')->ignore($language->id),
            'max:255'
        ];
        $rules['code'] = [
            'required',
            Rule::unique('languages')->ignore($language->id),
            'max:2',
            new Lowercase,
        ];
        $messages = $this->messages;
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            flash(translate('Something went wrong'))->error();
            return Redirect::back()->withErrors($validator);
        }

        if ($language->save()) {
            // saveJSONFile($language->code, openJSONFile($prev_code));
            flash(translate('Language has been updated successfully'))->success();
            return redirect()->route('languages.index');
        } else {
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (env("DEMO_MODE") == "On") {
            flash(translate('This action is blocked in demo version!'))->error();
            return back();
        }
        $language = Language::findOrFail($id);
        if ($language->code != env('DEFAULT_LANGUAGE')) {
            $language->delete();
            flash(translate('Language has been deleted successfully'))->success();
            return redirect()->route('languages.index');
        } else {
            flash(translate('You can not delete default language'))->error();
            return back();
        }
    }

    public function key_value_store(Request $request)
    {
        $language = Language::findOrFail($request->id);
        foreach ($request->values as $key => $value) {
          $translation_def = Translation::where('lang_key', $key)->where('lang', $language->code)->first();
          if($translation_def == null){
              $translation_def              = new Translation;
              $translation_def->lang        = $language->code;
              $translation_def->lang_key    = $key;
              $translation_def->lang_value  = $value;
              $translation_def->save();
          }
          else {
              $translation_def->lang_value = $value;
              $translation_def->save();
          }
        }
        flash(translate('Translations updated for ').$language->name)->success();
        return back();
    }

    public function update_language_status(Request $request)
    {
        $language = Language::findOrFail($request->id);
        $language->enable = $request->status;
        $status_active_count = count(Language::where('enable', 1)->get());
        if ($request->status == 0) {
            if ($status_active_count == 1) {
                return 2;
            }
        }
        if ($language->save()) {
            return 1;
        }
        return 0;
    }
}
