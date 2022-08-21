<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\CourtType;
use App\Model\CourtCase;
use App\Model\Court;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Traits\DatatablTrait;
use Illuminate\Support\Facades\DB;

class CourtController extends Controller
{
    use DatatablTrait;

    public function index()
    {
        $user = Auth::guard('admin')->user();
        if (!$user->can('court_list')) {
            abort(403, 'عمل غير مصرح به.');
        }

        return view('admin.settings.court.court');
    }


    public function create()
    {
        $date['court_types'] = CourtType::orderBy('created_at', 'desc')->get();


        return response()->json([
            'html' => view('admin.settings.court.court_create', $date)->render()
        ]);
    }

    public function cashList(Request $request)
    {


        $user = Auth::guard('admin')->user();
        $isEdit = $user->can('court_edit');
        $isDelete = $user->can('court_delete');


        // Listing column to show
        $columns = array(
            0 => 'id',
            1 => 'court_type_id',
            2 => 'court_name',
            3 => 'is_active',
        );


        $totalData = DB::table('courts AS c')
            ->leftJoin('court_types AS ct', 'c.court_type_id', '=', 'ct.id')
            ->select('c.id', 'c.court_name', 'c.advocate_id', 'c.is_active', 'ct.court_type_name')
            ->count();

        $totalRec = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');


        $customcollections = DB::table('courts AS c')
            ->leftJoin('court_types AS ct', 'c.court_type_id', '=', 'ct.id')
            ->select('c.id', 'c.court_name', 'c.advocate_id', 'c.is_active', 'ct.court_type_name')
            ->when($search, function ($query, $search) {
                return $query->where('c.court_name', 'LIKE', "%{$search}%");
            });


        // dd($totalData);

        $totalFiltered = $customcollections->count();

        $customcollections = $customcollections->offset($start)->limit($limit)->orderBy($order, $dir)->get();

        $data = [];

        foreach ($customcollections as $key => $item) {

            // $row['id'] = $item->id;
            if (empty($request->input('search.value'))) {
                $final = $totalRec - $start;
                $row['id'] = $final;
                $totalRec--;
            } else {
                $start++;
                $row['id'] = $start;
            }
            $row['court_name'] = $item->court_name;
            $row['court_type'] = $item->court_type_name;


            if ($isEdit == "1") {
                $row['is_active'] = $this->status($item->is_active, $item->id, route('court.status'));
            } else {
                $row['is_active'] = [];
            }

            if ($isEdit == "1" || $isDelete == "1") {
                $row['action'] = $this->action([
                    'edit_modal' => collect([
                        'id' => $item->id,
                        'action' => route('court.edit', $item->id),
                        'target' => '#addtag'
                    ]),
                    'edit_permission' => $isEdit,
                    'delete' => collect([
                        'id' => $item->id,
                        'action' => route('court.destroy', $item->id),
                    ]),
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


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'court_type' => 'required',
            'court_name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $casetype = new Court();
        $casetype->advocate_id = "1";
        $casetype->court_type_id = $request->court_type;
        $casetype->court_name = $request->court_name;
        $casetype->save();

        return response()->json([
            'success' => true,
            'message' => 'تمت إضافة المحكمة بنجاح',

        ], 200);


    }


    public function edit($id)
    {
        $data['court_types'] = CourtType::orderBy('created_at', 'desc')->get();
        $data['court'] = Court::findorfail($id);

        return response()->json([
            'html' => view('admin.settings.court.court_edit', $data)->render()
        ]);
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'court_type' => 'required',
            'court_name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $casetype = Court::findorfail($id);
        $casetype->advocate_id = "1";
        $casetype->court_type_id = $request->court_type;
        $casetype->court_name = $request->court_name;
        $casetype->save();

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث المحكمة بنجاح',

        ], 200);

    }


    public function changeStatus(Request $request)
    {
        // dd($request->all());

        $statuscode = 400;
        $data = Court::findOrFail($request->id);
        $data->is_active = $request->status == 'true' ? 'Yes' : 'No';

        if ($data->save()) {
            $statuscode = 200;
        }
        $status = $request->status == 'Yes' ? 'Yes' : 'No';
        $message = 'تم تغيير حالة المحكمة بنجاح.';

        return response()->json([
            'success' => true,
            'message' => $message
        ], $statuscode);

    }

    public function destroy($id)
    {
        $count = 0;
        $count += CourtCase::where('court', $id)->count();

        if ($count == 0) {
            $row = Court::destroy($id);

            return response()->json([
                'success' => true,
                'message' => 'تم حذف المحكمة بنجاح.'
            ], 200);

        } else {

            return response()->json([
                'error' => true,
                'errormessage' => 'لا يمكنك حذف المحكمة لأنها تستخدم في وحدة أخرى.'
            ], 400);
        }
    }
}
