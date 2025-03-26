<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Middleware\VerifiedUser;
use Illuminate\Support\Facades\Artisan;
use App\Models\File;
class AdminController extends Controller
{
    //
    public function ShowHome(Request $request)
    {
        // Check if the user is authenticated
        if (auth()->check()) {
            // User is authenticated, check if email is verified
            if (auth()->user()->email_verified_at) {
                // Verified user, show the admin home
                return view('admin.home');
            }

            // Unverified user, redirect using the VerifiedUser middleware logic
            return app(VerifiedUser::class)->handle($request, function () {
                // The middleware will redirect the unverified user, no need for additional logic here
            });
        }

        // For guests (non-logged-in users), show the welcome page
        return view('welcome');
    }



    function ShowFileManager()
    {
        Artisan::call('files:archive');
        return view('admin.file-manager.file-manager');
    }

    function ShowMunicipality(Request $request)
    {
        $type = $request->query('type');
        $category = $request->query('category') ?? null;
        if (!$type) {
            abort(404);
        }
        return view('admin.file-manager.municipality', compact('type', 'category'));
    }

    function ShowLandTitlesOrPatentedLots(Request $request)
    {

        $type = $request->query('type');
        if (!$type) {
            abort(404);
        }
        return view('admin.file-manager.land-title-categories', compact('type'));
    }

    function ShowTable(Request $request)
    {
        $type = $request->query('type');
        $municipality = $request->query('municipality') ?? null;
        $category = $request->query('category') ?? null;
        if (!$type || !$municipality) {
            abort(404);
        }
        return view('admin.file-manager.table', compact('type', 'municipality', 'category'));
    }

    function ShowAdministrativeDocuments()
    {
        Artisan::call('files:archive');
        return view('admin.administrative.administrative-documents');
    }

    function ShowRecord(Request $request)
    {
        $record = $request->query('record');
        // if (!$record) {
        //     abort(404);
        // }
        return view('admin.administrative.records', compact('record'));
    }

    function ShowArchivedFiles()
    {
        Artisan::call('files:archive');
        return view('admin.archived-file.archive-type');
    }

    function ShowArchivedFileManager()
    {
        $archivedType = "File Manager";
        return view('admin.archived-file.file-manager', compact('archivedType'));
    }
    function ShowArchivedMunicipality(Request $request)
    {
        $archivedType = "File Manager";
        $type = $request->query('type');
        $category = $request->query('category') ?? null;
        if (!$type) {
            abort(404);
        }
        return view('admin.archived-file.municipality', compact('archivedType', 'type', 'category'));
    }

    function ShowArchivedandTitlesOrPatentedLots(Request $request)
    {
        $archivedType = "File Manager";
        $type = $request->query('type');
        if (!$type) {
            abort(404);
        }
        return view('admin.archived-file.land-title-categories', compact('archivedType', 'type'));
    }

    function ShowArchivedFileManagerTable(Request $request)
    {
        $type = $request->query('type');
        $municipality = $request->query('municipality');
        $archivedType = "File Manager";
        $category = $request->query('category') ?? null;
        return view('admin.archived-file.table', compact('archivedType', 'type', 'municipality', 'category'));
    }


    function ShowArchivedAdministrativeDocument(Request $request)
    {
        $archivedType = "Administrative Document";
        return view('admin.archived-file.administrative-documents', compact('archivedType'));
    }

    function ShowArchivedAdministrativeDocumentRecord(Request $request)
    {
        $archivedType = "Administrative Document";
        $record = $request->query('record');
        return view('admin.archived-file.records', compact('archivedType', 'record'));
    }

    function ShowBackupAndRecover()
    {
        return view('backup.backup');
    }

    function ShowSetting()
    {
        return view("settings");
    }

    function ShowQR()
    {
        return view('admin.scanQr');
    }

    function ShowQrRedirect($id)
    {
        $fileId = $id;
        return view('admin.qr-redirect', compact('fileId'));
    }

    function ShowFileHistory($fileId)
    {

        return view('admin.file-histories', compact('fileId'));
    }

    function ShowFileSummary($file_id)
    {

        // $file = File::firstOrFail($fileId);

        $fileId = $file_id;
        $file = File::where('id', $fileId)->first();
        $type = $file->permit_type;
        $record = $file->report_type;


        return view('admin.qr-file-summary', compact('fileId', 'type', 'record'));
    }
    function ShowButterflyList()
    {
        return view('admin.butterfly.butterfly-list');
    }

    function ShowButterflyAdd()
    {
        return view('admin.butterfly.butterfly-add');
    }

    function ShowButterflyEdit()
    {
        return view('admin.butterfly.butterfly-edit');
    }

    function ShowChainsawCategories()
    {

        return view('admin.file-manager.chainsaw-categories');
    }

    function ShowArchivedChainsawCategories()
    {
        return view('admin.archived-file.chainsaw-categories');
    }

    function ShowMaintenance()
    {
        return view('admin.maintenance.maintenance');
    }

    function ShowReports()
    {
        return view('reports.reports');
    }

    function ShowTreeCuttingReport()
    {
        return view('reports.tree-cutting-permit');
    }

    function ShowTreePlantationReport()
    {
        return view('reports.tree-plantation-permit');
    }

    function ShowTransportPermitReport()
    {
        return view('reports.transport-permit');
    }

    function ShowChainsawRegistrationReport()
    {
        return view('reports.chainsaw-registration');
    }

    function ShowLandTitlesReport()
    {
        return view('reports.land-titles');
    }

    function ShowLocalTransportPermitReport()
    {
        return view('reports.local-transport-permit');
    }




    function ShowMaintenanceTable()
    {
        return view('admin.maintenance.table');
    }

}
