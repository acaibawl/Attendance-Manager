<?php

namespace App\Http\Controllers\Api\Attendances;

use App\Http\Controllers\Controller;
use App\Http\Requests\Attendance\Schedule\StoreRequest;
use App\Http\Resources\Attendance\ScheduleResource;
use App\Models\Attendance\Schedule;
use App\Models\User;
use App\UseCases\Attendance\Schedule\Exceptions\StoreScheduleException;
use App\UseCases\Attendance\Schedule\StoreAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request, StoreAction $action)
    {
        $user = Auth::user();
        $date = $request->makeDate();
        try {
            return new JsonResponse(ScheduleResource::collection($action($user, $date)), 201);
        } catch (StoreScheduleException $e) {
            // 捕まえた例外はスタックトレースに積む
            throw new HttpException(422, $e->getMessage(), $e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attendance\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Schedule $schedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        //
    }
}
