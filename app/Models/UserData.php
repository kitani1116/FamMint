<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


/*
ALTER TABLE `complete_items` auto_increment = 1;
ALTER TABLE `complete_jobs` auto_increment = 1;
ALTER TABLE `favorite_items` auto_increment = 1;
ALTER TABLE `favorite_jobs` auto_increment = 1;
ALTER TABLE `families` auto_increment = 1;
ALTER TABLE `items` auto_increment = 1;
ALTER TABLE `jobs` auto_increment = 1;
ALTER TABLE `users` auto_increment = 1;
ALTER TABLE `wallets` auto_increment = 1;
*/

class UserData extends Model
{
    use HasFactory;

    public function signup($inputs){
        $users = DB::table('users');
        $families = DB::table('families');
        $wallets = DB::table('wallets');


        $familiesId = $families -> insertGetId([
            'family_name' => $inputs['last_name'],
            'created_at' => now()
        ]);

        $walletsId = $wallets -> insertGetId([
            'families_id' => $familiesId,
            'created_at' => now()
        ]);

        $users -> insert([
            'families_id' => $familiesId,
            'wallets_id' => $walletsId,
            'last_name' => $inputs['last_name'],
            'first_name' => $inputs['first_name'],
            'email' => $inputs['email'],
            'pass' => password_hash($inputs['pass'],PASSWORD_DEFAULT),
            'primary_school' => $inputs['primary_school'],
            'created_at' => now()
        ]);
    }



    public function login($inputs){
        $users = DB::table('users');

        $existence = $users -> where('email', 'like', $inputs['email']) -> exists();

        if($existence){
            $userData = $users -> where('email', 'like', $inputs['email']) -> first();
            $userPass = $userData -> pass;
            if(password_verify($inputs['pass'], $userPass)){
                return $userData;
            }else{
                $userData = 1;
                return $userData;
            }
        }else{
            $userData = 1;
            return $userData;
        }
    }


    public function WalletsName($id){
        $users = DB::table('users');
        $userid = $users -> select('id') -> where('families_id', $id) -> where('role', 0) -> first();
        $wallets = DB::table('wallets');

        return $wallets -> select('money_name') -> where('id', $userid->id) -> first();
    }

    public function UserWallets($id){
        $wallets = DB::table('wallets');

        return $wallets -> where('id', $id) -> first();
    }



    public function completejobList($id){
        $compjob = DB::table('complete_jobs as cj');
        $existence = $compjob -> where('cj.families_id', $id)
                            -> where('cj.flg', 0) -> exists();

        if($existence){
            return $compjob -> select('cj.id', 'cj.created_at','j.name','j.reward','u.first_name')
                ->join('jobs as j', 'cj.jobs_id', '=', 'j.id')
                ->join('users as u', 'cj.users_id', '=', 'u.id')
                ->where('cj.families_id',$id)
                ->orderBy('cj.created_at', 'asc') -> get();
        }else{
            return false;
        }
    }


    public function jobList($userID){
        $jobs = DB::table('jobs');

        $existence = $jobs -> where('families_id', $userID) -> where('DeleteRole', 0) -> exists();
        
        if($existence){
            $jobData = $jobs -> where('families_id', $userID) -> where('DeleteRole', 0) -> get();
        return $jobData;
        }else{
            return false;
        }
    }


    public function jobreward($ID){
        $Compjob = DB::table('complete_jobs');
        $users = DB::table('users');
        $jobs = DB::table('jobs');
        $wallets = DB::table('wallets');

        $CompjobID = $Compjob -> where('id', $ID) -> first();
        $jobID = $jobs -> where('id', $CompjobID -> jobs_id) -> first();
        $userID = $users -> where('id', $CompjobID -> users_id) -> first();

        $wallets -> where('id', $userID ->wallets_id )
                -> increment('balance', $jobID -> reward);
        $Compjob -> where('id', $ID)
                -> update(['flg' => 1, 'updated_at' => now()]);
    }


    public function CompjobDelete($ID){
        $Compjob = DB::table('complete_jobs');

        return $Compjob -> where('id', $ID) -> delete();
    }

    public function jobDelete($ID){
        $jobs = DB::table('jobs');

        return $jobs -> where('id', $ID) -> update(['DeleteRole' => 1, 'deleted_at' => now()]);
    }




