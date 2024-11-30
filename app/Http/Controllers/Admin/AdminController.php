<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    function ShowHome()
    {
        if (auth()->check()) {
            return view('admin.home');
        }
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

    function ShowArchivedFileManager($archivedType)
    {
        return view('admin.archived-file.file-manager', compact('archivedType'));
    }
    function ShowArchivedMunicipality($archivedType, $type)
    {
        return view('admin.archived-file.municipality', compact('archivedType', 'type'));
    }

    function ShowArchivedandTitlesOrPatentedLots($archivedType, $type)
    {
        return view('admin.archived-file.land-title-categories', compact('archivedType', 'type'));
    }
    function ShowArchivedMunicipalityWithCategory($archivedType, $type, $category)
    {
        return view('admin.archived-file.municipality', compact('archivedType', 'type', 'category'));
    }

    function ShowArchivedFileManagerTable($archivedType, $type, $municipality)
    {

        return view('admin.archived-file.table', compact('archivedType', 'type', 'municipality'));
    }

    function ShowArchivedFileManagerTableWithCategory($archivedType, $type, $category, $municipality)
    {
        return view('admin.archived-file.table', compact('archivedType', 'type', 'municipality', 'category'));
    }

    function ShowArchivedAdministrativeDocument($archivedType)
    {
        return view('admin.archived-file.administrative-documents', compact('archivedType'));
    }

    function ShowArchivedAdministrativeDocumentRecord($archivedType, $record)
    {
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
