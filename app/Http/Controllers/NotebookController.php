<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotebookPostRequest;
use App\Http\Requests\NotebookUpdateRequest;
use App\Models\Notebook;
use App\Services\NotebookService;
use Illuminate\Http\Request;
use Laravel\Prompts\Note;

class NotebookController extends Controller
{
    /**
     * @OA\Info(
     *      title="FutureGroup",
     *      version="1.0.0",
     *      @OA\Contact(
     *          email="sohibjon.developer@mail.ru"
     *      ),
     *      @OA\License(
     *          name="MIT",
     *          url="https://opensource.org/licenses/MIT"
     *      )
     * )
   
     * @OA\Get(
     *      path="/api/v1/notebook",
     *      operationId="getNotebooksList",
     *      tags={"Notebook"},
     *      summary="Notes",
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="Notebook::class")
     *      ),
     *      @OA\Parameter(
     *          name="page",
     *          in="query",
     *          required=false,
     *          description="page",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="limit",
     *          in="query",
     *          required=false,
     *          description="limit",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),

     * )
     
     * @OA\Get(
     *      path="/api/v1/notebook/{id}",
     *      operationId="getNotebookById",
     *      tags={"Notebook"},
     *      summary="note by ID",
     *      description="single note",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="id of note",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              ref="Notebook::class"
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Note not found"
     *      )
     * )
     * 
     * 
     * @OA\Post(
     *      path="/api/v1/notebook",
     *      operationId="PostNotebook",
     *      tags={"Notebook"},
     *      summary="Post note",
     *      description="Post note",
     *      @OA\Parameter(
     *          name="fio",
     *          in="query",
     *          required=true,
     *          description="Fio",
     *          @OA\Schema(
     *              type="string",
     *              
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="company",
     *          in="query",
     *          required=false,
     *          description="Company",
     *          @OA\Schema(
     *              type="string",
     *              
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="phone",
     *          in="query",
     *          required=true,
     *          description="phone",
     *          @OA\Schema(
     *              type="string",
     *              
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="email",
     *          in="query",
     *          required=true,
     *          description="email",
     *          @OA\Schema(
     *              type="string",
     *              
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="born_date",
     *          in="query",
     *          required=false,
     *          description="born date",
     *          @OA\Schema(
     *              type="string",
     *              format="date"
     *          )
     *      ),
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"photo"},
     *                 @OA\Property(
     *                     property="photo",
     *                     description="Photo",
     *                     type="string",
     *                     format="binary"
     *                 )
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              ref="Notebook::class"
     *          )
     *      )
     * )
     * 
     * 
    
     * @OA\Post(
     *      path="/api/v1/notebook/{id}",
     *      operationId="updateNote",
     *      tags={"Notebook"},
     *      summary="Update note",
     *      description="Update ",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of note",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(
     *                      property="fio",
     *                      type="string",
     *                      description="New FIO"
     *                  ),
     *                  @OA\Property(
     *                      property="company",
     *                      type="string",
     *                      description="New company"
     *                  ),
     *                  @OA\Property(
     *                      property="phone",
     *                      type="string",
     *                      description="New phone"
     *                  ),
     *                  @OA\Property(
     *                      property="email",
     *                      type="string",
     *                      description="New Email"
     *                  ),
     *                  @OA\Property(
     *                      property="born_date",
     *                      type="date",
     *                      description="New Born date"
     *                  ),
     *                     @OA\Property(
     *                      property="photo",
     *                      type="file",
     *                      format="binary",
     *                      description="New photo"
     *                  ),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server Error",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Success"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Notebook not found"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error"
     *      ),
     *  
     * )
     * 
       
     * @OA\Delete(
     *      path="/api/v1/notebook/{id}",
     *      operationId="deleteNote",
     *      tags={"Notebook"},
     *      summary="delete note by ID",
     *      description="delete note",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of note",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              ref="Notebook::class"
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Note not found"
     *      )
     * )
     * 
     */

    private $service;
    public function __construct(NotebookService $service)
    {
        $this->service = $service;
    }
    public function index(Request $request)
    {

        $limit = $request->get('limit', 10);
        $page = $request->get('page', 1);

        $notes = $this->service->index($limit, $page);

        return response()->json([
            'notebooks' => $notes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NotebookPostRequest $request)
    {
        $data = $request->validated();

        $store = $this->service->store($request, $data);

        if ($store) {
            return response()->json([
                'status' => 'success'
            ], 201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $notebook = $this->service->show($id);

        if (!$notebook) {
            return response()->json([
                'error' => 'Note not found'
            ]);
        }

        return response()->json([
            'notebook' => $notebook
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notebook $notebook)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NotebookUpdateRequest $request, $id)
    {

        $notebook = Notebook::find($id);

        if (!$notebook) {
            return response()->json([
                'error' => 'Note not found'
            ],404);
        }
        
        $data = $request->validated();

        $update = $this->service->update($request, $notebook, $data);

        if ($update) {
            return response()->json([
                'status' => 'success'
            ], 200);
        }


        return response()->json([
            'status' => 'error',

        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $notebook = Notebook::find($id);

        if (!$notebook) {
            return response()->json([
                'error' => 'Note not found'
            ]);
        }

        $delete = $this->service->destroy($notebook);

        if ($delete) {
            return response()->json([
                'status' => 'success'
            ], 204);
        }

        return response()->json([
            'status' => 'error'
        ]);
    }
}
