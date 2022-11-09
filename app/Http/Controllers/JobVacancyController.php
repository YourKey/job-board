<?php

namespace App\Http\Controllers;

use App\Http\Requests\Jobs\StoreJobRequest;
use App\Http\Requests\Jobs\UpdateJobRequest;
use App\Models\JobVacancy;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobVacancyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $jobs = JobVacancy::orderByDesc('created_at')->paginate(15);
        return view('jobs.index', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreJobRequest  $request
     * @return RedirectResponse
     */
    public function store(StoreJobRequest $request): RedirectResponse
    {
        $data = $request->safe()
            ->merge(['user_id' => Auth::user()->id])
            ->all();
        $job = JobVacancy::create($data);

        return redirect(route('jobs.show', $job));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JobVacancy  $jobVacancy
     * @return View
     */
    public function show(JobVacancy $job): View
    {
        return view('jobs.show', compact('job'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JobVacancy  $jobVacancy
     * @return View
     */
    public function edit(JobVacancy $job): View
    {
        return view('jobs.edit', compact('job'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateJobRequest  $request
     * @param  \App\Models\JobVacancy  $job
     * @return RedirectResponse
     */
    public function update(UpdateJobRequest $request, JobVacancy $job): RedirectResponse
    {
        $job->update($request->safe()->all());

        return redirect(route('jobs.show', $job));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobVacancy  $job
     * @return RedirectResponse
     */
    public function destroy(JobVacancy $job): RedirectResponse
    {
        $job->delete();

        return redirect(route('jobs.index'));
    }
}
