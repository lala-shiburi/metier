<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;
use \App\HiringStepGroup;
use \App\HiringStep;
use \App\Company;
use \App\HiringStepResult;
use \App\HiringStepResultNote;

class HiringProcessController extends Controller
{
    public function validate_process_step(Request $request){
        $this->validate($request, [
            'name' => 'required'
        ]);

        return [ 'status' => 'validated' ];
    }

    public function createHiringProcess(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required'
        ]);

        // check if steps have at least one
        if(count($request->steps) < 1)
        return ['errors' => ['steps'=>'must have at least one step'], 'message' => 'The given data was invalid.'];

        $hiringStepGroup = $request->id ? HiringStepGroup::find($request->id) : new HiringStepGroup;
        $hiringStepGroup->name = $request->name;
        $hiringStepGroup->company_id = $request->company_id;
        $hiringStepGroup->description = $request->description;
        $hiringStepGroup->save();

        $step_ids = [];
        
        foreach($request->steps as $key => $_step){
            $_step = (object)$_step;
            $step = @$_step->id ? HiringStep::find($_step->id) : new HiringStep;
            $step->name = $_step->name;
            $step->hiring_step_group_id = $hiringStepGroup->id;
            $step->description = @$_step->description;
            $step->level = $key + 1;
            $step->save();

            array_push($step_ids,$step->id);
        }

        // delete missing steps
        if($request->id){
            $hiringStepGroup->hiring_steps()->whereNotIn('hiring_steps.id', $step_ids)->delete();
        }

        return ['status'=>'success', 'hiringStepGroup'=>$hiringStepGroup];
    }

    /**
     * 
     */
    public function fetchProcesses(Request $request){
        return ['hiringProcesses' => Company::find($request->company_id)->hiringProcessGroups];
    }

    /**
     * 
     */
    public function fetchProcess(Request $request){
        return ['hiringProcess'=> HiringStepGroup::find($request->id)->load('hiring_steps')];
    }

    /**
     * 
     */
    public function deleteProcess(Request $request){
        $hiringStepGroup = HiringStepGroup::find($request->id);
        $hiringStepGroup->delete();

        return ['status'=>'success'];
    }

    /**
     * 
     */
    public function validateHiringStepResult(Request $request){
        $this->validate($request,[
            'result' => 'required'
        ]);

        return ['status'=>'success'];
    }

    public function validateHiringStepResultNote(Request $request){
        $this->validate($request, [
            'title' => 'required',
            'note' => 'required',
        ]);

        return ['status'=>'success'];
    }

    public function createStepResult(Request $request){

        $this->validate($request, [
            'result' => 'required'
        ]);

        $hiringStepResult = new HiringStepResult;
        $hiringStepResult->result = $request->result;
        $hiringStepResult->hiring_step_id = $request->hiring_step_id;
        $hiringStepResult->hiring_application_id = $request->hiring_application_id;
        $hiringStepResult->save();

        foreach($request->notes as $note){
            $hiringStepResultNote = new HiringStepResultNote;
            $hiringStepResultNote->title = $note['title'];
            $hiringStepResultNote->note = $note['note'];
            $hiringStepResultNote->hiring_step_result_id = $hiringStepResult->id;
            $hiringStepResultNote->save();
        }

        return [ 'hiringStepResult' => $hiringStepResult->load('notes') ];
    }
}
