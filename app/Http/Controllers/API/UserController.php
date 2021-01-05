<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends Controller
{
    public $successStatus = 200;

    /** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function login(Request $request)
    {
        //#############################
        #    uncomment below for firebase
        ########################################
        // $auth = app('firebase.auth');
        // $idTokenString = $request->input('Firebasetoken');

        // try { // Try to verify the Firebase credential token with Google
        //     $verifiedIdToken = $auth->verifyIdToken($idTokenString);
        // } catch (\InvalidArgumentException $e) { // If the token has the wrong format
        //     return response()->json([
        //         'message' => 'Unauthorized - Can\'t parse the token: ' . $e->getMessage()
        //     ], 401);
        // } catch (InvalidToken $e) { // If the token is invalid (expired ...)
        //     return response()->json([
        //         'message' => 'Unauthorized - Token is invalide: ' . $e->getMessage()
        //     ], 401);
        // }

        // // Retrieve the UID (User ID) from the verified Firebase credential's token
        // $uid = $verifiedIdToken->getClaim('sub');
        // // Retrieve the user model linked with the Firebase UID
        // $user = User::where('firebaseUID', $uid)->first();

        // if ($user) {
        //     // Once we got a valid user model
        //     // Create a Personnal Access Token
        //     $tokenResult = $user->createToken('Personal Access Token');
        //     // Store the created token
        //     $token = $tokenResult->token;
        //     // Add a expiration date to the token
        //     $token->expires_at = Carbon::now()->addWeeks(1);
        //     // Save the token to the user
        //     $token->save();
        //     // Return a JSON object containing the token datas
        //     // You may format this object to suit your needs
        //     return response()->json([
        //         'id' => $user->id,
        //         'access_token' => $tokenResult->accessToken,
        //         'token_type' => 'Bearer',
        //         'expires_at' => Carbon::parse(
        //             $tokenResult->token->expires_at
        //         )->toDateTimeString()
        //     ]);
        // } else {
        //     return response()->json(['message' => 'User not register.']);
        // }

        ####################
        #          firebase code end
        #######################

        $user = User::where('mobilenumber', $request->mobilenumber)->first();

        if ($user) {
            // Create a Personnal Access Token
            $tokenResult = $user->createToken('Personal Access Token');
            // Store the created token
            $token = $tokenResult->token;
            // Add a expiration date to the token
            // $token->expires_at = Carbon::now()->addWeeks(1);
            // Save the token to the user
            $token->save();
            // Return a JSON object containing the token datas
            // You may format this object to suit your needs
            return response()->json([
                'id' => $user->id,
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer'
            ]);
        } else {
                return response()->json(['message' => 'User not register.']);
            }


    }

    /** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'mobilenumber' => 'required',
            'email_id' => 'required|email',
            'college_name' => 'required',
            'college_id_number' => 'required',
            'profession' => 'required',
            'dob' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $upload_path = 'images/';
        $profile_image_url = null;
        $college_id_image_url = null;
        if ($request->file('avatar')) {
            $profileImage = $request->file('avatar');
            $profileImageSaveAsName = time() . $request->mobilenumber . "-profile." . $profileImage->getClientOriginalExtension();
            $profile_image_url = $upload_path . $profileImageSaveAsName;
        }

        if ($request->file('college_id_details')) {
            # code...
            $collegeIdImage = $request->file('college_id_details');
            $collegeIdImageSaveAsName = time() . $request->mobilenumber . "-profile." . $collegeIdImage->getClientOriginalExtension();
            $college_id_image_url = $upload_path . $collegeIdImageSaveAsName;
            $success = $profileImage->move($upload_path, $profileImageSaveAsName);
        }



        $user =  User::create([
            'name' => $request->name,
            'email_id' => $request->email_id,
            'mobilenumber' => $request->mobilenumber,
            'college_name' => $request->college_name,
            'college_id_number' => $request->college_id_number,
            'profession' => $request->profession,
            'dob' => $request->dob,
            'avtar' => $profile_image_url,
            'college_id_details' => $college_id_image_url,
        ]);


        // $input = $request->all();
        // $input['password'] = bcrypt($input['password']);
        // $user = User::create($input);
        $success['message'] =  "Success";
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;
        $success['email_id'] =  $user->email_id;
        $success['mobilenumber'] =  $user->mobilenumber;
        return response()->json(['success' => $success], $this->successStatus);
    }


    public function getAllUserName()
    {
        error_log('User');
        return User::all();
    }

    public function storeAllUserName(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            
           
            'name'  => 'required',
            'mobilenumber' => 'required',
            'email_id' => 'required',
            'college_name' => 'required',
            'college_id_number' => 'required',
            'profession' => 'required',
            'dob' => 'required',
            'active_status' => 'required',
               
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
    
        error_log('Rashmi was here');
        $user = User::create($request->all());
        return response()->json([
            "message" => "User stored",
        ], 201);
    
    }

}
