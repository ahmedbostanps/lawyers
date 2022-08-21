<?php

namespace App\Http\Controllers\Admin;

use App\Model\ContractCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\AdvocateClient;
use App\Model\CourtCase;
use App\Traits\DatatablTrait;
use Illuminate\Support\Facades\Auth;


class ContractCategoryController extends Controller
{
    use DatatablTrait;

    public function index()
    {

        $user = Auth::guard('admin')->user();
        if (!$user->can('client_list')) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.contract.category.index');
    }

    public function create()
    {
        $user = Auth::guard('admin')->user();
        if (!$user->can('client_add')) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.contract.category.create');
    }

    public function ContractCaegoryList(Request $request)
    {
        $user = Auth::guard('admin')->user();
        $isEdit = $user->can('client_edit');
        $isDelete = $user->can('client_delete');

        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'action',
        );

        $totalData = ContractCategory::count(); // datata table count

        $totalRec = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');


        $customcollections = ContractCategory::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%{$search}%");
        });

        $totalFiltered = $customcollections->count();
        $customcollections = $customcollections->offset($start)->limit($limit)->orderBy($order, $dir)->get();
        $data = [];
        foreach ($customcollections as $key => $item) {

            $show = route('contracts_categories.show', $item->id);
            $case_list = url('admin/case-list/' . $item->id);

            if (empty($request->input('search.value'))) {
                $final = $totalRec - $start;
                $row['id'] = $final;
                $totalRec--;
            } else {
                $start++;
                $row['id'] = $start;
            }

            $row['name'] = '<a class="title text-primary" href="' . $show . '">' . $item->name . '</a>';


            $row['action'] = $this->action([
                'edit' => route('contracts_categories.edit', $item->id),
                'edit_permission' => $isEdit,
                'delete' => collect([
                    'id' => $item->id,
                    'action' => route('contracts_categories.destroy', $item->id),
                ]),
                'delete_permission' => $isDelete,

            ]);

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
        $AdvocateClient = new ContractCategory();
        $AdvocateClient->name = $request->name;
        $AdvocateClient->save();

        return redirect()->route('contracts_categories.index')->with('success', "تم إضافة البيانات بنجاح.");
    }


    public function show($id)
    {
        //
        $data['single'] = array();
        $data['item'] = ContractCategory::find($id);
        return view('admin.contract.category.create', $data);
    }


    public function edit($id)
    {
        $user = Auth::guard('admin')->user();
        if (!$user->can('client_edit')) {
            abort(403, 'Unauthorized action.');
        }

        $data['item'] = ContractCategory::find($id);
        return view('admin.contract.category.create', $data);
    }

    public function update(Request $request, $id)
    {
        $AdvocateClient = ContractCategory::find($id);
        $AdvocateClient->name = $request->name;
        $AdvocateClient->save();

        return redirect()->route('contracts_categories.index')->with('success', "تم تعديل البيانات بنجاح .");
    }

    public function destroy($id)
    {

        $AdvocateClient = ContractCategory::find($id);
        $AdvocateClient->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف التصنيف بنجاح.'
        ], 200);
    }

    public function changeStatus(Request $request)
    {
        $statuscode = 400;
        $client = AdvocateClient::findOrFail($request->id);
        $client->is_active = $request->status == 'true' ? 'Yes' : 'No';

        if ($client->save()) {
            $statuscode = 200;
        }
        $status = $request->status == 'true' ? 'active' : 'deactivate';
        $message = 'Client status ' . $status . ' successfully.';

        return response()->json([
            'success' => true,
            'message' => $message
        ], $statuscode);

    }

    public function check_client_email_exits(Request $request)
    {
        if ($request->id == "") {
            $count = AdvocateClient::where('email', $request->email)->count();
            if ($count == 0) {
                return 'true';
            } else {
                return 'false';
            }
        } else {
            $count = AdvocateClient::where('email', '=', $request->email)
                ->where('id', '<>', $request->id)
                ->count();
            if ($count == 0) {
                return 'true';
            } else {
                return 'false';
            }
        }
    }

    public function caseDetail($id)
    {
        $user = Auth::guard('admin')->user();
        if (!$user->can('case_list')) {
            abort(403, 'Unauthorized action.');
        }
        $totalCourtCase = CourtCase::where('advo_client_id', $id)->count();
        $clientName = AdvocateClient::findorfail($id);
        $name = $clientName->first_name . ' ' . $clientName->middle_name . ' ' . $clientName->last_name;
        $client = AdvocateClient::find($id);


        return view('admin.client.view.cases_view', ['advo_client_id' => $id, 'name' => $name, 'totalCourtCase' => $totalCourtCase, 'client' => $client]);
    }


    public function accountDetail($id)
    {
        $user = Auth::guard('admin')->user();
        if (!$user->can('invoice_list')) {
            abort(403, 'Unauthorized action.');
        }
        $clientName = AdvocateClient::findorfail($id);
        $name = $clientName->first_name . ' ' . $clientName->middle_name . ' ' . $clientName->last_name;
        $client = AdvocateClient::find($id);
        return view('admin.client.view.client_account', ['advo_client_id' => $id, 'name' => $name, 'client' => $client]);
    }

}
