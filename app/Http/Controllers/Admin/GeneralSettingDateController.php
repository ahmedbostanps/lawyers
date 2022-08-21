<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Model\GeneralSettings;
use Illuminate\Support\Facades\DB;

class GeneralSettingDateController extends Controller
{
    //
    public function index()
    {


       $user = Auth::guard('admin')->user();
        if(! $user->can('general_setting_edit')){
            abort(403, 'عمل غير مصرح به.');
        }

        //'Asia/Kolkata'
        $this->data['timezone'] = DB::table('zone')->get();
        $GeneralSettings  = GeneralSettings::findOrfail(1);
        $this->data['title'] = 'Mail Setup';
        $this->data['GeneralSettings'] = $GeneralSettings;
        $this->data['countrys'] = DB::table('countries')->get();
        $this->data['states']   = DB::table('states')->where('country_id',$GeneralSettings->country)->get();
        $this->data['citys']   = DB::table('cities')->where('state_id',$GeneralSettings->state)->get();
    	return view('admin.settings.general_setting_date', $this->data);
    }


    public function update(Request $request,$id)
    {


        $GeneralSettings  = GeneralSettings::findOrfail($id);

        $GeneralSettings->date_formet  = $request->forment;
        $GeneralSettings->timezone  = $request->timezone;

        $GeneralSettings->save();

        Session::flash('success',"حفظ بنجاح");
       return redirect()->back();

    }
}
