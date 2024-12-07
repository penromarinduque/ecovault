<?php

namespace App\Http\Controllers\FileSharing;
use App\Events\SimpleEvent;
use App\Models\FileShares;
use App\Models\FileHistory;
use App\Models\FileAccessRequests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\File;
use App\Notifications\FileShareNotification;
use App\Notifications\FileAccessNotification;
use Notification;
use Illuminate\Support\Facades\DB;

class FileShareController extends Controller
{
    public function ShareFile(Request $request)
    {
        $validated = $request->validate([
            'file_id' => 'required|exists:files,id',
            'shared_with_user_id' => 'required|exists:users,id',
            'remarks' => 'nullable|string',
            'expiration_date' => 'required|date_format:m-d-Y' // Validate the date in "mm-dd-yyyy" format
        ]);

        try {
            $senderId = auth()->id();
            $fileId = $validated['file_id'];
            $receiverId = $validated['shared_with_user_id'];
            $remarks = $validated['remarks'];
            $expirationDate = \Carbon\Carbon::createFromFormat('m-d-Y', $validated['expiration_date']);

            // Check if the expiration date is in the past
            if (\Carbon\Carbon::now()->greaterThan($expirationDate)) {
                return response()->json([
                    'success' => false,
                    'message' => 'The expiration date cannot be in the past.',
                ], 400);
            }

            // Check if the file has already been shared with the user
            $existingShare = FileShares::where('file_id', $fileId)
                ->where('shared_with_user_id', $receiverId)
                ->first();

            if ($existingShare) {
                // If the existing share is not expired, prevent creating a new share
                if (\Carbon\Carbon::now()->lessThan($existingShare->expiration_date)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'This file has already been shared with the specified user and the share has not expired yet.',
                    ], 400);
                }
            }

            // Create the file share record
            FileShares::create([
                'file_id' => $fileId,
                'shared_with_user_id' => $receiverId,
                'shared_by_admin_id' => $senderId,
                'expiration_date' => $expirationDate
            ]);


            $user = User::findOrFail($receiverId);

            FileHistory::create([
                'file_id' => $fileId,
                'action' => 'file shared to ' . $user->name,
                'user_id' => auth()->id() ?: 0, // Fallback to a default user ID (0 or system user)
            ]);
            // Send notification to the user
            $user->notify(new FileShareNotification($fileId, $receiverId, $senderId, $remarks, 'shared file'));

