<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkRequest;
use App\Http\Requests\UpdateWorkRequest;
use App\Models\Type;
use App\Models\Work;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WorkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $trashed = $request->input('trashed');

        if ($trashed) {
            $works = Work::onlyTrashed()->get();
        } else {
            $works = Work::all();
        }

        $num_of_trashed = Work::onlyTrashed()->count();

        return view('works.index', compact('works','num_of_trashed'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::orderBy('name', 'asc')->get();
        $technologies = Technology::orderBy('name', 'asc')->get();


        return view('works.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreWorkRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWorkRequest $request)
    {
        $data = $request->validated();

        $data['slug'] = Str::slug($data['name']);

        $work = Work::create($data);

        if (isset($data['technology'])) {
            $work->technology()->attach($data['technologies']);
        }


        return to_route('works.show', $work);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Work  $work
     * @return \Illuminate\Http\Response
     */
    public function show(Work $work)
    {
        return view('works.show', compact('work'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Work  $work
     * @return \Illuminate\Http\Response
     */
    public function edit(Work $work)
    {
        $types = Type::orderBy('name', 'asc')->get();
        $technologies = Technology::orderBy('name', 'asc')->get();

        return view('works.edit', compact('work', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateWorkRequest  $request
     * @param  \App\Models\Work  $work
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWorkRequest $request, Work $work)
    {
        $data = $request->validated();

        if ($data['name'] !== $work->name) {
            $data['slug'] = Str::slug($data['name']);
        }

        $work->update($data);

        if (isset($data['technologies'])) {
            $work->technologies()->sync($data['technologies']);
        } else {
            $work->technologies()->sync([]);
        }

        return to_route('works.show', $work);
    }

    public function restore(Request $request, Work $work)
    {

        if ($work->trashed()) {
            $work->restore();

            $request->session()->flash('message', 'the work was restored.');
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Work  $work
     * @return \Illuminate\Http\Response
     */
    public function destroy(Work $work)
    {
        if ($work->trashed()) {
            $work->forceDelete();
        } else {
            $work->delete();
        }

        return to_route('works.index');
    }
}
