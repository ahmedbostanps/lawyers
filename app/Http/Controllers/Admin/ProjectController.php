<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Model\AdvocateClient;
use App\Model\Contract;
use App\Model\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Traits\DatatablTrait;


class ProjectController extends Controller
{
    use DatatablTrait;

    public function index()
    {
        $user = Auth::guard('admin')->user();
        if ($user->user_type == "User") {
            abort(403, 'عمل غير مصرح به.');
        }
        return view('admin.projects.index');
    }

    public function datatable(Request $request)
    {
        $user = Auth::guard('admin')->user();

        $projects = Project::query()->filter()->paginate(10);
        $recordsTotal = Project::count();
        $totalFiltered = $projects->count();

        return array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($recordsTotal),
            "recordsFiltered" => intval($totalFiltered),
            "data" => ProjectResource::collection($projects),
        );


    }

    public function create()
    {
        $user = Auth::guard('admin')->user();
        if ($user->user_type == "User") {
            abort(403, 'عمل غير مصرح به.');
        }

        $data['client_list'] = AdvocateClient::query()->where('is_active', 'Yes')->orderBy('first_name', 'asc')->get();
        $data['contracts'] = Contract::query()->where('is_active', 1)->get();

        return view('admin.projects.create', $data);
    }


    public function store(ProjectRequest $request)
    {
        $data = $request->all();

        if ($data['client_id'] == 'others') {
            $data['advocate_client_id'] = null;
            $data['owner_name'] = $data['client_other_name'];
        } else {
            $data['advocate_client_id'] = $data['client_id'];
            $data['owner_name'] = null;
        }

        $data = Arr::only($data, Project::FILLABLE);
        $project = Project::query()->create($data);
        $project->contract()->sync($request->get('contracts', []));
        return redirect()->route('projects.index')->with('success', "تم إنشاء المشروع بنجاح.");
    }

    public function edit($id)
    {
        $user = Auth::guard('admin')->user();
        if ($user->user_type == "User") {
            abort(403, 'عمل غير مصرح به.');
        }

        $data['item'] = Project::query()->findOrFail($id);
        $data['client_list'] = AdvocateClient::query()->where('is_active', 'Yes')->orderBy('first_name', 'asc')->get();
        $data['contracts'] = Contract::query()->where('is_active', 1)->get();
        return view('admin.projects.create', $data);
    }


    public function update(ProjectRequest $request, $id)
    {

        $data = $request->all();

        if ($data['client_id'] == 'others') {
            $data['advocate_client_id'] = null;
            $data['owner_name'] = $data['client_other_name'];
        } else {
            $data['advocate_client_id'] = $data['client_id'];
            $data['owner_name'] = null;
        }

        $data = Arr::only($data, Project::FILLABLE);
        $project = Project::query()->updateOrCreate(['id' => $id], $data);
        $project->contract()->sync($request->get('contracts', []));
        return redirect()->route('projects.index')->with('success', "تم تعديل المشروع بنجاح.");
    }


    public function destroy($id)
    {

        $task = Project::query()->find($id);


        if (isset($task) && $task->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'تم حذف المشروع بنجاح.',
            ]);

        }
        return response()->json([
            'error' => true,
            'message' => __('messages.unexpected_error_occurred_please_try_again_later'),
        ], 400);

    }
}
