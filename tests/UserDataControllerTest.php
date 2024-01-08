<?php

namespace App\Http\Controllers;

use App\Models\UserData;
use Illuminate\Http\Request;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\TestCase;

class UserDataControllerTest extends TestCase
{















    public function comp(Request $request){
        if($request->input('修正する')=='修正する'){
            return redirect('/main_signup')
                        ->withInput();
        }
        
        $inputs = $request->all();
        UserData::signup($inputs);
        
        session() -> put('flg',1);
        return redirect('/main_complete');
    }



    public function childcomp(Request $request){
        if(session()->has('id')){
            $inputs = $request->all();
            $id = $request -> session() -> get('families_id');
            UserData::newchild($id,$inputs);
            
            return redirect('/other_menu');
        }else{
            return redirect('/');
        }
        
    }



    public function authentication(Request $request){
        $request->validate([
            'email' => ['required','email:filter'],
            'pass' => ['required','regex:/^[0-9A-Za-z]+$/','between:4,15'],
        ],[
            'required' => 'ご入力ください',
            'email' => ['正しいメールアドレスをご入力ください。'],
            'regex' => '正しいパスワードをご入力ください。',
            'between' => '4文字以上15文字未満でご入力ください。',]);

        $inputs = $request->all();
        $userData = UserData::login($inputs);
        session() -> forget('flg');

        if($userData == '1'){
            session() -> put('flg',1);
            $errorM = 'メールアドレスまたはパスワードが間違っています。';
            return view('/login', compact('errorM'));
        }else{
            if($userData -> role == 0){
                session() -> forget('flg');
                session() -> put(['id' => $userData -> id,
                                'role' => $userData -> role,
                                'families_id' => $userData -> families_id,
                                'wallets_id' => $userData -> wallets_id,]);
                return redirect('./main_toppage');
            }else{
                session() -> forget('flg');
                session() -> put(['id' => $userData -> id,
                                'role' => $userData -> role,
                                'families_id' => $userData -> families_id,
                                'wallets_id' => $userData -> wallets_id,]);
                return redirect('./child_toppage');
            }
        }
    }

    public function logout(Request $request){
        $request->session()->flush();
        return redirect('./');
    }


    public function toplist(){
        if(session()->has('id')){
            $userID = session() -> get('families_id');


            $CompIList = UserData::completeitemList($userID);
            $CompJList = UserData::completejobList($userID);
            $JobList = UserData::jobList($userID);
            $ItemList = UserData::itemList($userID);
            $walletName = UserData::WalletsName($userID);

            return view('mainaccount.main_toppage') -> with('JobList', $JobList)
                                                    -> with('ItemList', $ItemList)
                                                    -> with('CompJList', $CompJList)
                                                    -> with('CompIList', $CompIList)
                                                    -> with('walletName', $walletName);
        }else{
            return redirect('/');
        }
    }

    public function Compjobpay(Request $request){
        if(session()->has('id')){
            $id = $request->input('id');
            UserData::jobreward($id);

            return redirect('./main_toppage?id=JobC');
        }else{
            return redirect('/');
        }
    }

    public function CompjobdataDelete(Request $request){
        if(session()->has('id')){
            $id = $request->input('id');
            UserData::CompjobDelete($id);

            return redirect('./main_toppage?id=JobC');
        }else{
            return redirect('/');
        }
    }

    public function jobdataDelete(Request $request){
        if(session()->has('id')){
            $id = $request->input('id');
            UserData::jobDelete($id);

            return redirect('./main_toppage?id=Job');
        }else{
            return redirect('/');
        }
    }

    public function jobdate(Request $request){
        if(session()->has('id')){
            $id = $request->input('id');
            $job = UserData::jobdata($id);

            return view('mainaccount.new_job_edit') -> with('job', $job);
        }else{
            return redirect('/');
        }
        
    }

    public function jobupdate(Request $request){
        if(session()->has('id')){
            $request->validate([
                'name' => ['required','max:15'],
                'content' => ['required','max:100'],
                'reward' => ['required', 'integer'],
            ],[
                'required' => '入力必須です。',
                'integer' => '数字のみご入力ください。',
                'max' => [
                    'string' => ':max 文字以内でご入力ください。'],
            ]);

            $inputs = $request->all();
            UserData::jobupdata($inputs);
            return redirect('./main_toppage?id=Job');
        }else{
            return redirect('/');
        }
        
    }


