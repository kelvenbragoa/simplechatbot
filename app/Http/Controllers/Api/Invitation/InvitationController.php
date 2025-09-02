<?php

namespace App\Http\Controllers\Api\Invitation;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvitationLink\StoreInvitationLinkRequest;
use App\Http\Requests\InvitationLink\UpdateInvitationLinkRequest;
use App\Service\InvitationLink\InvitationLinkService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    public function __construct(private readonly InvitationLinkService $invitationLinkService)
    {
    }
    public function index(Request $request): JsonResponse
    {
        //

        return response()->json(
            $this->invitationLinkService->getAllInvitationLinks($request)
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $userItems = $this->invitationLinkService->getAllUsers();

        return response()->json([
            'message' => 'success',
            'userItems' => $userItems
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvitationLinkRequest $request)
    {
        try {
            return $this->invitationLinkService->createInvitationLink($request->validated());
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error creating invitation link',
                'error' => $th->getMessage(),
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return response()->json(
            $this->invitationLinkService->getInvitationLinkById($id)
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //

        return response()->json([
            'department' => $this->invitationLinkService->getInvitationLinkById($id),
            'userItems' => $this->invitationLinkService->getAllUsers(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(UpdateInvitationLinkRequest $request, string $id): JsonResponse
    {
        //
        try {
            $updatedInvitationLink = $this->invitationLinkService->updateInvitationLink($id, $request->validated());
            return response()->json($updatedInvitationLink);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error updating invitation link',
                'error' => $th->getMessage(),
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try {
            $invitationLink = $this->invitationLinkService->deleteInvitationLink($id);
            return response()->json(['message' => 'Invitation link deleted successfully']);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error deleting invitation link',
                'error' => $th->getMessage(),
            ], 400);
        }
    }
}
