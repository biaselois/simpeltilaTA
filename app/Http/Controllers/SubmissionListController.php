<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\SubmissionList;
use App\Models\History;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

class SubmissionListController extends Controller {

    public function __construct()
    {
        // Menambahkan middleware untuk memastikan hanya role tertentu yang bisa mengakses
        $this->middleware('auth');
    }

    public function index(): View {
        // Cek apakah role user adalah admin atau approval
        if (Auth::user()->role == 'kasi') {
            // Admin bisa melihat semua submission
            $datas = DB::table('submission_lists as a')
                ->select(
                    'a.id as id',
                    'a.submission_name as name',
                    'a.email as email',
                    'a.nohp as nohp',
                    'a.namappat as namappat',
                    'a.nosertifikat as nosertifikat',
                    'a.latitude as latitude',
                    'a.longitude as longitude',
                    'a.luastanah as luastanah',
                    'a.luasbangunan as luasbangunan',
                    'a.listrik as listrik',
                    'a.tahundibangun as tahundibangun',
                    'a.fotoobjek as fotoobjek',
                    'a.sertifikat as sertifikat',
                    'a.sppt as sppt',
                    'a.bidang as bidang',
                    'a.status as status',
                    'a.note as note',
                    'c.name as approve_by',
                    'a.created_at as created_at',
                    'a.updated_at as updated_at'
                )
                ->leftjoin('users as c', 'c.id', '=', 'a.approve_by')
                ->get();
        } else {
            // Jika user bukan admin, tampilkan hanya submission yang menjadi bagian mereka
            $datas = DB::table('submission_lists as a')
                ->select(
                    'a.id as id',
                    'a.submission_name as name',
                    'a.email as email',
                    'a.nohp as nohp',
                    'a.namappat as namappat',
                    'a.nosertifikat as nosertifikat',
                    'a.latitude as latitude',
                    'a.longitude as longitude',
                    'a.luastanah as luastanah',
                    'a.luasbangunan as luasbangunan',
                    'a.listrik as listrik',
                    'a.tahundibangun as tahundibangun',
                    'a.fotoobjek as fotoobjek',
                    'a.sertifikat as sertifikat',
                    'a.sppt as sppt',
                    'a.bidang as bidang',
                    'a.status as status',
                    'a.note as note',
                    'c.name as approve_by',
                    'a.created_at as created_at',
                    'a.updated_at as updated_at'
                )
                ->leftjoin('users as c', 'c.id', '=', 'a.approve_by')
                ->where('a.approve_by', Auth::user()->id)
                ->get();
        }

        $params = [
            "titlePages" => 'Data Pengajuan Verlok',
            "datas" => $datas,
        ];

        return view('submissionList', $params);
    }

    public function distributeSubmissions(): RedirectResponse {
        // Retrieve all submissions that are not yet assigned to anyone (approve_by is null)
        $submissions = SubmissionList::whereNull('approve_by')->get();

        // Retrieve all users with the 'approval' role
        $approvals = User::where('role', 'kabid')->get();

        // Check if there are users to assign to
        if ($approvals->isEmpty()) {
            return redirect()->back()->with('error', 'No approval users available for assignment');
        }

        // Get the count of submissions
        $submissionCount = $submissions->count();

        if ($submissionCount == 0) {
            return redirect()->back()->with('error', 'No submissions to distribute');
        }

        // Retrieve the count of submissions assigned to each approval user
        $approvalsSubmissionCount = [];
        foreach ($approvals as $approval) {
            $approvalsSubmissionCount[$approval->id] = SubmissionList::where('approve_by', $approval->id)->count();
        }

        // Distribute the submissions based on the approval user with the least submissions
        foreach ($submissions as $submission) {
            // Find the approval user with the least submissions
            $leastAssignedApprovalUser = collect($approvalsSubmissionCount)->min();
            $userToAssign = array_search($leastAssignedApprovalUser, $approvalsSubmissionCount);

            // Assign the submission to this approval user
            $submission->approve_by = $userToAssign;
            $submission->save();

            // Update the submission count for the assigned user
            $approvalsSubmissionCount[$userToAssign]++;

            // Break the loop after all submissions have been assigned
        }

        return redirect()->back()->with('success', 'Submissions have been distributed successfully');
    }




    public function update(Request $request, $id) {
        $submissionList = SubmissionList::findOrFail($id);

        $submissionList->update([
            'note' => $request->note,
            'status' => $request->status,
            'approve_by' => Auth::user()->id,
            'updated_at' => now(),
        ]);


        return redirect()->back();
    }

    public function destroy(Request $request) {
        $submissionList = SubmissionList::findOrFail($request->id);

        if ($submissionList) {
            $submissionList->delete();



            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'Submission not found'], 404);
    }
}
