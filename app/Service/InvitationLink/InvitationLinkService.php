<?php

namespace App\Service\InvitationLink;

use App\Models\InvitationLink;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class InvitationLinkService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }


    public function getAllInvitationLinks(Request $request): LengthAwarePaginator
    {

        $invitationlink = InvitationLink::when($request->input('query'), fn($query) =>
            $query->where('name', 'like', '%' . $request->input('query') . '%')
        )->with(['user'])->paginate();

        return $invitationlink;
    }

    public function getInvitationLinkById(string $id): ?InvitationLink
    {
        return InvitationLink::with(['user'])->findOrFail($id);
    }

    public function createInvitationLink(array $data): InvitationLink
    {
        return InvitationLink::create($data);
    }

    public function updateInvitationLink(string $id, array $data): ?InvitationLink
    {
        $invitationlink = InvitationLink::findOrFail($id);
        if (!$invitationlink) {
            abort('404', 'InvitationLink not found');
        }

        $invitationlink->update($data);

        return $invitationlink->fresh();
    }

    public function deleteInvitationLink(string $id): ?bool
    {
        $invitationlink = InvitationLink::findOrFail($id);
        if (!$invitationlink) {
            return null;
        }

        return $invitationlink->delete();
    }

    public function getAllUsers(): array
    {
        $users = User::where('company_id',1)->where('is_active', 1)->get();
        return $users->toArray();
    }
}
