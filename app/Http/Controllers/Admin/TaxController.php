<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\AllTax;
use App\Model\Invoice;
use App\Model\Expense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Traits\DatatablTrait;


class TaxController extends Controller
{
    use DatatablTrait;

    public function index()
    {
        $user = Auth::guard('admin')->user();
        if (!$user->can('tax_list')) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.settings.tax.tax');
    }


    public function create()
    {

        return response()->json([
            'html' => view('admin.settings.tax.tax_create')->render()
        ]);
    }

    public function taxList(Request $request)
    {

        $user = \Auth::guard('admin')->user();
        $isEdit = $user->can('tax_edit');
        $isDelete = $user->can('tax_delete');


        // Listing column to show
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'per',
        );


        $totalData = AllTax::count();
        $totalRec = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');


        $customcollections = AllTax::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%{$search}%")
                ->Orwhere('per', 'LIKE', "%{$search}%");
        });

        // dd($totalData);

        $totalFiltered = $customcollections->count();

        $customcollections = $customcollections->offset($start)->limit($limit)->orderBy($order, $dir)->get();

        $data = [];

        foreach ($customcollections as $key => $item) {


            if (empty($request->input('search.value'))) {
                $final = $totalRec - $start;
                $row['id'] = $final;
                $totalRec--;
            } else {
                $start++;
                $row['id'] = $start;
            }

            // $row['id'] = $item->id;

            $row['name'] = $item->name;
            if ($item->name == "GST") {
                $row['cgst'] = ($item->per / 2) . " %";
                $row['igst'] = ($item->per / 2) . " %";;
            } else {
                $row['cgst'] = "";
                $row['igst'] = "";

            }

            $row['per'] = $item->per . " %";


            if ($isEdit == "1") {
                $row['is_active'] = $this->status($item->is_active, $item->id, route('tax.status'));
            } else {
                $row['is_active'] = [];
            }

            if ($isEdit == "1" || $isDelete == "1") {
                $row['action'] = $this->action([
                    'edit_modal' => collect([
                        'id' => $item->id,
                        'action' => route('tax.edit', $item->id),
                        'target' => '#addtag'
                    ]),
                    'edit_permission' => $isEdit,
                    'delete' => collect([
                        'id' => $item->id,
                        'action' => route('tax.destroy', $item->id),
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
            'name' => 'required',
            'per' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }


        $tax = new AllTax();
        $tax->advocate_id = "1";
        $tax->name = $request->name;
        $tax->per = $request->per;
        $tax->note = $request->note;
        $tax->save();

        return response()->json([
            'success' => true,
            'message' => '???? ?????????? ?????????????? ??????????',

        ], 200);


    }


    public function edit($id)
    {
        $data['tax'] = AllTax::findorfail($id);
        return response()->json([
            'html' => view('admin.settings.tax.tax_edit', $data)->render()
        ]);
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'per' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $tax = AllTax::find($id);
        $tax->name = $request->name;
        $tax->per = $request->per;
        $tax->note = $request->note;
        $tax->save();


        return response()->json([
            'success' => true,
            'message' => '???? ?????????? ?????????????? ??????????',

        ], 200);


    }


    public function changeStatus(Request $request)
    {
        $statuscode = 400;
        $data = AllTax::findOrFail($request->id);
        $data->is_active = $request->status == 'true' ? 'Yes' : 'No';

        if ($data->save()) {
            $statuscode = 200;
        }
        $message = '???? ?????????? ???????? ???????????????? ??????????.';

        return response()->json([
            'success' => true,
            'message' => $message
        ], $statuscode);

    }

    public function destroy($id)
    {
        $count = 0;
        $count += Invoice::where('tax_id', $id)->count();
        $count += Expense::where('tax_id', $id)->count();

        if ($count == 0) {
            $row = AllTax::destroy($id);

            return response()->json([
                'success' => true,
                'message' => '???? ?????? ?????????????? ??????????.'
            ], 200);

        } else {

            return response()->json([
                'error' => true,
                'errormessage' => '???? ?????????? ?????? ?????????????? ?????????? ???????????? ???? ???????? ????????.'
            ], 400);
        }
    }
}
