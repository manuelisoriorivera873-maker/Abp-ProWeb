<?php

namespace App\Http\Controllers;

use App\Models\template;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("layouts.template");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(template $template)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(template $template)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, template $template)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(template $template)
    {
        //
    }
}