            return response()->json([
                'success' => true,
                'message' => 'File shared successfully!',
                'user' => $user->name
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error sharing file: ' . $e->getMessage(),
            ], 500);
        }
    }




    public function StoreRequest(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'file_id' => 'required|exists:files,id',
            'remarks' => 'nullable|string|max:255',
        ]);


        // Check if there is an existing request for the same file by the same user
        $existingRequest = FileAccessRequests::where('file_id', $request->file_id)
            ->where('requested_by_user_id', auth()->id())
            ->first();

        if ($existingRequest) {
            // If the existing request is still pending, inform the user
            if ($existingRequest->status === 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already submitted a request for this file. Please wait for admin approval or rejection.',
                ], 200); // 400 Bad Request
            } elseif ($existingRequest->status === 'approved') {
                return response()->json([
                    'success' => false,
                    'message' => 'Your request has already been approved.',
                ], 200);
            } elseif ($existingRequest->status === 'rejected') {
                // Optionally, you can allow resubmission if the previous request was rejected
                // You might want to reset the remarks or permission
                $existingRequest->update([
                    'remarks' => $request->remarks,
                    'status' => 'pending', // Reset status to pending for resubmission
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Your previous request was rejected. A new request has been submitted successfully.',
                    'data' => $existingRequest,
                ], 200); // 200 OK
            }
        }
        $senderId = auth()->id();
        $fileId = $request->file_id;
        $remarks = $request->remarks;  // Use the remarks field for the message

        $fileAccessRequest = FileAccessRequests::create([
            'file_id' => $request->file_id,
            'requested_by_user_id' => auth()->id(),
            'remarks' => $request->remarks,
            'status' => 'pending', // Default status when creating a new request
        ]);

        $admins = User::where('isAdmin', true)->get(); // Or find the appropriate admin

        $user = User::findOrFail($senderId);

        $history = FileHistory::create([
            'file_id' => $request->file_id,
            'action' => $user->name . ' has request for this file',
            'user_id' => auth()->id(), // Fallback to a default user ID (0 or system user)
        ]);

        $notification = new FileAccessNotification(
            $fileId,       // The ID of the file
            null,          // Receiver ID is null since it's for admins
            $senderId,     // Sender's ID (the user who wants to access the file)
            $remarks,  // Remarks/message
            'request access', // Notification type
            'pending',     // Status
            'admin'        // Recipient is admin
        );
        Notification::send($admins, $notification);

        // Return a JSON response with the created request data
        return response()->json([
            'success' => true,
            'message' => 'Access request submitted successfully.',
            'data' => [
                'id' => $fileAccessRequest->id,
                'file_id' => $fileAccessRequest->file_id,
                'requested_by_user_id' => $fileAccessRequest->requested_by_user_id,
                'remarks' => $fileAccessRequest->remarks,
                'status' => $fileAccessRequest->status,
                'created_at' => $fileAccessRequest->created_at,
                'updated_at' => $fileAccessRequest->updated_at,
            ],
        ], 201); // 201 Created status code
    }

    public function GetFileAccessRequests()
    {
        try {

            $requests = FileAccessRequests::with(['requestedBy:id,name', 'handledBy:id,name', 'file:id,file_name'])->get();

            return response()->json([
                'success' => true,
                'message' => 'File shared successfully!',
                'requests' => $requests
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error sharing file: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function UpdateRequestStatus($id, Request $request)
    {
        $status = $request->status;

        if (!in_array($status, ['pending', 'approved', 'rejected'])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid status value provided.',
            ], 400);
        }

        $fileAccessRequest = FileAccessRequests::find($id);

        if (!$fileAccessRequest) {
            return response()->json([
                'success' => false,
                'message' => 'File access request not found.',
            ], 404);
        }

        $fileAccessRequest->update([
            'status' => $status,
            'handled_by_admin_id' => auth()->id(),
        ]);
        $userId = $fileAccessRequest->requested_by_user_id;
        if ($status === 'approved') {
            FileShares::create([
                'file_id' => $fileAccessRequest->file_id,
                'shared_with_user_id' => $fileAccessRequest->requested_by_user_id,
                'shared_by_admin_id' => auth()->id(),
            ]);
        }

        $user = User::where('id', $userId)->firstOrFail();

        FileHistory::create([
            'file_id' => $fileAccessRequest->file_id,
            'action' => 'Admin has ' . $status . ' for the request of ' . $user->name,
            'user_id' => auth()->id(), // Fallback to a default user ID (0 or system user)
        ]);
        return response()->json([
            'success' => true,
            'message' => 'File access request status updated successfully!',
            'data' => $fileAccessRequest,
            'user' => $user->name
        ]);
    }



    public function GetSharedFilesById(Request $request)
    {
        if (!$request->query('user_id')) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching file'
            ], 500);
        }

        $userId = $request->query('user_id');

        $results = DB::table('file_shares')
            ->select(
                'file_shares.*',
                'shared_with_user.name as shared_with_name',
                'shared_by_admin.name as shared_by_name',
                'files.file_name',
                'files.file_path',
                'files.permit_type',
                'files.land_category',
                'files.municipality',
                'files.report_type',
                'files.office_source',
                'files.classification',
                'files.is_archived'
            )
            ->join('users as shared_with_user', 'file_shares.shared_with_user_id', '=', 'shared_with_user.id')
            ->join('users as shared_by_admin', 'file_shares.shared_by_admin_id', '=', 'shared_by_admin.id')
            ->join('files', 'file_shares.file_id', '=', 'files.id')
            ->whereRaw($userId) // Replace `2` with the actual condition
            ->get();
        return response()->json([
            'success' => true,
            'message' => 'Success',
            'sharewithme' => $results
        ], 200);
    }
}
