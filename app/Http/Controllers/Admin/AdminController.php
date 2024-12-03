<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Middleware\VerifiedUser;
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
        return view('admin.archived-file.table', compact('archivedType', 'type', 'municipality'));
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

    function ShowQrRedirect()
    {
        return view('admin.qr-redirect');
    }
}
