<?php

namespace App\Http\Controllers\Admin;
use DB;

use App\Http\Requests\PageRequest;
use Illuminate\Http\Request;
use App\Helpers\Multitenant;
use App\Traits\CreatesViewPaths;
use App\Http\Controllers\Admin\Controller;
use Illuminate\Support\Facades\Input;
use App\Events\RoutesUpdated;
use App\Helpers\Helper;
use File;

class InvoiceController extends Controller
{
    use CreatesViewPaths;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('pages.admin.dashboard');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        return view('pages.admin.dashboard');
    }

    public function show(){

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        // Store method goes here

        return response()->json([
            "message" => "Invoice has created successfully!",
            "status"  => "success",
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        return view('pages.admin.dashboard');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        // Update method goes here
        $item       = Multitenant::getModel('Invoice')::where('id', $id)->first();
        $item->id   = $request->id;

        $item->save();

        return response()->json([
            "message" => "Invoice has successfully redirected!",
            "status" => "success",
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Multitenant::getModel('Invoice')::where('id', $id)->delete();

        return response()->json([
            "message" => "Invoice has been successfully deleted!",
            "status" => "success",
        ], 200);
    }

    /*
     * Invoices browser method
     */
    public function browseInvoices(Request $request) {
        if ($request->expectsJson()) {
            $params = $request->params;
            $params['page'] = intval($params['page']);
            $id = !is_null($request->id) ? $request->id : null; 
            /*
             *  I have created a helper to receive API data 
             *  @params will contain 'page_id' to define on which page we are
             *  'start_date' and 'end_date' to get data for certain period.
             *  ID - to view one specific invoice.
             */
            $invoices = Helper::apiData($id, $params);

            return response()->json(json_decode($invoices));
        }
    }

    public function createAjax(Request $request) {
        if ($request->expectsJson()) {
            return response()->json([
                "statuses"  => $this->getStatuses(),
                "types"     => config('pages.types'),
                "templates" => config('pages.templates'),
            ], 200);
        }
    }

    public function edit_ajax(Request $request, $id) {
        if ($request->expectsJson()) {
            $page = Multitenant::getModel('Page')::where(['page_id'=> $id,'lang_id'=>\App('language')->current->id])->first();

            if (is_null($page)) {
                $page = Multitenant::getModel('Page')::where(['id'=> $id])->first();
            }

            if (!is_null($page)) {
                $page->load('coverPhoto');
                $page->load('ogPhoto');
                $page->load('mainImage');
            }

            $data = [
                'pages'     => $page,
                "statuses"  => $this->getStatuses(),
                "types"     => config('pages.types'),
                "templates" => config('pages.templates'),
                'language'  => \App('language'),
                'message'   => 'გვერდი წრმატებულად რედაქტირდა!',
            ];
            return response()->json($data);
        }
    }

    /**
     * Type use as for identifing this type of page in database
     *
     * @return String
     */
    protected function pageType()
    {
        return config('pages.page_type.page.id');
    }

    protected function getStatuses()
    {
        return config('pages.status');
    }
}