    public function Compitempay(Request $request){
        if(session()->has('id')){
            $id = $request->input('id');
            UserData::itempay($id);

            return redirect('./main_toppage?id=ItemC');
        }else{
            return redirect('/');
        }
    }

    public function CompItemdataDelete(Request $request){
        if(session()->has('id')){
            $id = $request->input('id');
            UserData::CompItemDelete($id);

            return redirect('./main_toppage?id=ItemC');
        }else{
            return redirect('/');
        }
    }

    public function itemdataDelete(Request $request){
        if(session()->has('id')){
            $id = $request->input('id');
            UserData::itemDelete($id);

            return redirect('./main_toppage?id=Item');
        }else{
            return redirect('/');
        }
    }

    public function itemdate(Request $request){
        if(session()->has('id')){
            $id = $request->input('id');
            $item = UserData::itemdata($id);

            return view('mainaccount.new_item_edit') -> with('item', $item);
        }else{
            return redirect('/');
        }
        
    }

    public function itemupdate(Request $request){
        if(session()->has('id')){
            $request->validate([
                'name' => ['required','max:15'],
                'content' => ['required','max:100'],
                'price' => ['required', 'integer'],
            ],[
                'required' => '入力必須です。',
                'integer' => '数字のみご入力ください。',
                'max' => [
                    'string' => ':max 文字以内でご入力ください。'],
            ]);

            $inputs = $request->all();
            UserData::itemupdata($inputs);
            return redirect('./main_toppage?id=Item');
        }else{
            return redirect('/');
        }
        
    }



    public function jobconf(Request $request){
        if(session()->has('id')){
            $request->validate([
                'name' => ['required','max:15'],
                'content' => ['required','max:100'],
                'reward' => ['required', 'integer'],
            ],[
                'required' => '入力必須です。',
                'integer' => '数字のみご入力ください。',
                'max' => [
                    'string' => ':max 文字以内でご入力ください。'],
            ]);

            $inputs = $request->all();

            return view('mainaccount.new_job_conf',['inputs' => $inputs ]);
        }else{
            return redirect('/');
        }
    }

    public function jobcomp(Request $request){
        if(session()->has('id')){
            if($request->input('修正する')=='修正する'){
                return redirect('/new_job')
                            ->withInput();
            }
            $userID = session() -> get('families_id');
            $inputs = $request->all();
            UserData::newjob($userID,$inputs);
            
            session() -> put('flg',1);
            return redirect('/new_job_complete');
        }else{
            return redirect('/');
        }
    }
        

    public function itemconf(Request $request){
        if(session()->has('id')){
            $request->validate([
                'name' => ['required','max:15'],
                'content' => ['required','max:100'],
                'price' => ['required', 'integer'],
            ],[
                'required' => '入力必須です。',
                'integer' => '数字のみご入力ください。',
                'max' => [
                    'string' => ':max 文字以内でご入力ください。'],
            ]);

            $inputs = $request->all();

            return view('mainaccount.new_item_conf',['inputs' => $inputs ]);
        }else{
            return redirect('/');
        }
    }

    public function itemcomp(Request $request){
        if(session()->has('id')){
            if($request->input('修正する')=='修正する'){
                return redirect('/new_item')
                            ->withInput();
            }
            $userID = session() -> get('families_id');
            $inputs = $request->all();
            UserData::newitem($userID,$inputs);
            
            session() -> put('flg',1);
            return redirect('/new_item_complete');
        }else{
            return redirect('/');
        }
    }



    public function otherlist(){
        if(session()->has('id')){
            $walletsID = session() -> get('wallets_id');
            $familiesID = session() -> get('families_id');

            $walletsList = UserData::walletsList($walletsID);
            $childList = UserData::childList($familiesID);
            
            return view('mainaccount.other_menu') -> with('walletsList', $walletsList) -> with('childList', $childList);
        }else{
            return redirect('/');
        }
    }



    public function childataDelete(Request $request){
        if(session()->has('id')){
            $id = $request->input('id');
            UserData::childDelete($id);

            return redirect('./other_menu');
        }else{
            return redirect('/');
        }
    }

