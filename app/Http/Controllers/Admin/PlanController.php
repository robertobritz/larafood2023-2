<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdatePlan;
use App\Models\Plan;
use Illuminate\Http\Request;


class PlanController extends Controller
{
    private $repository;

    public function __construct(Plan $plan)
    {
        $this->repository = $plan;

        $this->middleware(['can:plans']);
    }

    public function index()
    {
        $plans = $this->repository->latest()->paginate();

        return view('admin/pages/plans/index', [
            'plans' =>$plans,
        ]);
    }

    public function create()
    {
        return view('admin.pages.plans.create');
    }

    public function store(StoreUpdatePlan $request)
    {
        $this->repository->create($request->all());
    
        return redirect()->route('plans.index');
    }

    public function show($url)
    {
        $plan = $this->repository->where('url', $url)->first();

        if (!$plan)
            return redirect()->back();
        
        return view('admin.pages.plans.show', [
            'plan' => $plan
        ]);
    }

    public function destroy($url)
    {
        $plan = $this->repository
                        ->with('details')
                        ->where('url', $url)
                        ->first();

        if (!$plan)
            return redirect()->back();

        if ($plan->details->count() > 0) {
            return redirect()
                        ->back()
                        ->with('error', 'Existem detalhes vinculados a este plano, portanto não pode ser excluído');
        }
        
        $plan->delete();

        return redirect()->route('plans.index');
    }

    public function search(Request $request)
    {
        $filters = $request->except('_token'); //para quando for utilizado o filtro, não passar o código do token

        $plans = $this->repository->search($request->filter); //método search foi incluido na model Plan, onde ele seleciona os filtros
        
        return view('admin.pages.plans.index', [
            'plans' => $plans,
            'filters' => $filters // serve para mandar para a view o filtro, só existe no método search, para não perder a paginação
        ]);
    }

    public function edit($url)
    {
        $plan = $this->repository->where('url', $url)->first();

        if (!$plan)
            return redirect()->back();

        return view('admin.pages.plans.edit',[
            'plan' => $plan
        ]);
    }

    public function update(StoreUpdatePlan $request, $url){
        $plan = $this->repository->where('url', $url)->first();

        if (!$plan)
            return redirect()->back();

        $plan->update($request->all());

        return redirect()->route('plans.index');
    }
}
