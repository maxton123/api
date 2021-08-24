<?php

namespace App\Http\Controllers\api\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\MailStoreRequest;
use App\Http\Resources\MailResource;
use App\Models\Mails;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Collection;
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
            'name' => 'required',

        ]);


        $created_mail= new Mails;
        $created_mail->mail = $request->mail;
        $created_mail->heading_id = $request->heading_id;
        $created_mail->name = $request->name;
        $created_mail->gen_key = uniqid() ;
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
    public function destroy($mail,$key)
    {

        $d=0;
        $delete_mail = Mails::where(['mail'=> $mail])->get();

        foreach ($delete_mail as $mail_key){

            if ($mail_key['gen_key']==$key){
                $d=1;
                $mail_key->delete();
                echo "<br>Подписка удалена";
                break;
                }

        }
        if ($d==0) echo "Ошибка удаления(неверный ключ или mail )";


    }

    public function destroy_headings($mail,$heading_id)
    {

       $delete_mail = Mails::table('mails')->where(['mail' =>$mail,'heading_id'=>$heading_id ])->delete();
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