    public function childPass(Request $request){
        if(session()->has('id')){
            $input = $request->all();

            return view('mainaccount.child_pass_edit')-> with('input', $input);
        }else{
            return redirect('/');
        }
    }

    public function childPassComp(Request $request){
        if(session()->has('id')){
            $request->validate([
                'pass' => ['required','regex:/^[0-9A-Za-z]+$/','between:4,15'],
            ],[
                'required' => 'ご入力ください',
                'regex' => '正しいパスワードをご入力ください。',
                'between' => '4文字以上15文字未満でご入力ください。',]);

            $inputs = $request->all();
            UserData::childpassupdate($inputs);

            return redirect('./other_menu');
        }else{
            return redirect('/');
        }
    }



    public function moneyconf(Request $request){
        if(session()->has('id')){
            $request->validate([
                'money_name' => ['required','max:30'],
                'rate' => ['required','numeric','between:0,1000000000'],
            ],[
                'required' => '入力必須です。',
                'numeric' => '数字のみご入力ください。',
                'max' => ['string' => ':max 文字以内でご入力ください。'],
                'between' => ['numeric' => ':min～:maxの範囲内でご入力ください。'],
            ]);

            $inputs = $request->all();

            return view('mainaccount.money_conf',['inputs' => $inputs ]);
        }else{
            return redirect('/');
        }
    }

    public function moneycomp(Request $request){
        if(session()->has('id')){
            $inputs = $request->all();

            UserData::walletupdate($inputs);

            return redirect('/other_menu');
        }else{
            return redirect('/');
        }
    }
    
    

    public function unsubscribConf(Request $request){
        if(session()->has('id')){
            $request->validate([
                'email' => ['required','email:filter'],
                'pass' => ['required','regex:/^[0-9A-Za-z]+$/','between:4,15'],
            ],[
                'required' => 'ご入力ください',
                'email' => ['正しいメールアドレスをご入力ください。'],
                'regex' => '正しいパスワードをご入力ください。',
                'between' => '4文字以上15文字未満でご入力ください。',]);

            $inputs = $request->all();
            $userData = UserData::unsubscribCheck($inputs);

            if($userData){
                return view('mainaccount.unsubscrib_complete');
            }else{
                $errorM = 'メールアドレスまたはパスワードが間違っています。';
                return redirect('./unsubscrib')->with(compact('errorM'));
            }
        }else{
            return redirect('/');
        }
    }


    public function unsubscribComp(Request $request){
        if(session()->has('id')){
            
            $inputs = session() -> get('families_id');
            UserData::unsubscrib($inputs);
            $request->session()->flush();
            return redirect('./');
        }else{
            return redirect('/');
        }
    }
    





    public function childtoplist(Request $request){
        if(session()->has('id')){
            $userid = $request -> session() -> get('id');
            $familiesID = session() -> get('families_id');

            $walletName = UserData::WalletsName($familiesID);
            $walletsList = UserData::UserWallets($userid);
            $JobList = UserData::jobList($familiesID);
            $ItemList = UserData::itemList($familiesID);

            return view('childaccount.child_toppage') -> with('JobList', $JobList)
                                                    -> with('ItemList', $ItemList)
                                                    -> with('walletsList', $walletsList)
                                                    -> with('walletName', $walletName);
        }else{
            return redirect('/');
        }
    }


    public function JobComplete(Request $request){
        if(session()->has('id')){
            $user = session() -> all();
            $inputs = $request->all();
            UserData::completejob($inputs,$user);
            return redirect('./child_toppage');
        }else{
            return redirect('/');
        }
    }

    public function itemComplete(Request $request){
        if(session()->has('id')){
            $user = session() -> all();
            $inputs = $request->all();
            UserData::completeitem($inputs,$user);
            return redirect('./child_toppage');
        }else{
            return redirect('/');
        }
    }



    public function favoriteList(Request $request){
        if(session()->has('id')){
            $userid = $request -> session() -> get('id');
            $familiesID = session() -> get('families_id');

            $walletName = UserData::WalletsName($familiesID);
            $walletsList = UserData::UserWallets($userid);
            $FJobList = UserData::favoritejobList($userid);
            $FItemList = UserData::favoriteitemList($userid);

            return view('childaccount.favorite') -> with('FJobList', $FJobList)
                                                    -> with('FItemList', $FItemList)
                                                    -> with('walletsList', $walletsList)
                                                    -> with('walletName', $walletName);
        }else{
            return redirect('/');
        }
    }


