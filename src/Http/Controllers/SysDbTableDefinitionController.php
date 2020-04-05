<?php

/**
 * This file is auto-generated.
 */

namespace ZZGo\Http\Controllers;

use App\Http\Controllers\Controller;
use ZZGo\Generator\Controller as GeneratorController;
use ZZGo\Generator\Migration;
use ZZGo\Generator\Model;
use ZZGo\Models\SysDbRelatedTable;
use ZZGo\Models\SysDbTableDefinition;
use Illuminate\Http\Request;

/**
 * Class SysDbTableDefinitionController
 *
 * @package ZZGo\Http\Controllers
 */
class SysDbTableDefinitionController extends Controller
{
    /**
     * List all SysDbTableDefinitions
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(SysDbTableDefinition::all());
    }


    /**
     * Show single SysDbTableDefinition
     *
     * @param SysDbTableDefinition $sysDbTableDefinition
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(SysDbTableDefinition $sysDbTableDefinition)
    {
        return response()->json($sysDbTableDefinition);
    }


    /**
     * Create new SysDbTableDefinition
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        SysDbTableDefinition::create($request->all());

        return response()->json(null, 204);
    }


    /**
     * Delete SysDbTableDefinition
     *
     * @param SysDbTableDefinition $sysDbTableDefinition
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(SysDbTableDefinition $sysDbTableDefinition)
    {
        $sysDbTableDefinition->delete();

        return response()->json(null, 204);
    }

    /**
     * Add related table //TODO: This is a draft
     *
     * @param SysDbTableDefinition $sysDbTableDefinition
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function link(SysDbTableDefinition $sysDbTableDefinition, Request $request)
    {
        SysDbRelatedTable::create(
            [
                "name"                              => $request->input("name",
                                                                       $sysDbTableDefinition->name . "_" . rand(1000, 9999)),
                "type"                              => $request->input("type"),
                "sys_db_source_table_definition_id" => $sysDbTableDefinition->id,
                "sys_db_target_table_definition_id" => $request->input("target_id"),
                "on_delete"                         => $request->input("on_delete"),
            ]);

        return response()->json(null, 204);
    }


    /**
     * Generate all defined data definitions
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function materialize()
    {
        $data_definitions = SysDbTableDefinition::all();

        foreach ($data_definitions as $data_definition) {
            (new Migration($data_definition))->materialize();
            (new Model($data_definition))->materialize();
            (new GeneratorController($data_definition))->materialize();
        }

        //Execute migrations
//        Artisan::call('migrate');

        return response()->json(null, 204);
    }
}