    public function completeitemList($id){
        $compitem = DB::table('complete_items as ci');
        $existence = $compitem -> where('ci.families_id', $id)
                            -> where('ci.flg', 0) -> exists();

        if($existence){
            return $compitem -> select('ci.id', 'ci.created_at','i.name','i.price','u.first_name')
                ->join('items as i', 'ci.items_id', '=', 'i.id')
                ->join('users as u', 'ci.users_id', '=', 'u.id')
                ->where('ci.families_id',$id) 
                ->orderBy('ci.created_at', 'asc') -> get();
        }else{
            return false;
        }
    }


    public function itemList($userID){
        $items = DB::table('items');

        $existence = $items -> where('families_id', $userID) -> where('DeleteRole', 0) -> exists();

        if($existence){
            $itemData = $items -> where('families_id', $userID) -> where('DeleteRole', 0) -> get();
        return $itemData;
        }else{
            return false;
        }
    }

    public function itempay($ID){
        $Compitem = DB::table('complete_items');

        $Compitem -> where('id', $ID)
                -> update(['flg' => 1, 'updated_at' => now()]);
    }

    
    public function CompItemDelete($ID){
        $Compitem = DB::table('complete_items');
        $Cdate = $Compitem -> where('id', $ID) -> first();

        $items = DB::table('items');
        $Idate = $items -> where('id', $Cdate -> items_id) -> first();

        $users = DB::table('users');
        $Udate = $users -> where('id', $Cdate -> users_id) -> first();
        
        $wallets = DB::table('wallets');
        $wallets -> where('id', $Udate -> wallets_id) -> increment('balance', $Idate -> price);

        $Compitem -> where('id', $ID) -> delete();
    }

    public function itemDelete($userID){
        $items = DB::table('items');

        return $items -> where('id', $userID) -> update(['DeleteRole' => 1, 'deleted_at' => now()]);
    }


    public function jobdata($id){
        $job = DB::table('jobs');
        return $job -> where('id', $id) -> get();
    }

    public function jobupdata($inputs){
        $job = DB::table('jobs');

        $job -> where('id',$inputs['id'])  
        ->update(['name' => $inputs['name'],
                'content' => $inputs['content'],
                'reward' => $inputs['reward'],
                'updated_at' => now()]);
    }

    public function newjob($id,$inputs){
        $jobs = DB::table('jobs');

        $jobs -> insert([
            'families_id' => $id,
            'name' => $inputs['name'],
            'content' => $inputs['content'],
            'reward' => $inputs['reward'],
            'created_at' => now()
        ]);
    }


    public function itemdata($id){
        $item = DB::table('items');
        return $item -> where('id', $id) -> get();
    }

    public function itemupdata($inputs){
        $item = DB::table('items');

        $item -> where('id',$inputs['id'])  
        ->update(['name' => $inputs['name'],
                'content' => $inputs['content'],
                'price' => $inputs['price'],
                'updated_at' => now()]);
    }




    public function newitem($id,$inputs){
        $items = DB::table('items');

        $items -> insert([
            'families_id' => $id,
            'name' => $inputs['name'],
            'content' => $inputs['content'],
            'price' => $inputs['price'],
            'created_at' => now()
        ]);
    }



    public function walletsList($ID){
        $wallets = DB::table('wallets');
        $walletsData = $wallets -> where('id', $ID) -> get();
        return $walletsData;
    }


    public function walletupdate($inputs){
        $wallets = DB::table('wallets');

        $wallets -> where('id',$inputs['id'])  
        ->update(['money_name' => $inputs['money_name'],
                'rate' => $inputs['rate'],
                'updated_at' => now()]);
    }

    public function childList($ID){
        $user = DB::table('users as u');

        $existence = $user -> where('u.families_id', $ID)
                            -> where('u.role', 1) -> exists();

        if($existence){
            $childData = $user -> join('wallets as w','u.id','=','w.id') -> where('u.families_id', $ID)
                                -> where('u.role', 1) -> get();
        return $childData;
        }else{
            return false;
        }
    }

    public function childDelete($userID){
        $user = DB::table('users');
        $UData = $user -> where('id', $userID) -> first();

        $wallets = DB::table('wallets');
        $wallets -> where('id', $UData -> wallets_id) -> delete();

        $complete_items = DB::table('complete_items');
        $complete_items -> where('users_id', $userID) -> delete();

        $complete_jobs = DB::table('complete_jobs');
        $complete_jobs -> where('users_id', $userID) -> delete();


        $favorite_items = DB::table('favorite_items');
        $favorite_items -> where('users_id', $userID) -> delete();

        $favorite_jobs = DB::table('favorite_jobs');
        $favorite_jobs -> where('users_id', $userID) -> delete();

        $user -> where('id', $userID) -> delete();
    }

