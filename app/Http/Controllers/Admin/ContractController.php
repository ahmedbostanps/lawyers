<?php

namespace App\Http\Controllers\Admin;

use App\Model\Contract;
use App\Model\ContractCategory;
use App\Model\ContractClientTerm;
use App\Model\ContractSide;
use App\Model\ContractTerms;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\AdvocateClient;
use App\Model\CourtCase;
use App\Traits\DatatablTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ContractController extends Controller
{
    use DatatablTrait;


    public function index()
    {
        $user = Auth::guard('admin')->user();
        if (!$user->can('client_list')) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.contract.index');
    }


    public function create()
    {
        $user = Auth::guard('admin')->user();
        if (!$user->can('client_add')) {
            abort(403, 'Unauthorized action.');
        }

        $data['contract_categories'] = ContractCategory::query()->pluck('name', 'id');
        $data['clients'] = AdvocateClient::query()->get();
        return view('admin.contract.create', $data);
    }

    public function ContractList(Request $request)
    {
        $user = Auth::guard('admin')->user();
        $isEdit = $user->can('client_edit');
        $isDelete = $user->can('client_delete');

        $columns = array(
            0 => 'id',
            1 => 'first_side',
            2 => 'second_side',
            3 => 'status',
            5 => 'action',
        );

        $totalData = Contract::count(); // datata table count

        $totalRec = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');


        $customcollections = Contract::when($search, function ($query, $search) {
            return $query->whereHas('client_sides_side_one', function ($q) use ($search) {
                $q->whereHas('client', function ($s) use ($search) {
                    $s->where('first_name', 'LIKE', "%{$search}%");
                    $s->orWhere('middle_name', 'LIKE', "%{$search}%");
                    $s->orWhere('last_name', 'LIKE', "%{$search}%");
                });
            });
        });


        $totalFiltered = $customcollections->count();
        $customcollections = $customcollections->offset($start)->limit($limit)->orderBy($order, $dir)->get();
        $data = [];
        foreach ($customcollections as $key => $item) {

            $show = route('contracts.show', $item->id);
            $case_list = url('admin/case-list/' . $item->id);

            if (empty($request->input('search.value'))) {
                $final = $totalRec - $start;
                $row['id'] = $final;
                $totalRec--;
            } else {
                $start++;
                $row['id'] = $start;
            }
            $first_side = $item->client_sides_side_one()->first();
            $second_side = $item->client_sides_side_two()->first();

            $full_first_side_name = $first_side->client->first_name . ' ' . $first_side->client->last_name;
            $full_second_side_name = $second_side->client->first_name . ' ' . $second_side->client->last_name;
            $row['first_side'] = $full_first_side_name;
            $row['second_side'] = $full_second_side_name;
            $row['status'] = $item->status;
            if ($isEdit == "1") {
                $row['is_active'] = $this->status($item->is_active, $item->id, route('contracts.status'));
            } else {
                $row['is_active'] = [];
            }
            $row['action'] = $this->action([
                'view' => route('contracts.show', $item->id),
                'edit' => route('contracts.edit', $item->id),
                'print' => route('contracts.print', $item->id),
                'edit_permission' => $isEdit,
                'delete' => collect([
                    'id' => $item->id,
                    'action' => route('contracts.destroy', $item->id),
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
        $validator = Validator::make(
            $request->all(), [
            'group-a.*.client_id' => 'required|distinct',
            'group-b.*.client_id' => 'required|distinct',
            'group-c.*.category_term_id' => 'required|distinct',
            'group-c.*.inner-list.*.term_id' => 'required|distinct',
        ], [
            'group-a.*.client_id.distinct' => 'التأكد من تكرار بيانات الطرف الأول',
            'group-b.*.client_id.distinct' => 'التأكد من تكرار بيانات الطرف الثاني',
            'group-c.*.category_term_id.distinct' => 'التأكد من تكرار بيانات التصنيف',
            'group-c.*.inner-list.*.term_id.distinct' => 'التأكد من تكرار بيانات البند',
        ], [
            'group-a.*.client_id' => 'الطرف الأول',
            'group-b.*.client_id' => 'الطرف الثاني',
            'group-c.*.category_term_id' => 'التصنيف',
            'group-c.*.inner-list.*.term_id' => 'البند',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ]);
        }


        $contract = Contract::create();

        if (isset($request['group-a']) && count($request['group-a']) > 0) {

            foreach ($request['group-a'] as $key => $value) {

                if (!empty($value['client_id']) && !empty($value['type'])) {
                    $ClientPartiesInvoive = new ContractSide();
                    $ClientPartiesInvoive->client_id = $value['client_id'];
                    $ClientPartiesInvoive->contract_id = $contract->id;
                    $ClientPartiesInvoive->type = 1;
                    $ClientPartiesInvoive->save();
                }
            }
        }
        if (isset($request['group-b']) && count($request['group-b']) > 0) {
            foreach ($request['group-b'] as $key => $value) {
                if (!empty($value['client_id']) && !empty($value['type'])) {
                    $ClientContractSide = new ContractSide();
                    $ClientContractSide->client_id = $value['client_id'];
                    $ClientContractSide->contract_id = $contract->id;
                    $ClientContractSide->type = 2;
                    $ClientContractSide->save();
                }
            }
        }
        if (isset($request['group-c']) && count($request['group-c']) > 0) {
            foreach ($request['group-c'] as $key => $value) {

                if (!empty($value['category_term_id'])) {
                    foreach ($value['inner-list'] as $keyInner => $value_inner) {
                        $ClientContractClientTerm = new ContractClientTerm();
                        $ClientContractClientTerm->term_category_id = $value['category_term_id'];
                        $ClientContractClientTerm->contract_id = $contract->id;
                        $ClientContractClientTerm->contract_term_id = $value_inner['term_id'];
                        $ClientContractClientTerm->save();
                    }

                }
            }
        }
        return response()->json([
            'status' => true,
            'message' => 'تمت العملية بنجاح',
        ]);


    }

    public function array_has_dupes($array)
    {
        return count($array) !== count(array_unique($array));
    }

    public function show($id)
    {
        $data['item'] = Contract::findOrFail($id);
        $data['contract_client_first_side'] = ContractSide::where('contract_id', $data['item']->id)->where('type', ContractSide::SIDEONE)->get();
        $data['contract_client_second_side'] = ContractSide::where('contract_id', $data['item']->id)->where('type', ContractSide::SIDETWO)->get();

        $data['contract_client_terms'] = ContractClientTerm::query()->where('contract_id', $data['item']->id)->groupBy('term_category_id')->get();

        return view('admin.contract.view.client_detail', $data);
    }

    public function print($id)
    {
        $data['item'] = Contract::findOrFail($id);
        $data['contract_client_first_side'] = ContractSide::where('contract_id', $data['item']->id)->where('type', ContractSide::SIDEONE)->get();
        $data['contract_client_second_side'] = ContractSide::where('contract_id', $data['item']->id)->where('type', ContractSide::SIDETWO)->get();
        $data['contract_client_terms'] = ContractClientTerm::query()->where('contract_id', $data['item']->id)->groupBy('term_category_id')->get();
        return view('pdf.contracts', $data);
    }

    public function edit($id)
    {
        $user = Auth::guard('admin')->user();
        if (!$user->can('client_edit')) {
            abort(403, 'Unauthorized action.');
        }

        $data['item'] = Contract::find($id);
        $data['contract_categories'] = ContractCategory::query()->pluck('name', 'id');
        $data['clients'] = AdvocateClient::query()->get();
        $data['contract_client_first_side'] = ContractSide::where('contract_id', $data['item']->id)->where('type', ContractSide::SIDEONE)->get();
        $data['contract_client_second_side'] = ContractSide::where('contract_id', $data['item']->id)->where('type', ContractSide::SIDETWO)->get();

        $data['contract_client_terms'] = ContractClientTerm::query()->where('contract_id', $data['item']->id)->groupBy('term_category_id')->get();
        return view('admin.contract.create', $data);
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(), [
            'group-a.*.client_id' => 'required|distinct',
            'group-b.*.client_id' => 'required|distinct',
            'group-c.*.category_term_id' => 'required|distinct',
            'group-c.*.inner-list.*.term_id' => 'required|distinct',

        ], [
            'group-a.*.client_id.distinct' => 'التأكد من تكرار بيانات الطرف الأول',
            'group-b.*.client_id.distinct' => 'التأكد من تكرار بيانات الطرف الثاني',
            'group-c.*.category_term_id.distinct' => 'التأكد من تكرار بيانات التصنيف',
            'group-c.*.inner-list.*.term_id.distinct' => 'التأكد من تكرار بيانات البند',
        ], [
            'group-a.*.client_id' => 'الطرف الأول',
            'group-b.*.client_id' => 'الطرف الثاني',
            'group-c.*.category_term_id' => 'التصنيف',
            'group-c.*.inner-list.*.term_id' => 'البند',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ]);

        }


        $contract = Contract::find($id);
        $contract->conract_sides()->delete();
        $contract->conract_terms()->delete();
        if (isset($request['group-a']) && count($request['group-a']) > 0) {

            foreach ($request['group-a'] as $key => $value) {
                $collectValue = collect($value);

                if (!empty($value['client_id']) && !empty($value['type'])) {
                    $ClientPartiesInvoive = new ContractSide();
                    $ClientPartiesInvoive->client_id = $value['client_id'];
                    $ClientPartiesInvoive->contract_id = $contract->id;
                    $ClientPartiesInvoive->type = 1;
                    $ClientPartiesInvoive->save();
                }
            }
        }
        if (isset($request['group-b']) && count($request['group-b']) > 0) {
            foreach ($request['group-b'] as $key => $value) {
                if (!empty($value['client_id']) && !empty($value['type'])) {
                    $ClientContractSide = new ContractSide();
                    $ClientContractSide->client_id = $value['client_id'];
                    $ClientContractSide->contract_id = $contract->id;
                    $ClientContractSide->type = 2;
                    $ClientContractSide->save();
                }
            }
        }
        if (isset($request['group-c']) && count($request['group-c']) > 0) {
            foreach ($request['group-c'] as $key => $value) {

                if (!empty($value['category_term_id'])) {
                    foreach ($value['inner-list'] as $keyInner => $value_inner) {
                        $ClientContractClientTerm = new ContractClientTerm();
                        $ClientContractClientTerm->term_category_id = $value['category_term_id'];
                        $ClientContractClientTerm->contract_id = $contract->id;
                        $ClientContractClientTerm->contract_term_id = $value_inner['term_id'];
                        $ClientContractClientTerm->save();
                    }

                }
            }
        }
        return response()->json([
            'status' => true,
            'message' => 'تمت العملية بنجاح',
        ]);
//        return redirect()->route('clients.index')->with('success', "Client added successfully.");

    }


    public function destroy($id)
    {
        $AdvocateClient = Contract::find($id);
        $AdvocateClient->delete();
        return response()->json([
            'success' => true,
            'message' => 'تم حذف العقد .'
        ], 200);
    }

    public function changeStatus(Request $request)
    {
        $statuscode = 400;
        $client = Contract::findOrFail($request->id);
        $client->is_active = $request->status == 'true' ? 'Yes' : 'No';

        if ($client->save()) {
            $statuscode = 200;
        }
        $status = $request->status == 'true' ? 'active' : 'deactivate';
        $message = $status === 'active' ? 'تم تفعيل العقد' : 'تم إلغاء تفعيل العقد';

        return response()->json([
            'success' => true,
            'message' => $message
        ], $statuscode);

    }

    public function getTermsByCategory($id = null, Request $request)
    {
        if (empty($id)) {
            return response()->json([
                'status' => true,
                'items' => []
            ]);
        }
        $items = ContractTerms::where('category_id', $id)->get();
        return response()->json([
            'status' => true,
            'items' => $items
        ]);
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
