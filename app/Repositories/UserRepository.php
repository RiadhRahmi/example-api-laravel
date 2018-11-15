<?php

namespace App\Repositories;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;

class UserRepository
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = User::orderBy('id', 'desc')->get();
        return response()->json(['data' => $users, 'status' => Response::HTTP_OK]);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), User::$rulesValidation);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                return response()->json(['data' => $errors,
                    'status' => Response::HTTP_INTERNAL_SERVER_ERROR]);
            } else {
                $user = User::create($request->all());
                return response()->json(['data' => $user, 'status' => Response::HTTP_CREATED]);
            }

        } catch (\Exception $exception) {
            return response()->json(['data' => $exception->getMessage(),
                'status' => Response::HTTP_NOT_FOUND]);
        }

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $user = User::find($id);
            if ($user) {
                return response()->json(['data' => $user, 'status' => Response::HTTP_OK]);
            } else {
                return response()->json(['data' => 'user not found',
                    'status' => Response::HTTP_NOT_FOUND]);
            }
        } catch (\Exception $exception) {
            return response()->json(['data' => $exception->getMessage(),
                'status' => Response::HTTP_NOT_FOUND]);
        }

    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            if ($user) {
                $user->update($request->all());
                return response()->json(['data' => $user, 'status' => Response::HTTP_OK]);
            } else {
                return response()->json(['data' => 'user not found',
                    'status' => Response::HTTP_NOT_FOUND]);
            }
        } catch (\Exception $exception) {
            return response()->json(['data' => $exception->getMessage(),
                'status' => Response::HTTP_NOT_FOUND]);
        }

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        try {
            $ids = $request->input('users_id');
            foreach ($ids as $id) {
                $user = User::findOrFail($id);
                $user->delete();
            }

//            if ($user) {
//
            return response()->json(['data' => 'user deleted successfully',
                'status' => Response::HTTP_OK]);
//            } else {
//                return response()->json(['data' => 'user not found',
//                    'status' => Response::HTTP_NOT_FOUND]);
//            }

        } catch (\Exception $exception) {
            return response()->json(['data' => $exception->getMessage(),
                'status' => Response::HTTP_NOT_FOUND]);
        }

    }


    public function checkUniqueEmail(Request $request){
        try {
            $users = User::where('email',$request->input('email'))->get();
            if ($users) {
                return response()->json(['data' => $users, 'status' => Response::HTTP_OK]);
            } else {
                return response()->json(['data' => 'email not exisite',
                    'status' => Response::HTTP_NOT_FOUND]);
            }
        } catch (\Exception $exception) {
            return response()->json(['data' => $exception->getMessage(),
                'status' => Response::HTTP_NOT_FOUND]);
        }
    }

}