    public function childpassupdate($inputs){
        $user = DB::table('users');

        return $user -> where('id',$inputs['id'])  
        ->update(['pass' => password_hash($inputs['pass'],PASSWORD_DEFAULT),]);
    }
    

    public function newchild($id,$inputs){
        $users = DB::table('users');
        $wallets = DB::table('wallets');

        $walletsId = $wallets -> insertGetId([
            'families_id' => $id,
            'created_at' => now()
        ]);

        $users -> insert([
            'families_id' => $id,
            'wallets_id' => $walletsId,
            'first_name' => $inputs['first_name'],
            'email' => $inputs['email'],
            'pass' => password_hash($inputs['pass'],PASSWORD_DEFAULT),
            'role' => 1,
            'created_at' => now()
        ]);
    }


    public function unsubscribCheck($inputs){
        $users = DB::table('users');

        $existence = $users -> where('id', $inputs['id'])
                            -> where('email', 'like', $inputs['email']) -> exists();
        if($existence){
            $userData = $users -> where('email', 'like', $inputs['email']) -> first();
            $userPass = $userData -> pass;
            if(password_verify($inputs['pass'], $userPass)){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }


    public function unsubscrib($familiesId){
        $users = DB::table('users');
        $users -> where('families_id', $familiesId) -> delete();

        $jobs = DB::table('jobs');
        $jobs -> where('families_id', $familiesId) -> delete();

        $items = DB::table('items');
        $items -> where('families_id', $familiesId) -> delete();

        $families = DB::table('families');
        $families -> where('id', $familiesId) -> delete();

        $wallets = DB::table('wallets');
        $wallets -> where('families_id', $familiesId) -> delete();

        $favorite_jobs = DB::table('favorite_jobs');
        $favorite_jobs -> where('families_id', $familiesId) -> delete();

        $favorite_items = DB::table('favorite_items');
        $favorite_items -> where('families_id', $familiesId) -> delete();

        $complete_jobs = DB::table('complete_jobs');
        $complete_jobs -> where('families_id', $familiesId) -> delete();

        $complete_items = DB::table('complete_items');
        $complete_items -> where('families_id', $familiesId) -> delete();
    }


    public function completejob($inputs,$user){
        $compjob = DB::table('complete_jobs');
        $compjob -> insert([
            'jobs_id' => $inputs['id'],
            'users_id' => $user['id'],
            'families_id' => $user['families_id'],
            'created_at' => now()
        ]);
    }


    public function completeitem($inputs,$user){
        $compitem = DB::table('complete_items');
        $compitem -> insert([
            'items_id' => $inputs['id'],
            'users_id' => $user['id'],
            'families_id' => $user['families_id'],
            'created_at' => now()
        ]);

        $items = DB::table('items');
        $item = $items -> where('id', $inputs['id']) -> first();

        $wallets = DB::table('wallets');
        $wallets -> where('id', $user['wallets_id'])
                -> decrement('balance', $item -> price);
    }


    public function favoritejobList($Uid){
        $favoriteJ = DB::table('favorite_jobs as fj');
        $existence = $favoriteJ -> where('fj.users_id', $Uid) -> exists();

        if($existence){
            return $favoriteJ -> select('fj.id', 'fj.created_at','j.name','j.content','j.reward','j.DeleteRole')
                ->join('jobs as j', 'fj.jobs_id', '=', 'j.id')
                ->where('fj.users_id', $Uid) 
                ->orderBy('fj.created_at', 'asc') -> get();
        }else{
            return false;
        }
    }

    public function favoriteitemList($Uid){
        $favoriteI = DB::table('favorite_items as fi');
        $existence = $favoriteI -> where('fi.users_id', $Uid) -> exists();

        if($existence){
            return $favoriteI -> select('fi.id', 'fi.created_at','i.name','i.content','i.price','i.DeleteRole')
                ->join('items as i', 'fi.items_id', '=', 'i.id')
                ->where('fi.users_id', $Uid) 
                ->orderBy('fi.created_at', 'asc') -> get();
        }else{
            return false;
        }
    }

    public function Newfavoritejob($id,$user){
        $FJob = DB::table('favorite_jobs');
        $FJob -> insert([
            'jobs_id' => $id,
            'users_id' => $user['id'],
            'families_id' => $user['families_id'],
            'created_at' => now()
        ]);
    }

    public function Newfavoriteitem($id,$user){
        $FItem = DB::table('favorite_items');
        $FItem -> insert([
            'items_id' => $id,
            'users_id' => $user['id'],
            'families_id' => $user['families_id'],
            'created_at' => now()
        ]);
    }

    public function favoritejobDelete($ID){
        $FJob = DB::table('favorite_jobs');
        return $FJob -> where('id', $ID) -> delete();
    }

    public function favoriteitemDelete($ID){
        $FItem = DB::table('favorite_items');
        return $FItem -> where('id', $ID) -> delete();
    }


    public function HistoryList($Uid){
        $compjob = DB::table('complete_jobs');
        $CJexists = $compjob -> where('complete_jobs.users_id', $Uid)
                            -> where('complete_jobs.flg', 1) -> exists();
        $compitem = DB::table('complete_items');
        $CIexists = $compitem -> where('complete_items.users_id', $Uid)
                            -> where('complete_items.flg', 1) -> exists();

        if($CJexists || $CIexists){
            $completedData = $compjob ->join('jobs', 'complete_jobs.jobs_id', '=', 'jobs.id')
                ->select('complete_jobs.updated_at as completed_at', 'jobs.name', 'jobs.content', DB::raw('CONCAT("+", reward) AS reward'), 'jobs.id as job_id', 'complete_jobs.flg')
                ->where('complete_jobs.users_id', $Uid)
                ->where('complete_jobs.flg', 1)
                ->unionAll($compitem ->join('items', 'complete_items.items_id', '=', 'items.id')
                        ->select('complete_items.updated_at as completed_at', 'items.name', 'items.content', DB::raw('CONCAT("-", price) AS reward'), 'items.id as job_id', 'complete_items.flg')
                        ->where('complete_items.users_id', $Uid)
                        ->where('complete_items.flg', 1)
                )
                ->orderBy('completed_at', 'desc')
                ->get();

    return $completedData;
        }else{
            return false;
        }
    }

    public function searchJob($id, $keyword){
        if (!empty($keyword)) {
            $jobs = DB::table('jobs') -> where('families_id', $id) -> where('DeleteRole', 0);
            $normalizedKeyword = str_replace('　', ' ', $keyword);
            $keywords = explode(' ', $normalizedKeyword);
            
            $jobs->where(function ($query) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $query->orWhere('name', 'like', '%' . $keyword . '%')
                        ->orWhere('content', 'like', '%' . $keyword . '%')
                        ->orWhere('reward', 'like', '%' . $keyword . '%');
                        }
                    });
            $existence = $jobs->exists();
            if($existence){
                return $jobs->get();
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function searchItem($id, $keyword){
        if (!empty($keyword)) {
            $items = DB::table('items') -> where('families_id', $id) -> where('DeleteRole', 0);
            $normalizedKeyword = str_replace('　', ' ', $keyword);
            $keywords = explode(' ', $normalizedKeyword);
            
            $items->where(function ($query) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $query->orWhere('name', 'like', '%' . $keyword . '%')
                        ->orWhere('content', 'like', '%' . $keyword . '%')
                        ->orWhere('price', 'like', '%' . $keyword . '%');
                        }
                    });
            $existence = $items->exists();
            if($existence){
                return $items->get();
            }else{
                return false;
            }
        }else{
            return false;
        }
    }


    public function passlostconf($inputs){
        $users = DB::table('users');

        return $users -> where('email', 'like', $inputs['email'])
                            -> where('primary_school', 'like', $inputs['primary_school']) -> exists();
    }

    public function passreset($email,$pass){
        $users = DB::table('users');

        return $users -> where('email', 'like', $email)
                            -> update(['pass' => password_hash($pass, PASSWORD_DEFAULT), 'updated_at' => now()]);
    }












    public function test(){
        $completedData = DB::table('complete_jobs')
    ->join('jobs', 'complete_jobs.jobs_id', '=', 'jobs.id')
    ->select('complete_jobs.created_at as completed_at', 'jobs.name', 'jobs.content', 'jobs.reward', 'jobs.id as job_id', 'complete_jobs.flg')
    ->where('complete_jobs.flg', 1)
    ->unionAll(
        DB::table('complete_items')
            ->join('items', 'complete_items.items_id', '=', 'items.id')
            ->select('complete_items.created_at as completed_at', 'items.name', 'items.content', 'items.price as reward', 'items.id as job_id', 'complete_items.flg')
            ->where('complete_items.flg', 0)
    )
    ->orderBy('completed_at', 'desc')
    ->get();

    return $completedData;
    }
}