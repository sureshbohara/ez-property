<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\TeamRequest;
use App\Services\Admin\TeamService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Team;

class TeamController extends BaseController
{
    public function __construct(protected TeamService $service) {
        $this->middleware('auth:admin');
        $this->middleware('can:team.read')->only('index');
        $this->middleware('can:team.create')->only(['create', 'store']);
        $this->middleware('can:team.update')->only(['edit', 'update', 'teamStatus', 'updateOrderLevel']);
        $this->middleware('can:team.delete')->only('destroy');
    }

    public function index(Request $request)
    {
        $filters = $request->only('status', 'name');
        return view('admin.team.index', [
            'teams' => $this->service->getTeams($filters),
            'filters' => $filters,
        ]);
    }

    public function create(){
        return view('admin.team.form');
    }

    public function store(TeamRequest $request): JsonResponse
    {
        $team = $this->service->storeTeam($request->validated());
        return $this->successJson('Team member created!', $team, 201);
    }

    public function edit(Team $team)
    {
        return view('admin.team.form', ['team' => $team]);
    }

    public function update(TeamRequest $request, Team $team): JsonResponse
    {
        $updated = $this->service->updateTeam($team->id, $request->validated());
        return $this->successJson('Team member updated!', $updated);
    }

    public function destroy(Team $team)
    {
        $this->service->deleteTeam($team->id);
        return redirect()->back()->with('success', 'Team member deleted permanently!');
    }

    public function teamStatus(Request $request): JsonResponse
    {
        $request->validate(['status_id' => 'required|exists:teams,id']);
        $newStatus = $this->service->toggleStatus($request->status_id);
        return $this->successJson('Status updated', ['new_status' => $newStatus]);
    }

    public function updateOrderLevel(Request $request): JsonResponse
    {
        $request->validate([
            'id'          => 'required|exists:teams,id',
            'order_level' => 'required|integer|min:0',
        ]);
        $this->service->updateOrderLevel($request->id, $request->order_level);
        return $this->successJson('Order updated!');
    }
}