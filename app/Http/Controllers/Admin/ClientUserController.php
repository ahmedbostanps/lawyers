<?php

namespace App\Http\Controllers\Admin;

use App\Model\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Admin;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Helpers\LogActivity;
use App\Model\CourtCase;
use App\Model\TaskMember;
use App\Model\CaseMember;
use App\Model\CaseLog;
use Illuminate\Support\Facades\Validator;
use App\Traits\DatatablTrait;
use App\Model\Role;
use Illuminate\Support\Facades\Auth;

class clientUserController extends Controller
{
    use DatatablTrait;

    public function index()
    {
        $user = Auth::guard('admin')->user();
        if ($user->user_type == "User") {
            abort(403, 'عمل غير مصرح به.');
        }
        return view('admin.team-members.team_member');
    }


    public function create()
    {
        $user = Auth::guard('admin')->user();
        if ($user->user_type == "User") {
            abort(403, 'عمل غير مصرح به.');
        }

        $data['country'] = DB::table('countries')->where('id', 101)->first();
        $data['states'] = DB::table('states')->where('country_id', 101)->get();
        $data['roles'] = Role::where('id', '!=', '1')->get();
        return view('admin.team-members.team_member_create', $data);
    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'role' => 'required',
            'f_name' => 'required',
            'l_name' => 'required',
            'address' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city_id' => 'required',
            'email' => 'required|unique:admins',
            'mobile' => 'required',
            'zip_code' => 'required',
            'password' => 'required',
            'cnm_password' => 'required|same:password',
            'user_source' => 'required',
            'input_img' => 'sometimes|image',
        ]);
        if ($validator->passes()) {
            $client = new Admin;
            //check folder exits if not exit then creat automatic
            $pathCheck = public_path() . config('constants.CLIENT_FOLDER_PATH');
            if (!file_exists($pathCheck)) {
                File::makeDirectory($pathCheck, $mode = 0777, true, true);
            }

            //profile image upload
            /*if ($request->hasFile('image')) {
             $image = $request->file('image');
             $name = time().'_'.rand(1,4).$image->getClientOriginalName();
             $destinationPath = public_path() . config('constants.CLIENT_FOLDER_PATH');
             $image->move($destinationPath, $name);
             $client->profile_img=$name;
            }*/
            if ($request->hasFile('image')) {
                $data = $request->imagebase64;

                list($type, $data) = explode(';', $data);
                list(, $data) = explode(',', $data);

                $data = base64_decode($data);
                $image_name = time() . '.png';

                $path = public_path() . "/upload/profile/" . $image_name;

                file_put_contents($path, $data);

                $client->profile_img = $image_name;

            }
            $pwd = 'No';//config('constants.CLIENT_PASSWORD_FOR_JR_ADVO');
            // profile_img
            //$client->advocate_id    = $advocate_id;
            $client->is_user_type = "STAFF";
            $client->is_activated = "1";
            $client->password = Hash::make($request->password);
            $client->first_name = $request->f_name;
            $client->name = $request->username;
            $client->last_name = $request->l_name;
            $client->email = $request->email;
            $client->mobile = $request->mobile;
            $client->zipcode = $request->zip_code;
            $client->address = $request->address;
            $client->country_id = $request->country;
            $client->state_id = $request->state;
            $client->city_id = $request->city_id;
            $client->user_source = $request->user_source;


            $client->save();


            if ($client->save()) {
                $client->roles()->sync($request->role);
            }


            //Session::flash('success',"Team member created successfully.");
            return redirect()->route('client_user.index')->with('success', "تم إنشاء عضو الفريق بنجاح.");
        }
        return back()->with('errors', $validator->errors());
    }

    public function completeSetupWizard(Request $request)
    {

        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'address' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'email' => 'required',
            'mobile_no' => 'required',
            'registration_no' => 'required',
            'associated_name' => 'required',
            'zipcode' => 'required',
            // 'image' => 'sometimes|image',
        ]);

        $client = Admin::find($request->advocate_id);
        //check folder exits if not exit then creat automatic
        $pathCheck = public_path() . config('constants.CLIENT_FOLDER_PATH');
        if (!file_exists($pathCheck)) {
            File::makeDirectory($pathCheck, $mode = 0777, true, true);
        }

        //profile image upload
        /* if ($request->hasFile('image')) {
          $image = $request->file('image');
          $name = time().'_'.rand(1,4).$image->getClientOriginalName();
          $destinationPath = public_path() . config('constants.CLIENT_FOLDER_PATH');
          $image->move($destinationPath, $name);
          $client->profile_img=$name;
         }*/
        if ($request->hasFile('image')) {
            $data = $request->imagebase64;

            list($type, $data) = explode(';', $data);
            list(, $data) = explode(',', $data);

            $data = base64_decode($data);
            $image_name = time() . '.png';

            $path = public_path() . "/upload/profile/" . $image_name;

            file_put_contents($path, $data);

            $client->profile_img = $image_name;

        }
        $client->is_user_type = "ADVOCATE";
        $client->is_account_setup = "1";
        $client->first_name = $request->firstname;
        $client->last_name = $request->lastname;
        $client->mobile = $request->mobile_no;
        $client->registration_no = $request->registration_no;
        $client->associated_name = $request->associated_name;
        $client->zipcode = $request->zipcode;
        $client->address = $request->address;
        $client->country_id = $request->country_id;
        $client->state_id = $request->state_id;
        $client->city_id = $request->city_id;
        $client->save();

        $redirect_url = '#';
        $activity = '';
        LogActivity::addToLog('Account setup. ', $activity, $redirect_url);

        Session::flash('success', "تم إعداد الحساب بنجاح.");
        return redirect()->route('dashboard.index');
    }


    public function check_user_name_exits(Request $request)
    {

        if ($request->id == "") {
            $count = Admin::where('name', $request->name)->count();
            if ($count == 0) {
                return 'true';
            } else {
                return 'false';
            }
        } else {
            $count = Admin::where('name', '=', $request->name)
                ->where('id', '<>', $request->id)
                ->count();
            if ($count == 0) {
                return 'true';
            } else {
                return 'false';
            }
        }
    }

    public function check_user_email_exits(Request $request)
    {

        if ($request->id == "") {
            $count = Admin::where('email', $request->email)->count();
            if ($count == 0) {
                return 'true';
            } else {
                return 'false';
            }
        } else {
            $count = Admin::where('email', '=', $request->email)
                ->where('id', '<>', $request->id)
                ->count();
            if ($count == 0) {
                return 'true';
            } else {
                return 'false';
            }
        }
    }


    public function clientUserList(Request $request)
    {
        /*
          |----------------
          | Listing colomns
          |----------------
         */

        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'email',
            3 => 'mobile',
            4 => 'role_id',
            5 => 'is_active',
        );

        //$advocate_id = $this->getLoginUserId();

        $totalData = DB::table('admins AS a')
            ->leftJoin('admin_role AS ar', 'ar.admin_id', '=', 'a.id')
            ->leftJoin('roles AS r', 'r.id', '=', 'ar.role_id')
            ->select('a.id AS id', 'a.first_name AS first_name', 'a.last_name AS last_name', 'a.email AS email', 'a.is_active AS is_active', 'a.mobile AS mobile', 'r.slug as role')
            ->where('user_type', '=', 'User')
            ->count();


        $totalFiltered = $totalData;
        $totalRec = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $cats = DB::table('admins AS a')
                ->leftJoin('admin_role AS ar', 'ar.admin_id', '=', 'a.id')
                ->leftJoin('roles AS r', 'r.id', '=', 'ar.role_id')
                ->select('a.id AS id', 'a.first_name AS first_name', 'a.last_name AS last_name', 'a.email AS email', 'a.is_active AS is_active', 'a.mobile AS mobile', 'r.slug as role')
                ->where('user_type', '=', 'User')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            /*
              |--------------------------------------------
              | For table search filterfrom frontend site.
              |--------------------------------------------
             */
            $search = $request->input('search.value');


            $cats = DB::table('admins AS a')
                ->leftJoin('admin_role AS ar', 'ar.admin_id', '=', 'a.id')
                ->leftJoin('roles AS r', 'r.id', '=', 'ar.role_id')
                ->select('a.id AS id', 'a.first_name AS first_name', 'a.last_name AS last_name', 'a.email AS email', 'a.is_active AS is_active', 'a.mobile AS mobile', 'r.slug as role')
                ->where('user_type', '=', 'User')
                ->where(function ($cats) use ($search) {
                    $cats->where('a.id', 'LIKE', "%{$search}%")
                        ->orWhere('a.first_name', 'LIKE', "%{$search}%")
                        ->orWhere('a.last_name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%")
                        ->orWhere('mobile', 'LIKE', "%{$search}%");
                })->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = DB::table('admins AS a')
                ->leftJoin('admin_role AS ar', 'ar.admin_id', '=', 'a.id')
                ->leftJoin('roles AS r', 'r.id', '=', 'ar.role_id')
                ->select('a.id AS id', 'a.first_name AS first_name', 'a.last_name AS last_name', 'a.email AS email', 'a.is_active AS is_active', 'a.mobile AS mobile', 'r.slug as role')
                ->where('user_type', '=', 'User')
                ->where(function ($cats) use ($search) {
                    $cats->where('a.id', 'LIKE', "%{$search}%")
                        ->orWhere('a.first_name', 'LIKE', "%{$search}%")
                        ->orWhere('a.last_name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%")
                        ->orWhere('mobile', 'LIKE', "%{$search}%");
                })->count();
        }
        /*
          |----------------------------------------------------------------------------------------------------------------------------------
          | Creating json array with all records based on input from front end site like all,searcheded,pagination record (i.e 10,20,50,100).
          |----------------------------------------------------------------------------------------------------------------------------------
         */
        $data = array();
        if (!empty($cats)) {
            foreach ($cats as $cat) {


                $nestedData['status'] = $this->status($cat->is_active, $cat->id, route('client_user.status'));


                if (empty($request->input('search.value'))) {
                    $final = $totalRec - $start;
                    $nestedData['id'] = $final;
                    $totalRec--;
                } else {
                    $start++;
                    $nestedData['id'] = $start;
                }
                $nestedData['email'] = $cat->email;
                $nestedData['mobile'] = $cat->mobile;
                $nestedData['role_id'] = $cat->role ?? null;
                $nestedData['name'] = $cat->first_name . ' ' . $cat->last_name;


                $nestedData['options'] = $this->action([
                    'edit' => route('client_user.edit', $cat->id),
                    'tasks' => route('client_user.tasks', $cat->id),
                    'delete_permission' => '1',
                    'edit_permission' => '1',
                    'delete' => collect([
                        'id' => $cat->id,
                        'action' => route('client_user.destroy', $cat->id),
                    ]),

                ]);
                $data[] = $nestedData;
            }
        }


        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }


    public function tasks($id)
    {
        $user = Auth::guard('admin')->user();
        if ($user->user_type == "User") {
            abort(403, 'عمل غير مصرح به.');
        }
        $data['admin'] = Admin::query()->findOrFail($id);

        return view('admin.team-members.task', $data);

    }

    public function tasksDatatable($id, Request $request)
    {
        $user = Auth::guard('admin')->user();
        if ($user->user_type == "User") {
            abort(403, 'عمل غير مصرح به.');
        }
        $admin = Admin::query()->findOrFail($id);
//dd($data);


        $user = Auth::guard('admin')->user();
        $isEdit = $user->can('task_edit');
        $isDelete = $user->can('task_delete');


        $columns = array(
            0 => 'id',
            1 => 'task_subject',
            3 => 'start_date',
            4 => 'end_date',

        );

        $totalData = DB::table('tasks AS task')->count();
        $totalRec = $totalData;


        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');
        $columns = $request->input('columns');

        $customcollections = Task::query()
            ->whereHas('members', function ($q) use ($admin) {
                $q->where('employee_id', $admin->id);
            })
            ->when($search, function ($query, $search) {
                return $query->where('task_subject', 'LIKE', "%{$search}%");
            })
            ->when($columns, function ($query, $columns) {
                if (isset($columns[3]['search']['value']) && !empty($columns[3]['search']['value'])) {
                    $query->where('start_date', $columns[3]['search']['value']);
                }
                return $query;
            });


//        $customcollections = DB::table('tasks AS task')
//            ->join('task_members', 'task.id', '=', 'task_members.task_id')
////            ->where('task_members.employee_id' ,   $data['admin']->id )
//            ->when($search, function ($query, $search) {
//                return $query->where('task_subject', 'LIKE', "%{$search}%");
//            })
//            ->when($columns, function ($query, $columns) {
//                if (isset($columns[3]['search']['value']) && !empty($columns[3]['search']['value'])) {
//                    $query->where('start_date', $columns[3]['search']['value']);
//                }
//                return $query;
//            });


        $totalFiltered = $customcollections->count();

        $customcollections = $customcollections->offset($start)->limit($limit)->orderBy($order, $dir)->get();

        $data = [];
        $task_controller = new TaskController();

        foreach ($customcollections as $key => $item) {

            $show = route('clients.show', $item->id);

            // $row['id'] = $item->id;
            if (empty($request->input('search.value'))) {
                $final = $totalRec - $start;
                $row['id'] = $final;
                $totalRec--;
            } else {
                $start++;
                $row['id'] = $start;
            }

            $row['task_subject'] = $item->task_subject;
            if ($item->rel_id != 0) {
                $val = $task_controller->getCaseDetail($item->rel_id);

                $case = '<b> ' . $val->first_name . ' ' . $val->middle_name . ' ' . $val->last_name . '</b>
                      <p>رقم القضية :<b> ' . $val->case_number . '</b></p>';
                $row['case'] = $case;
            } else {

                $row['case'] = "Other";
            }


            $row['start_date'] = date(LogActivity::commonDateFromatType(), strtotime($item->start_date));
            $row['end_date'] = date(LogActivity::commonDateFromatType(), strtotime($item->end_date));

            $row['members'] = $task_controller->getMembers($item->id);

            $taskStatus = $item->project_status;

            $lableColor = '';
            $status = "";

            if ($taskStatus == 'not_started') {
                $status = "لم يبدأ";
                $lableColor = 'label label-primary';
            } elseif ($taskStatus == 'in_progress') {
                $status = "قيد الانجاز";
                $lableColor = 'label label-info';
            } elseif ($taskStatus == 'completed') {
                $status = "مكتمل";
                $lableColor = 'label label-success';
            } elseif ($taskStatus == 'deferred') {
                $status = "مؤجل";
                $lableColor = 'label label-danger';
            } else {
                $status = "-";

            }

            $row['status'] = "<span class='" . $lableColor . "'>" . $status . "</span>";


            $taskPriority = $item->priority;
            $lableColor = '';


            if ($taskPriority == 'Low') {
                $taskPriorityLabel = "قليل";
                $lableColor = 'label label-primary';
            } elseif ($taskPriority == 'medium') {
                $taskPriorityLabel = "متوسط";
                $lableColor = 'label label-info';
            } elseif ($taskPriority == 'high') {
                $taskPriorityLabel = "عالي";
                $lableColor = 'label label-danger';
            } elseif ($taskPriority == 'urgent') {
                $taskPriorityLabel = "عاجل";
                $lableColor = 'label label-danger';
            } else {
                $taskPriorityLabel = "-";
                $lableColor = '';

            }


            $row['priority'] = "<span class='" . $lableColor . "'>" . $taskPriorityLabel . "</span>";

            // $row['status'] ="yiyui";

            if ($isEdit == "1" || $isDelete == "1") {
                $row['action'] = $this->action([

                    'edit' => route('tasks.edit', $item->id),
                    'delete' => collect([
                        'id' => $item->id,
                        'action' => route('tasks.destroy', $item->id),
                    ]),
                    'edit_permission' => $isEdit,
                    'delete_permission' => $isDelete,
                ]);
            } else {
                $row['action'] = [];

            }

            $data[] = $row;

        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        );

        return response()->json($json_data);


    }

    public function edit($id)
    {
        $user = Auth::guard('admin')->user();
        if ($user->user_type == "User") {
            abort(403, 'عمل غير مصرح به.');
        }

        $data['roles'] = Role::where('id', '!=', '1')->get();

        // $data['country']   = DB::table('countries')->where('id',101)->first();
        $data['users'] = Admin::with('country', 'state', 'city')->find($id);
        // $data['states'] = DB::table('states')->where('country_id',$data['users']->country_id)->get();
        // $data['citys'] = DB::table('cities')->where('state_id',$data['users']->state_id)->get();
        return view('admin.team-members.team_member_edit', $data);
    }


    public function insertJrAdvoToDBbyAjax(Request $request)
    {
        $jr_advo_email = $request->email;
        $check = DB::table('admins')->where('email', $jr_advo_email)->count();
        if ($check > 0) {
            echo 'exists';
        } else {
            $pwd = 'No';//config('constants.CLIENT_PASSWORD_FOR_JR_ADVO');
            $insert_row = Admin::create([
                'name' => $request->name,
                'advocate_id' => $request->advocate_id,
                'email' => $request->email,
                'password' => $pwd,
                'is_user_type' => 'STAFF',
            ]);
            $my_id = $insert_row->id;

            //generate a random string using Laravel's str_random helper
            $insert_arr = $insert_row->toArray();
            $insert_arr['link'] = str_random(30);
            if ($insert_row) {
                //Get email template content and replcae with value
                $verifyLink = url('admin/user/invitation', $insert_arr['link']);
                $replace = array('{{link}}' => $verifyLink, '{{email}}' => $insert_arr['email'], '{{name}}' => $insert_arr['name']);
                $email_template = DB::table('emails')->where('id', 4)->first();
                $insert_arr['templateContent'] = $this->strReplaceAssoc($replace, $email_template->message_boddy);

                DB::table('invites')->insert(['admin_id' => $my_id, 'advocate_id' => $request->advocate_id, 'token' => $insert_arr['link']]);
                Mail::send('emails.invitation', $insert_arr, function ($message) use ($insert_arr) {
                    $message->to($insert_arr['email']);
                    $message->subject('AdvocateDairy - Invitation to Access Advocate Dairy');
                });
                echo '<div class="row" id="item_' . $my_id . '">
                        <div class="col-sm-5">
                                <div class="form-group label-floating">
                                        <label class="control-label">Name</label>
                                        <input name="added_name" id="added_name" type="text" class="form-control" value="' . $request->name . '" >
                                </div>
                        </div>
                        <div class="col-sm-5">
                                <div class="form-group label-floating">
                                        <label class="control-label">Email Address</label>
                                        <input name="added_email" id="added_email" type="email" class="form-control" value="' . $request->email . '" >
                                </div>
                        </div>
                        <div class="col-sm-2">
                                <div class="form-group label-floating">
                                        <input data-repeater-delete class="btn btn-fill btn-danger del_button" id="del-' . $my_id . '" type="button" value="Delete"/>
                                </div>
                        </div>
                </div>';
            }
        }
    }

    public function update(Request $request, $id)
    {

        //dd($request->All());
        $validator = Validator::make($request->all(), [
            'role' => 'required',
            'f_name' => 'required',
            'l_name' => 'required',
            'address' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city_id' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'zip_code' => 'required',
            'input_img' => 'sometimes|image',
            'user_source' => 'required',
        ]);

        if ($validator->passes()) {

            $client = Admin::find($id);

            //check folder exits if not exit then creat automatic
            $pathCheck = public_path() . config('constants.CLIENT_FOLDER_PATH');
            if (!file_exists($pathCheck)) {
                File::makeDirectory($pathCheck, $mode = 0777, true, true);
            }

            //remove image
            if ($request->is_remove_image == "Yes" && $request->file('image') == "") {

                if ($client->profile_img != '') {

                    $imageUnlink = public_path() . config('constants.CLIENT_FOLDER_PATH') . '/' . $client->profile_img;
                    if (file_exists($imageUnlink)) {
                        unlink($imageUnlink);
                    }
                    $client->profile_img = '';
                }
            }

            //profile image upload
            if ($request->hasFile('image')) {


                if ($client->profile_img != '') {

                    $imageUnlink = public_path() . config('constants.CLIENT_FOLDER_PATH') . '/' . $client->profile_img;
                    if (file_exists($imageUnlink)) {
                        unlink($imageUnlink);
                    }
                    $client->profile_img = '';
                }


                $data = $request->imagebase64;

                list($type, $data) = explode(';', $data);
                list(, $data) = explode(',', $data);


                $data = base64_decode($data);
                $image_name = time() . '.png';
                $path = public_path() . "/upload/profile/" . $image_name;

                file_put_contents($path, $data);

                $client->profile_img = $image_name;

                /* $image = $request->file('image');
                 $name = time().'_'.rand(1,4).$image->getClientOriginalName();
                 $destinationPath = public_path() . config('constants.CLIENT_FOLDER_PATH');
                 $image->move($destinationPath, $name);
                 $client->profile_img=$name;*/
            }
            // $clientName = $request->f_name.' '.$request->l_name;

            //login user id
            $client->first_name = $request->f_name;
            $client->name = $request->username;
            $client->last_name = $request->l_name;
            if ($request->chk_pass == 'yes') {

                $client->password = Hash::make($request->password);
            }
            //$client->password   = 'no';
            //$client->email      = $request->email;
            //$client->mobile     = $request->mobile;
            $client->zipcode = $request->zip_code;
            $client->address = $request->address;
            $client->country_id = $request->country;
            $client->state_id = $request->state;
            $client->city_id = $request->city_id;
            $client->user_source = $request->user_source;

            $client->save();

            // Remove old user roles
            $client->roles()->detach();
            // Add role to user admin_role

            if ($client->save()) {
                $client->roles()->sync($request->role);
            }


            return redirect()->route('client_user.index')->with('success', "تم تحديث عضو الفريق بنجاح.");
        }
        return back()->with('errors', $validator->errors());
    }


    public function destroy($id)
    {

        $CourtCase = CourtCase::where('updated_by', $id)->count();
        $CaseLog = CaseLog::where('updated_by', $id)->count();
        $task = TaskMember::where('employee_id', $id)->count();
        $caseMenber = CaseMember::where('employee_id', $id)->count();

        if ($CourtCase > 0 || $CaseLog > 0 || $task > 0 || $caseMenber > 0) {
            //Session::flash('error',"You can't delete this team member because its used in other modules.");
            return response()->json([
                'error' => true,
                'message' => 'You cant delete this team member because its used in other modules',
            ], 400);
        } else {
            $client = Admin::find($id);
            $clientName = $client->first_name . ' ' . $client->last_name;

            if ($client->profile_img != '') {

                $imageUnlink = public_path() . config('constants.CLIENT_FOLDER_PATH') . '/' . $client->profile_img;
                if (file_exists($imageUnlink)) {
                    unlink($imageUnlink);
                }
            }
            $client->delete();

        }
        return response()->json([
            'success' => true,
            'message' => 'تم حذف عضو الفريق بنجاح.',
        ], 200);

    }

    public function changeStatus(Request $request)
    {

        $statuscode = 400;
        $client = Admin::findOrFail($request->id);
        $client->is_active = $request->status == 'true' ? 'Yes' : 'No';

        if ($client->save()) {
            $statuscode = 200;
        }
        $status = $request->status == 'true' ? 'تفعلت' : 'تعطلت';
        $message = 'الحالة ' . $status . ' بنجاح.';

        return response()->json([
            'success' => true,
            'message' => $message
        ], $statuscode);

    }
}
