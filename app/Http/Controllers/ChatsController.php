<?php

namespace App\Http\Controllers;

use App\Entities\Chat;
use App\Entities\User;
use App\Events\ChatEvent;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ChatCreateRequest;
use App\Http\Requests\ChatUpdateRequest;
use App\Repositories\ChatRepository;
use App\Validators\ChatValidator;
use Illuminate\Support\Facades\Auth;

/**
 * Class ChatsController.
 *
 * @package namespace App\Http\Controllers;
 */
class ChatsController extends Controller
{
    /**
     * @var ChatRepository
     */
    protected $repository;

    /**
     * @var ChatValidator
     */
    protected $validator;

    /**
     * ChatsController constructor.
     *
     * @param ChatRepository $repository
     * @param ChatValidator $validator
     */
    public function __construct(ChatRepository $repository, ChatValidator $validator)
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
        $chats = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $chats,
            ]);
        }

        return view('chats.index', compact('chats'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ChatCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(ChatCreateRequest $request)
    {
        try {
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $chat = $this->repository->create($request->all());

            event(new ChatEvent($request->to_user_id,$chat));

            $response = [
                'message' => 'Chat created.',
                'data'    => $chat->toArray(),
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
    public function show(User $toUser)
    {
       // $chats = $this->repository->with('toUser')->with('fromUser')->findWhere(['to_user_id'=> $toUserid,'from_user_id'=> Auth::user()->id]);
        $chats = Chat::where([['to_user_id', '=', $toUser->id],['from_user_id', '=', Auth::user()->id]])
                            ->orWhere([['to_user_id','=',Auth::user()->id],['from_user_id','=',$toUser->id]])
                            ->orderBy('created_at','asc')
                            ->get();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $chats,
            ]);
        }

        return view('chats.show', compact('chats','toUser'));
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
        $chat = $this->repository->find($id);

        return view('chats.edit', compact('chat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ChatUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(ChatUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $chat = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Chat updated.',
                'data'    => $chat->toArray(),
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
                'message' => 'Chat deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Chat deleted.');
    }
}
