<?php

namespace App\Http\Controllers;

use App\Models\CommunityCard;
use Illuminate\Http\Request;

class CommunityCardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
 public function index()
    {
        $communityCards = CommunityCard::all();
        return response()->json($communityCards);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CommunityCard  $communityCard
     * @return \Illuminate\Http\Response
     */
    public function show(CommunityCard $communityCard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CommunityCard  $communityCard
     * @return \Illuminate\Http\Response
     */
    public function edit(CommunityCard $communityCard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CommunityCard  $communityCard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CommunityCard $communityCard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CommunityCard  $communityCard
     * @return \Illuminate\Http\Response
     */
    public function destroy(CommunityCard $communityCard)
    {
        //
    }
}
