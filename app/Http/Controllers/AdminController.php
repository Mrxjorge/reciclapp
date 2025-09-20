<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pickup;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Mostrar todos los usuarios
    public function index()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    // Descargar reporte de usuarios
    public function downloadReport()
    {
        // Lógica para generar el reporte
        // Si se usa Laravel Excel o generación de CSV
        return response()->stream(function () {
            echo "id,name,email\n";
            foreach (User::all() as $user) {
                echo "{$user->id},{$user->name},{$user->email}\n";
            }
        }, 200, [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=users_report.csv",
        ]);
    }

    // Gestionar recolecciones
    public function managePickups()
    {
        $pickups = Pickup::all();
        return view('admin.pickups', compact('pickups'));
    }

    // Exportar usuarios a CSV
    public function exportUsersCsv()
    {
        // Lógica para exportar usuarios
        return response()->stream(function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Name', 'Email']); // Cabecera CSV
            foreach (User::all() as $user) {
                fputcsv($handle, [$user->id, $user->name, $user->email]);
            }
            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="users.csv"',
        ]);
    }
}
