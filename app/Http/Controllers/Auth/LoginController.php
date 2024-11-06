<?php
namespace App\Http\Controllers\Auth;

use App\Dto\ApiResponseDto;
use App\Dto\LoginResponseDto;
use App\Http\Requests\LoginRequest;
use App\Repository\UserRepository;
use Illuminate\Support\Facades\Log;

class LoginController{

    public $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function login(LoginRequest $loginRequest){
        try {
            $loginRequest->authenticate();
            $loginRequest->session()->regenerate();
    
            $user = $this->userRepository->findByEmail($loginRequest->email);
    
             /*
             in a real world scenario you can determine how often 
             you want to delete and recreate user tokens
             */
            $user->tokens()->delete();
            
            $token = $user->createToken($user->email);

            $loginResponse = new LoginResponseDto($user->fullname, $user->email, $token->plainTextToken);

            return response()->json($loginResponse);
        } catch (\Exception $ex) {
            return response()->json(new ApiResponseDto(false, $ex->getMessage(),null));   
        }
    }
}