    public function JFA(Request $request){
        if(session()->has('id')){
            $userData = session() -> all();
            $id = $request->input('id');
            UserData::Newfavoritejob($id, $userData);

            return redirect('./child_toppage');
        }else{
            return redirect('/');
        }
    }

    public function FJD(Request $request){
        if(session()->has('id')){
            $id = $request->input('id');
            UserData::favoritejobDelete($id);

            return redirect('./favorite');
        }else{
            return redirect('/');
        }
    }

    public function IFA(Request $request){
        if(session()->has('id')){
            $userData = session() -> all();
            $id = $request->input('id');
            UserData::Newfavoriteitem($id, $userData);

            return redirect('./child_toppage');
        }else{
            return redirect('/');
        }
    }

    public function FID(Request $request){
        if(session()->has('id')){
            $id = $request->input('id');
            UserData::favoriteitemDelete($id);

            return redirect('./favorite');
        }else{
            return redirect('/');
        }
    }
    

    public function Hislist(Request $request){
        if(session()->has('id')){
            $userid = $request -> session() -> get('id');
            $familiesID = session() -> get('families_id');

            $walletName = UserData::WalletsName($familiesID);
            $walletsList = UserData::UserWallets($userid);
            $HList = UserData::HistoryList($userid);

            return view('childaccount.history') -> with('HList', $HList)
                                                    -> with('walletsList', $walletsList)
                                                    -> with('walletName', $walletName);
        }else{
            return redirect('/');
        }
    }


    public function searchlist(Request $request){
        if(session()->has('id')){
                $userid = $request -> session() -> get('id');
                $familiesID = session() -> get('families_id');
                $keyword = $request -> input('keyword');
                $input = $request -> input('name');
            if($request -> input('name') == '仕事'){
                $walletName = UserData::WalletsName($familiesID);
                $walletsList = UserData::UserWallets($userid);
                $searchList = UserData::searchJob($familiesID,$keyword);
            }else{
                $walletName = UserData::WalletsName($familiesID);
                $walletsList = UserData::UserWallets($userid);
                $searchList = UserData::searchItem($familiesID,$keyword);
            }
            return view('childaccount.search_result',compact('input')) -> with('searchList', $searchList)
                -> with('walletsList', $walletsList)
                -> with('walletName', $walletName);
        }else{
            return redirect('/');
        }
    }

    public function getBalance(){
        $id = session() -> get('id');
        $Wdata = UserData::walletsList($id);
        $balance = $Wdata[0] -> balance;
        return response()->json(['balance' => $balance]);
    }


    public function passlost(Request $request){
        $request->validate([
            'email' => ['required','email:filter'],
            'primary_school' => ['required'],
        ],[
            'required' => 'ご入力ください',
            'email' => '正しいメールアドレスをご入力ください。',]);

        $inputs = $request->all();
        $conf = UserData::passlostconf($inputs);
        $email = $request -> get('email');

        if($conf){
            session() -> put(['email' => $email]);
            return redirect('./passreset');
        }else{
            $errorM = 'メールアドレスまたは卒業した小学校が間違っています。';
            return redirect('./passlost')->with(['errorM' => $errorM]) -> withInput();
        }
    }


    public function passcomp(Request $request){
        if(session()->has('email')){
            $request->validate([
                        'pass' => ['required','confirmed','regex:/^[0-9A-Za-z]+$/','between:4,15'],
                    ],[
                        'required' => '入力必須です。',
                        'confirmed' => 'パスワードが不一致です。',
                        'regex' => '半角英数字のみでご入力ください。',
                        'between' => '4文字以上15文字未満でご入力ください。',]);
                        

            $email = session() -> get('email');
            $pass = $request -> input('pass');
            UserData::passreset($email,$pass);
            

            return redirect('./passreset_complete');
        }else{
            return redirect('/');
        }
        
    }























    
    public function test(){
        $id = session() -> get('id');
        $Wdata = UserData::walletsList(2);
        $balance = $Wdata[0] -> balance;
        var_dump($balance);
        return response()->json(['balance' => $balance]);
    }
}
