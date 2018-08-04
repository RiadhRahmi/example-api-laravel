<?php

namespace App\Repositories;

use App\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ArticleRepository
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $articles = Article::all();
        return response()->json(['data' => $articles, 'status' => Response::HTTP_OK]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $article = Article::create($request->all());
            return response()->json(['data' => $article, 'status' => Response::HTTP_CREATED]);
        } catch (\Exception $exception) {
            return response()->json(['data' => $exception->getMessage(), 'status' => Response::HTTP_NOT_FOUND]);
        }

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $article = Article::find($id);
            if ($article) {
                return response()->json(['data' => $article, 'status' => Response::HTTP_OK]);
            } else {
                return response()->json(['data' => 'article not found', 'status' => Response::HTTP_NOT_FOUND]);
            }
        } catch (\Exception $exception) {
            return response()->json(['data' => $exception->getMessage(), 'status' => Response::HTTP_NOT_FOUND]);
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
            $article = Article::findOrFail($id);
            if ($article) {
                $article->update($request->all());
                return response()->json(['data' => $article, 'status' => Response::HTTP_OK]);
            } else {
                return response()->json(['data' => 'article not found', 'status' => Response::HTTP_NOT_FOUND]);
            }
        } catch (\Exception $exception) {
            return response()->json(['data' => $exception->getMessage(), 'status' => Response::HTTP_NOT_FOUND]);
        }

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $article = Article::findOrFail($id);
            if ($article) {
                $article->delete();
                return response()->json(['data' => 'article deleted successfully', 'status' => Response::HTTP_OK]);
            } else {
                return response()->json(['data' => 'article not found', 'status' => Response::HTTP_NOT_FOUND]);
            }

        } catch (\Exception $exception) {
            return response()->json(['data' => $exception->getMessage(), 'status' => Response::HTTP_NOT_FOUND]);
        }

    }


}