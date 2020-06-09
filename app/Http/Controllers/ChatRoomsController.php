<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ChatRoomCreateRequest;
use App\Http\Requests\ChatRoomUpdateRequest;
use App\Repositories\ChatRoomRepository;
use App\Validators\ChatRoomValidator;

/**
 * Class ChatRoomsController.
 *
 * @package namespace App\Http\Controllers;
 */
class ChatRoomsController extends Controller
{
    /**
     * @var ChatRoomRepository
     */
    protected $repository;

    /**
     * @var ChatRoomValidator
     */
    protected $validator;

    /**
     * ChatRoomsController constructor.
     *
     * @param ChatRoomRepository $repository
     * @param ChatRoomValidator $validator
     */
    public function __construct(ChatRoomRepository $repository, ChatRoomValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $chatRooms = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $chatRooms,
            ]);
        }

        return view('chatRooms.index', compact('chatRooms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ChatRoomCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(ChatRoomCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $chatRoom = $this->repository->create($request->all());

            $response = [
                'message' => 'ChatRoom created.',
                'data'    => $chatRoom->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $chatRoom = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $chatRoom,
            ]);
        }

        return view('chatRooms.show', compact('chatRoom'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $chatRoom = $this->repository->find($id);

        return view('chatRooms.edit', compact('chatRoom'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ChatRoomUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(ChatRoomUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $chatRoom = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'ChatRoom updated.',
                'data'    => $chatRoom->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'ChatRoom deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'ChatRoom deleted.');
    }
}
