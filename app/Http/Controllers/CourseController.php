<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CourseRequest;
use App\Http\Requests\SuscribeRequest;
use App\Course;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Course::withCount('students')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseRequest $request)
    {
        try {
            $course = Course::create($request->all());
            return response()->json($course, 201);
        } catch (\Throwable $e) {
            \Log::error($e->getMessage());
            return response()->json(null, 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = Course::with('students')->find($id);
        return response()->json($course);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CourseRequest $request, $id)
    {
        try {
            $course = Course::find($id);
            $course->name = $request->name;
            $course->schedule = $request->schedule;
            $course->start_date = $request->start_date;
            $course->end_date = $request->end_date;
            $course->save();

            return response()->json($course, 200);
        } catch (\Throwable $e) {
            \Log::error($e->getMessage());
            return false;
        }
    }

    /**
     * suscribe
     *
     * @param  int $request
     * @param  int $id
     * @return void
     */
    public function suscribe(SuscribeRequest $request, $id)
    {
        try{
            $course = Course::find($id);
            $course->students()->attach($request->student_id);

            return response()->json(null, 200);
        } catch(\Throwable $e) {
            \Log::error($e->getMessage());
            return response()->json(null, 400);
        }
    }

    /**
     * unsuscribe
     *
     * @param  int $request
     * @param  int $id
     * @return void
     */
    public function unsuscribe(SuscribeRequest $request, $id)
    {
        try {
            $course = Course::find($id);
            $course->students()->detach($request->student_id);

            return response()->json(null, 200);
        } catch (\Throwable $e) {
            \Log::error($e->getMessage());
            return response()->json(null, 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = Course::find($id);
        $course->delete();

        return response()->json(null, 204);
    }
}
