<?php

namespace App\Repositories;

use App\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;


class ArticleRepository
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $title = $request->input('title');
        $author = $request->input('author');

        $publishedAtDate = $request->input('published_at');
        $publishedAtDate = str_replace(" ", "", $publishedAtDate);

        $publishedAtDate = explode("-", $publishedAtDate);
        $publishedAtDateFrom = isset($publishedAtDate[0]) ? $publishedAtDate[0] : '';
        $publishedAtDateTo = isset($publishedAtDate[1]) ? $publishedAtDate[1] : '';

        $articles = Article::filter($title, $author, $publishedAtDateFrom,
            $publishedAtDateTo);
        if ($request->has('export')) {
            $articles = $articles->get(['id', 'title', 'body', 'author', 'published_at']);
        } else {
            $articles = $articles->orderBy('id', 'desc')->paginate(9);
        }
        return response()->json(['data' => $articles, 'status' => Response::HTTP_OK]);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), Article::$rulesValidation);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                return response()->json(['data' => $errors,
                    'status' => Response::HTTP_INTERNAL_SERVER_ERROR]);
            } else {

                $data = $request->all();
                $data['image'] = 'storage/' . $request->file('image')->store('images');
                $article = Article::create($data);
                return response()->json(['data' => $article, 'status' => Response::HTTP_CREATED]);
            }
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