<?php

namespace App\Http\Controllers\Admin;

use App\Model\ContractCategory;
use App\Model\ContractTerms;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\DatatablTrait;
use DB;
use Session;

class ContractTermsController extends Controller
{
    use DatatablTrait;

    public function index()
    {

        $user = \Auth::guard('admin')->user();
        if (!$user->can('client_list')) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.contract.terms.index');
    }

    public function create()
    {
        $user = \Auth::guard('admin')->user();
        if (!$user->can('client_add')) {
            abort(403, 'Unauthorized action.');
        }
        $data['contract_categories'] = ContractCategory::query()->pluck('name' , 'id');

        return view('admin.contract.terms.create' , $data);
    }

    public function ContractTermList(Request $request)
    {
        $user = \Auth::guard('admin')->user();
        $isEdit = $user->can('client_edit');
        $isDelete = $user->can('client_delete');

        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'category',
            3 => 'action',
        );

        $totalData = ContractTerms::count(); // datata table count

        $totalRec = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');


        $customcollections = ContractTerms::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%{$search}%");
        });

        $totalFiltered = $customcollections->count();
        $customcollections = $customcollections->offset($start)->limit($limit)->orderBy($order, $dir)->get();
        $data = [];
        foreach ($customcollections as $key => $item) {

            $show = route('contracts_terms.show', $item->id);
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
            $row['category'] = isset($item->category)? @$item->category->name : ' - ';

            $row['action'] = $this->action([
                'edit' => route('contracts_terms.edit', $item->id),
                'edit_permission' => $isEdit,
                'delete' => collect([
                    'id' => $item->id,
                    'action' => route('contracts_terms.destroy', $item->id),
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
        $AdvocateClient = new ContractTerms();
        $AdvocateClient->name = $request->name;
        $AdvocateClient->category_id = $request->category_id;
        $AdvocateClient->save();

        return redirect()->route('contracts_terms.index')->with('success', "تم إضافة البيانات بنجاح.");


    }

    public function show($id)
    {
        //
        $data['single'] = array();
        $data['item'] = ContractTerms::find($id);
        $data['contract_categories'] = ContractCategory::query()->pluck('name' , 'id');

        return view('admin.contract.terms.create', $data);
    }

    public function edit($id)
    {
        $user = \Auth::guard('admin')->user();
        if (!$user->can('client_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $data['contract_categories'] = ContractCategory::query()->pluck('name' , 'id');

        $data['item'] = ContractTerms::find($id);

        return view('admin.contract.terms.create', $data);
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
        $AdvocateClient = ContractTerms::find($id);
        $AdvocateClient->name = $request->name;
        $AdvocateClient->category_id = $request->category_id;
        $AdvocateClient->save();

        return redirect()->route('contracts_terms.index')->with('success', "تم تعديل البيانات بنجاح .");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $AdvocateClient = ContractTerms::find($id);
        $AdvocateClient->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف التصنيف بنجاح.'
        ], 200);
    }




}
