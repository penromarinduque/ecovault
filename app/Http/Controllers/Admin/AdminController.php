<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    function ShowHome()
    {

        return view('admin.home');
    }

    function ShowFileManager()
    {
        return view('admin.file-manager.file-manager');
    }

    function ShowMunicipality($type)
    {
        return view('admin.file-manager.municipality', compact('type'));
    }

    function ShowMunicipalityWithCategory($type, $category)
    {
        return view('admin.file-manager.municipality', compact('type', 'category'));
    }

    function ShowLandTitlesOrPatentedLots($type)
    {

        return view('admin.file-manager.land-title-categories', compact('type'));
    }

    function ShowTable($type, $municipality)
    {
        return view('admin.file-manager.table', compact('type', 'municipality'));
    }
    function ShowTableWithCategory($type, $category, $municipality)
    {
        return view('admin.file-manager.table', compact('type', 'category', 'municipality'));
    }

    function ShowAdministrativeDocuments()
    {
        return view('admin.administrative.administrative-documents');
    }

    function ShowRecord($record)
    {
        return view('admin.administrative.records', compact('record'));
    }

    function ShowArchivedFiles()
    {
        return view('admin.archived-file.archive-type');
    }

    function ShowArchivedFileManager()
    {
        return view('admin.archived-file.file-manager');
    }

    function ShowArchivedMunicipality($type)
    {
        return view('admin.archived-file.municipality', compact('type'));
    }

    function ShowArchivedandTitlesOrPatentedLots($type)
    {
        return view('admin.archived-file.land-title-categories', compact('type'));
    }
    function ShowArchivedMunicipalityWithCategory($type, $category)
    {
        return view('admin.archived-file.municipality', compact('type', 'category'));
    }

    function ShowArchivedFileManagerTable($type, $municipality)
    {

        return view('admin.archived-file.table', compact('type', 'municipality'));
    }

    function ShowArchivedAdministrativeDocument()
    {
        return view('admin.archived-file.administrative-documents');
    }

    function ShowArchivedAdministrativeDocumentRecord($record)
    {
        return view('admin.archived-file.records', compact('record'));
    }

    function ShowBackupAndRecover()
    {
        return view('backup.backup');
    }
}
