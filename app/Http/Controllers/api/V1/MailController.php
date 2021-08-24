<?php

namespace App\Http\Controllers\api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\MailResource;
use App\Models\Mails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return MailResource::collection(Mails::all());





    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {




        $request->validate([
            'mail' => 'required',
            'heading_id' => 'required',
        ]);

        $created_mail= new Mails;
        $created_mail->mail = $request->mail;
        $created_mail->heading_id = $request->heading_id;
        $created_mail->save();
        return new MailResource($created_mail);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new  MailResource(Mails::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $mail=Mails::find($id);
        $mail->update($request->all());
        return $mail;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($mail)
    {


        return Mails::where('mail', $mail)->delete();


    }

    public function destroy_headings($mail,$heading_id)
    {

        return Mails::where(['mail' =>$mail,'heading_id'=>$heading_id ])->delete();

    }

    public function show_headings($mail)
    {

        $show_headings = Mails::where('mail', $mail)->get();
        return MailResource::collection($show_headings);


    }


    public function show_mails($heading_id,$offset,$limit)
    {


        $show_mails=Mails::where('heading_id', $heading_id )->offset($offset)->limit($limit)->get('mail');
        return $show_mails;
    }

}
